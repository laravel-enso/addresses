<?php

use Faker\Factory;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Addresses\Models\Address;
use LaravelEnso\Addresses\Traits\Addressable;
use LaravelEnso\Countries\Models\Country;
use LaravelEnso\Users\Models\User;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;
use Tests\TestCase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private Faker $faker;
    private Address $model;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed()
            ->actingAs($this->user = User::first());

        $this->createTestTable();

        $this->faker = Factory::create();
        $country = Country::factory()->create(['is_active' => true]);

        $this->model = Address::factory()->test()->create([
            'addressable_id' => AddressableTestModel::create(['name' => 'addressable'])->id,
            'addressable_type' => AddressableTestModel::class,
            'country_id' => $country->id,
            'is_default' => true,
        ]);

        Config::set('enso.addresses.defaultCountryId', $country->id);
    }

    /** @test */
    public function can_create_address()
    {
        $params = Address::factory()->test()->make([
            'addressable_id' => $this->model->addressable_id,
            'addressable_type' => AddressableTestModel::class,
        ])->toArray();

        $this->post(route('core.addresses.store'), $params)
            ->assertStatus(200)
            ->assertJsonStructure(['message']);

        $this->assertTrue(Address::whereStreet($params['street'])->exists());
    }

    /** @test */
    public function can_get_addresses_index()
    {
        $route = route('core.addresses.index', [
            'addressable_id' => $this->model->id,
            'addressable_type' => 'AddressableTestModel',
        ], false);

        $this->get($route)
            ->assertStatus(200)
            ->assertJsonFragment(['street' => $this->model->street]);
    }

    /** @test */
    public function can_update_address()
    {
        $route = route('core.addresses.update', $this->model->id, false);
        $this->model->street = 'edited';

        $this->patch($route, $this->model->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(['message' => 'message']);

        $this->assertEquals($this->model->street, $this->model->fresh()->street);
    }

    /** @test */
    public function can_set_default_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeDefault', $secondaryAddress->id, false);

        $this->patch($route)->assertStatus(200);

        $this->assertFalse($this->model->fresh()->is_default);

        $this->assertTrue($secondaryAddress->fresh()->is_default);
    }

    /** @test */
    public function can_set_billing_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeBilling', $secondaryAddress->id, false);

        $this->patch($route)->assertStatus(200);

        $this->assertTrue($secondaryAddress->fresh()->is_billing);
    }

    /** @test */
    public function can_set_shipping_address()
    {
        $secondaryAddress = $this->secondaryAddress();
        $route = route('core.addresses.makeShipping', $secondaryAddress->id, false);

        $this->patch($route)->assertStatus(200);

        $this->assertTrue($secondaryAddress->fresh()->is_shipping);
    }

    /** @test */
    public function can_get_create_address_form()
    {
        $route = route('core.addresses.create', $this->model->id, false);

        $this->get($route, $this->model->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(['form' => 'form']);
    }

    /** @test */
    public function can_get_edit_address_form()
    {
        $route = route('core.addresses.edit', $this->model->id, false);

        $this->get($route, $this->model->toArray())
            ->assertStatus(200)
            ->assertJsonStructure(['form' => 'form']);
    }

    /** @test */
    public function can_delete_address()
    {
        $route = route('core.addresses.destroy', $this->model->id, false);

        $this->delete($route)->assertStatus(200);

        $this->assertNull($this->model->fresh());
    }

    /** @test */
    public function cannot_delete_a_default_address_while_having_secondary_address()
    {
        $route = route('core.addresses.destroy', $this->model->id, false);
        $secondaryAddress = $this->secondaryAddress();

        $this->delete($route)
            ->assertStatus(488)
            ->assertJsonStructure(['message']);

        $this->assertNotNull($this->model->fresh());

        $this->assertNotNull($secondaryAddress->fresh());
    }

    /** @test */
    public function cannot_delete_an_addressable_while_having_restrict_address()
    {
        Config::set('enso.addresses.onDelete', 'restrict');

        $this->expectException(ConflictHttpException::class);

        AddressableTestModel::destroy([$this->model->id]);

        $this->assertNotNull($this->model->fresh());
    }

    /** @test */
    public function can_delete_an_addressable_while_having_cascade_address()
    {
        Config::set('enso.addresses.onDelete', 'cascade');

        AddressableTestModel::destroy([$this->model->id]);

        $this->assertNull($this->model->fresh());
    }

    private function createTestTable()
    {
        Schema::create('addressable_test_models', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }

    private function secondaryAddress()
    {
        return Address::factory()->test()->create([
            'addressable_id' => $this->model->addressable_id,
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

    protected $guarded = [];
}
