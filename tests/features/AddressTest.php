<?php

use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Addresses\Models\Locality;
use LaravelEnso\Addresses\Models\Region;
use LaravelEnso\Addresses\Traits\Addressable;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Countries\Models\Country;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Faker $faker;
    private Address $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs($this->user = User::first());

        $this->createTestTable();

        $this->faker = Factory::create();
        $country = Country::first();

        $this->testModel = Address::factory()->create([
            'addressable_id' => AddressableTestModel::create(['name' => 'addressable'])->id,
            'region_id' => optional(Region::first())->id,
            'locality_id' => optional(Locality::first())->id,
            'country_id' => $country->id,
            'addressable_type' => AddressableTestModel::class,
        ]);

        Config::set('enso.addresses.defaultCountryId', $country->id);
    }

    /** @test */
    public function can_create_address()
    {
        $params = $this->postParams();

        $this->post(route('core.addresses.store'), $params)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertTrue($this->addressExists($params));
    }

    /** @test */
    public function can_get_addresses_index()
    {
        $this->get(
            route('core.addresses.index', $this->testModel->toArray(), false)
        )->assertStatus(200)
            ->assertJsonFragment(['street' => $this->testModel->street]);
    }

    /** @test */
    public function can_update_address()
    {
        $this->testModel->street = 'edited';

        $this->patch(
            route('core.addresses.update', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['message' => 'message']);

        $this->assertEquals(
            $this->testModel->street,
            $this->testModel->fresh()->street
        );
    }

    /** @test */
    public function can_set_default_address()
    {
        $secondaryAddress = $this->createSecondaryAddress();

        $this->patch(
            route('core.addresses.makeDefault', $secondaryAddress->id, false)
        )->assertStatus(200);

        $this->assertFalse(
            $this->testModel->fresh()->is_default
        );

        $this->assertTrue(
            $secondaryAddress->fresh()->is_default
        );
    }

    /** @test */
    public function can_set_billing_address()
    {
        $secondaryAddress = $this->createSecondaryAddress();

        $this->patch(
            route('core.addresses.makeBilling', $secondaryAddress->id, false)
        )->assertStatus(200);

        $this->assertFalse(
            $this->testModel->fresh()->is_billing
        );

        $this->assertTrue(
            $secondaryAddress->fresh()->is_billing
        );
    }

    /** @test */
    public function can_set_shipping_address()
    {
        $secondaryAddress = $this->createSecondaryAddress();

        $this->patch(
            route('core.addresses.makeShipping', $secondaryAddress->id, false)
        )->assertStatus(200);

        $this->assertTrue(
            $secondaryAddress->fresh()->is_shipping
        );
    }

    /** @test */
    public function can_get_create_address_form()
    {
        $this->get(
            route('core.addresses.create', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['form' => 'form']);
    }

    /** @test */
    public function can_get_edit_address_form()
    {
        $this->get(
            route('core.addresses.edit', $this->testModel->id, false),
            $this->testModel->toArray()
        )->assertStatus(200)
            ->assertJsonStructure(['form' => 'form']);
    }

    /** @test */
    public function can_delete_address()
    {
        $this->assertNotNull($this->testModel);

        $this->delete(
            route('core.addresses.destroy', $this->testModel->id, false)
        )->assertStatus(200);

        $this->assertNull($this->testModel->fresh());
    }

    /** @test */
    public function cannot_delete_a_default_address_while_having_secondary_address()
    {
        $secondaryAddress = $this->createSecondaryAddress();

        $this->delete(
            route('core.addresses.destroy', $this->testModel->id, false)
        )->assertStatus(488)
            ->assertJsonStructure(['message']);

        $this->assertNotNull($this->testModel->fresh());

        $this->assertNotNull($secondaryAddress->fresh());
    }

    /** @test */
    public function cannot_delete_an_addressable_while_having_restrict_address()
    {
        Config::set('enso.addresses.onDelete', 'restrict');

        $this->expectException(ConflictHttpException::class);

        AddressableTestModel::destroy([$this->testModel->id]);

        $this->assertNotNull($this->testModel->fresh());
    }

    /** @test */
    public function can_delete_an_addressable_while_having_cascade_address()
    {
        Config::set('enso.addresses.onDelete', 'cascade');

        AddressableTestModel::destroy([$this->testModel->id]);

        $this->assertNull($this->testModel->fresh());
    }

    private function createTestTable()
    {
        Schema::create('addressable_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    private function postParams()
    {
        return Address::factory()->make([
            'addressable_id' => $this->testModel->addressable_id,
            'region_id' => optional(Region::first())->id,
            'locality_id' => optional(Locality::first())->id,
            'addressable_type' => AddressableTestModel::class,
        ])->toArray();
    }

    private function addressExists($params)
    {
        return Address::whereStreet($params['street'])->exists();
    }

    private function createSecondaryAddress()
    {
        return Address::factory()->create([
            'addressable_id' => $this->testModel->addressable_id,
            'addressable_type' => AddressableTestModel::class,
            'is_default' => false,
            'is_billing' => false,
            'is_shipping' => false,
        ]);
    }
}

class AddressableTestModel extends Model
{
    use Addressable;

    protected $fillable = ['name'];
}
