<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Postcode;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Models\Sector;
use LaravelEnso\Addresses\Models\Township;
use LaravelEnso\Addresses\Traits\Addressable;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Country $country;
    private AddressableTestModel $addressable;
    private Address $address;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs($this->user = User::first());

        $this->createTestTables();

        $this->country = Country::factory()->create(['is_active' => true]);
        Config::set('enso.addresses.defaultCountryId', $this->country->id);

        $this->addressable = AddressableTestModel::create(['name' => 'addressable']);

        ['region' => $region, 'locality' => $locality] = $this->geographyFor($this->country);

        $this->address = Address::create([
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'street'           => 'Main street 1',
            'postcode'         => '010101',
            'is_default'       => true,
            'is_billing'       => true,
            'is_shipping'      => true,
            'created_by'       => $this->user->id,
        ]);
    }

    #[Test]
    public function can_create_address()
    {
        ['region' => $region, 'locality' => $locality] = $this->geographyFor($this->country, 'Create Region', 'Create Locality');

        $params = $this->addressParams([
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'street'           => 'Created street',
        ]);

        $this->post(route('core.addresses.store'), $params)
            ->assertStatus(200)
            ->assertJsonStructure(['message', 'address' => ['id']]);

        $this->assertTrue(Address::query()
            ->whereAddressableId($this->addressable->id)
            ->whereAddressableType(AddressableTestModel::class)
            ->whereStreet('Created street')
            ->exists());
    }

    #[Test]
    public function returns_addresses_only_for_requested_addressable()
    {
        $otherAddressable = AddressableTestModel::create(['name' => 'other']);

        Address::create([
            'addressable_id'   => $otherAddressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'street'           => 'Other street',
            'is_default'       => true,
            'is_billing'       => false,
            'is_shipping'      => false,
            'created_by'       => $this->user->id,
        ]);

        $route = route('core.addresses.index', [
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
        ], false);

        $this->get($route)
            ->assertStatus(200)
            ->assertJsonFragment(['street' => $this->address->street])
            ->assertJsonMissing(['street' => 'Other street']);
    }

    #[Test]
    public function can_update_address()
    {
        $route = route('core.addresses.update', $this->address, false);

        $this->patch($route, array_merge($this->addressParams(), [
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $this->address->region_id,
            'locality_id'      => $this->address->locality_id,
            'street'           => 'Edited street',
        ]))
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertSame('Edited street', $this->address->fresh()->street);
    }

    #[Test]
    public function can_set_default_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeDefault', $secondaryAddress, false);

        $this->patch($route)->assertStatus(200);

        $this->assertFalse($this->address->fresh()->is_default);
        $this->assertTrue($secondaryAddress->fresh()->is_default);
    }

    #[Test]
    public function can_set_billing_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeBilling', $secondaryAddress, false);

        $this->patch($route)->assertStatus(200);

        $this->assertTrue($secondaryAddress->fresh()->is_billing);
    }

    #[Test]
    public function can_set_shipping_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeShipping', $secondaryAddress, false);

        $this->patch($route)->assertStatus(200);

        $this->assertTrue($secondaryAddress->fresh()->is_shipping);
    }

    #[Test]
    public function can_get_create_address_form()
    {
        $this->get(route('core.addresses.create', [], false), [
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
        ])
            ->assertStatus(200)
            ->assertJsonStructure(['form']);
    }

    #[Test]
    public function can_get_edit_address_form()
    {
        $this->get(route('core.addresses.edit', $this->address, false))
            ->assertStatus(200)
            ->assertJsonStructure(['form']);
    }

    #[Test]
    public function can_delete_address()
    {
        $this->delete(route('core.addresses.destroy', $this->address, false))
            ->assertStatus(200);

        $this->assertNull($this->address->fresh());
    }

    #[Test]
    public function cannot_delete_a_default_address_while_having_secondary_address()
    {
        $secondaryAddress = $this->secondaryAddress();

        $this->delete(route('core.addresses.destroy', $this->address, false))
            ->assertStatus(488)
            ->assertJsonStructure(['message']);

        $this->assertNotNull($this->address->fresh());
        $this->assertNotNull($secondaryAddress->fresh());
    }

    #[Test]
    public function cannot_delete_an_addressable_while_having_restrict_address()
    {
        Config::set('enso.addresses.onDelete', 'restrict');

        $this->expectException(ConflictHttpException::class);

        AddressableTestModel::destroy([$this->addressable->id]);
    }

    #[Test]
    public function can_delete_an_addressable_while_having_cascade_address()
    {
        Config::set('enso.addresses.onDelete', 'cascade');

        AddressableTestModel::destroy([$this->addressable->id]);

        $this->assertNull($this->address->fresh());
    }

    #[Test]
    public function makes_first_stored_address_default_when_none_exists()
    {
        $addressable = AddressableTestModel::create(['name' => 'first default']);
        ['region' => $region, 'locality' => $locality] = $this->geographyFor($this->country, 'Default Region', 'Default Locality');

        $address = new Address([
            'addressable_id'   => $addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'street'           => 'First default street',
            'is_default'       => false,
            'is_billing'       => false,
            'is_shipping'      => false,
            'created_by'       => $this->user->id,
        ]);

        $address->store();

        $this->assertTrue($address->fresh()->is_default);
    }

    #[Test]
    public function generates_label_from_available_location_parts()
    {
        $region = Region::factory()->create([
            'country_id' => $this->country->id,
            'name'       => 'Ilfov',
            'is_active'  => true,
        ]);
        $township = Township::factory()->create(['region_id' => $region->id]);
        $locality = Locality::factory()->create([
            'region_id'   => $region->id,
            'township_id' => $township->id,
            'name'        => 'Corbeanca',
            'is_active'   => true,
        ]);
        $sector = Sector::create([
            'locality_id' => $locality->id,
            'name'        => '2',
        ]);

        $address = Address::create([
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'sector_id'        => $sector->id,
            'street'           => 'Main street 5',
            'additional'       => 'Floor 1',
            'postcode'         => '077065',
            'is_default'       => false,
            'is_billing'       => false,
            'is_shipping'      => false,
            'created_by'       => $this->user->id,
        ]);

        $this->assertSame(
            sprintf(
                'Corbeanca, Sector 2, Main street 5, Floor 1, 077065, %s Ilfov',
                __('County')
            ),
            $address->label()
        );
    }

    #[Test]
    public function returns_postcode_match_for_country_and_code()
    {
        $region = Region::factory()->create([
            'country_id'   => $this->country->id,
            'name'         => 'Ilfov',
            'abbreviation' => 'IF',
            'is_active'    => true,
        ]);
        $township = Township::factory()->create(['region_id' => $region->id]);
        $locality = Locality::factory()->create([
            'region_id'   => $region->id,
            'township_id' => $township->id,
            'name'        => 'Otopeni',
            'is_active'   => true,
        ]);

        Postcode::create([
            'country_id'  => $this->country->id,
            'region_id'   => $region->id,
            'locality_id' => $locality->id,
            'township_id' => $township->id,
            'code'        => '075100',
        ]);

        $this->get(route('core.addresses.postcode', [
            'country_id' => $this->country->id,
            'postcode'   => '075100',
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment([
                'code'        => '075100',
                'locality_id' => $locality->id,
                'region_id'   => $region->id,
            ]);
    }

    #[Test]
    public function returns_regions_for_country()
    {
        $wanted = Region::factory()->create([
            'country_id'   => $this->country->id,
            'name'         => 'Wanted Region',
            'abbreviation' => 'WR',
            'is_active'    => true,
        ]);
        $otherCountry = Country::factory()->create(['is_active' => true]);
        Region::factory()->create([
            'country_id'   => $otherCountry->id,
            'name'         => 'Other Region',
            'abbreviation' => 'OR',
            'is_active'    => true,
        ]);

        $this->get(route('core.addresses.regions', [
            'params' => json_encode(['country_id' => $this->country->id], JSON_THROW_ON_ERROR),
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $wanted->id, 'name' => 'Wanted Region'])
            ->assertJsonMissing(['name' => 'Other Region']);
    }

    #[Test]
    public function returns_localities_for_region_or_country_context()
    {
        $region = Region::factory()->create([
            'country_id' => $this->country->id,
            'name'       => 'Locality Region',
            'is_active'  => true,
        ]);
        $township = Township::factory()->create(['region_id' => $region->id]);
        $wanted = Locality::factory()->create([
            'region_id'   => $region->id,
            'township_id' => $township->id,
            'name'        => 'Wanted Locality',
            'is_active'   => true,
        ]);
        $otherCountry = Country::factory()->create(['is_active' => true]);
        $otherRegion = Region::factory()->create([
            'country_id' => $otherCountry->id,
            'name'       => 'Other Region',
            'is_active'  => true,
        ]);
        $otherTownship = Township::factory()->create(['region_id' => $otherRegion->id]);
        Locality::factory()->create([
            'region_id'   => $otherRegion->id,
            'township_id' => $otherTownship->id,
            'name'        => 'Other Locality',
            'is_active'   => true,
        ]);

        $this->get(route('core.addresses.localities', [
            'params' => json_encode(['region_id' => $region->id], JSON_THROW_ON_ERROR),
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $wanted->id, 'locality' => 'Wanted Locality'])
            ->assertJsonMissing(['locality' => 'Other Locality']);

        $this->get(route('core.addresses.localities', [
            'pivotParams' => json_encode(['region' => ['country_id' => $this->country->id]], JSON_THROW_ON_ERROR),
        ], false))
            ->assertStatus(200)
            ->assertJsonFragment(['id' => $wanted->id, 'locality' => 'Wanted Locality'])
            ->assertJsonMissing(['locality' => 'Other Locality']);
    }

    #[Test]
    public function updates_coordinates_directly()
    {
        $this->patch(route('core.addresses.coordinates', $this->address, false), [
            'lat'  => 44.571234,
            'long' => 26.078901,
        ])
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertSame('44.571234', number_format($this->address->fresh()->lat, 6, '.', ''));
        $this->assertSame('26.078901', number_format($this->address->fresh()->long, 6, '.', ''));
    }

    #[Test]
    public function marks_address_as_localized_after_coordinate_update()
    {
        $this->assertFalse($this->address->isLocalized());

        $this->patch(route('core.addresses.coordinates', $this->address, false), [
            'lat'  => 44.571234,
            'long' => 26.078901,
        ])->assertStatus(200);

        $this->assertTrue($this->address->fresh()->isLocalized());
    }

    #[Test]
    public function localizes_address_via_geocoding()
    {
        Config::set('enso.google.mapsUrl', 'https://maps.example.test');
        Config::set('enso.google.geocodingKey', 'test-key');

        Http::fake([
            'https://maps.example.test*' => Http::response([
                'status'  => 'OK',
                'results' => [[
                    'geometry' => [
                        'location' => [
                            'lat' => 44.5712344,
                            'lng' => 26.0789012,
                        ],
                    ],
                ]],
            ]),
        ]);

        $this->get(route('core.addresses.localize', $this->address, false))
            ->assertStatus(200)
            ->assertExactJson([
                'lat'  => 44.571234,
                'long' => 26.078901,
            ]);

        $this->assertTrue($this->address->fresh()->isLocalized());
    }

    #[Test]
    public function returns_address_options()
    {
        $secondary = $this->secondaryAddress([
            'street'     => 'Secondary street',
            'is_default' => false,
        ]);

        $this->get(route('core.addresses.options', [], false))
            ->assertStatus(200)
            ->assertJsonFragment([
                'id'        => $this->address->id,
                'isDefault' => true,
            ])
            ->assertJsonFragment([
                'id'    => $secondary->id,
                'label' => $secondary->fresh()->label(),
            ]);
    }

    #[Test]
    public function exposes_dynamic_relations_on_user_and_country()
    {
        $userAddress = $this->secondaryAddress([
            'street'     => 'User relation street',
            'created_by' => $this->user->id,
        ]);
        $countryRegion = Region::factory()->create([
            'country_id' => $this->country->id,
            'name'       => 'Country Relation Region',
            'is_active'  => true,
        ]);
        $township = Township::factory()->create(['region_id' => $countryRegion->id]);
        $countryLocality = Locality::factory()->create([
            'region_id'   => $countryRegion->id,
            'township_id' => $township->id,
            'name'        => 'Country Relation Locality',
            'is_active'   => true,
        ]);

        $this->assertTrue($this->user->addresses()->whereKey($userAddress->id)->exists());
        $this->assertTrue($this->country->regions()->whereKey($countryRegion->id)->exists());
        $this->assertTrue($this->country->localities()->whereKey($countryLocality->id)->exists());
    }

    #[Test]
    public function cannot_create_multiple_addresses_for_single_addressable_entities()
    {
        ['region' => $region, 'locality' => $locality] = $this->geographyFor($this->country, 'Single Region', 'Single Locality');
        $single = SingleAddressableTestModel::create(['name' => 'single']);

        Address::create([
            'addressable_id'   => $single->id,
            'addressable_type' => SingleAddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'street'           => 'Single street',
            'is_default'       => true,
            'is_billing'       => false,
            'is_shipping'      => false,
            'created_by'       => $this->user->id,
        ]);

        $this->post(route('core.addresses.store'), $this->addressParams([
            'addressable_id'   => $single->id,
            'addressable_type' => SingleAddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $region->id,
            'locality_id'      => $locality->id,
            'street'           => 'Second single street',
        ]))
            ->assertStatus(488)
            ->assertJsonFragment([
                'message' => 'You cannot add multiple addresses to this entity',
            ]);
    }

    private function createTestTables(): void
    {
        Schema::create('addressable_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('single_addressable_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    private function geographyFor(
        Country $country,
        string $regionName = 'Test Region',
        string $localityName = 'Test Locality'
    ): array {
        $region = Region::factory()->create([
            'country_id'   => $country->id,
            'name'         => $regionName,
            'abbreviation' => strtoupper(substr($regionName, 0, 2)),
            'is_active'    => true,
        ]);

        $township = Township::factory()->create(['region_id' => $region->id]);

        $locality = Locality::factory()->create([
            'region_id'   => $region->id,
            'township_id' => $township->id,
            'name'        => $localityName,
            'is_active'   => true,
        ]);

        return compact('region', 'township', 'locality');
    }

    private function addressParams(array $overrides = []): array
    {
        return array_merge([
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $this->address->region_id,
            'locality_id'      => $this->address->locality_id,
            'sector_id'        => null,
            'city'             => null,
            'street'           => 'Address street',
            'additional'       => null,
            'postcode'         => '010101',
            'notes'            => null,
            'lat'              => null,
            'long'             => null,
            'is_default'       => false,
            'is_billing'       => false,
            'is_shipping'      => false,
        ], $overrides);
    }

    private function secondaryAddress(array $overrides = []): Address
    {
        return Address::create(array_merge([
            'addressable_id'   => $this->addressable->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id'       => $this->country->id,
            'region_id'        => $this->address->region_id,
            'locality_id'      => $this->address->locality_id,
            'street'           => 'Secondary street',
            'postcode'         => '020202',
            'is_default'       => false,
            'is_billing'       => false,
            'is_shipping'      => false,
            'created_by'       => $this->user->id,
        ], $overrides));
    }
}

class AddressableTestModel extends Model
{
    use Addressable;

    protected $guarded = [];
}

class SingleAddressableTestModel extends Model
{
    protected $guarded = [];

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable')
            ->whereIsDefault(true);
    }
}
