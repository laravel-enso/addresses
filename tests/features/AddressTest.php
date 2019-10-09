<?php

use Faker\Factory;
use Tests\TestCase;
use LaravelEnso\Core\app\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use LaravelEnso\Addresses\app\Models\Address;
use \LaravelEnso\Addresses\app\Models\Country;
use LaravelEnso\Addresses\app\Traits\Addressable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $faker;
    private $testModel;

    protected function setUp(): void
    {
        parent::setUp();

        // $this->withoutExceptionHandling();

        $this->seed()
            ->actingAs($this->user = User::first());

        $this->createTestTable();

        $this->faker = Factory::create();

        $this->testModel = factory(Address::class)->create([
            'addressable_id' => AddressableTestModel::create(['name' => 'addressable'])->id,
            'country_id' => Country::first()->id,
            'addressable_type' => AddressableTestModel::class,
        ]);
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
            route('core.addresses.setDefault', $secondaryAddress->id, false)
        )->assertStatus(200);

        $this->assertFalse(
            $this->testModel->fresh()->is_default
        );

        $this->assertTrue(
            $secondaryAddress->fresh()->is_default
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
    public function can_get_label_attribute()
    {
        $attributes = collect(config('enso.addresses.label.attributes'));
        $attributes->each(function ($attribute) {
            $this->testModel->{$attribute} = $attribute;
        });

        $this->assertEquals(
            $attributes->implode(config('enso.addresses.label.separator')),
            $this->testModel->getLabelAttribute()
        );
    }

    /** @test */
    public function cannot_delete_a_default_address_while_having_secondary_address()
    {
        $secondaryAddress = $this->createSecondaryAddress();

        $this->delete(
            route('core.addresses.destroy', $this->testModel->id, false)
        )->assertStatus(555)
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
        return factory(Address::class)->make([
            'addressable_id' => $this->testModel->addressable_id,
            'addressable_type' => AddressableTestModel::class,
        ])->toArray();
    }

    private function addressExists($params)
    {
        return Address::whereStreet($params['street'])->exists();
    }

    private function createSecondaryAddress()
    {
        return factory(Address::class)->create([
            'addressable_id' => $this->testModel->addressable_id,
            'addressable_type' => AddressableTestModel::class,
            'is_default' => false
        ]);
    }
}

class AddressableTestModel extends Model
{
    use Addressable;

    protected $fillable = ['name'];
}
