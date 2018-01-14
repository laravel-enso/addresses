<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\AddressesManager\app\Enums\StreetTypes;
use LaravelEnso\AddressesManager\app\Exceptions\AddressException;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\FormBuilder\app\Classes\Form;

class AddressesController extends Controller
{
    public function store(ValidateAddressRequest $request)
    {
        $params = (object) $request->get('_params');

        $address = new Address($request->all());
        $address->addressable_id = $params->id;
        $address->addressable_type = config('enso.addresses.addressables.'.$params->type);
        $address->is_default = $this->isTheFirst($address);

        $address->save();

        return [
            'message'  => __('Created Address'),
            'redirect' => '',
        ];
    }

    public function update(ValidateAddressRequest $request, Address $address)
    {
        $address->update($request->all());

        return [
            'message' => __('The Changes have been saved!'),
        ];
    }

    public function setDefault(Address $address)
    {
        \DB::transaction(function () use ($address) {
            $this->unsetDefaultAddress($address);
            $address->is_default = true;
            $address->save();
        });
    }

    public function destroy(Address $address)
    {
        if ($address->is_default) {
            throw new AddressException(__('The default address cannot be deleted'));
        }
        $address->delete();

        return [
            'message'  => __('Operation was successful'),
            'redirect' => '',
        ];
    }

    public function edit(Address $address)
    {
        $form = (new Form($this->getFormPath()))
            ->edit($address)
            ->title('Edit')
            ->actions(['update', 'destroy'])
            ->options('street_type', StreetTypes::object())
            ->get();

        return compact('form');
    }

    public function create(Request $request)
    {
        $form = (new Form($this->getFormPath()))
            ->create()
            ->title('Insert')
            ->options('street_type', StreetTypes::object())
            ->get();

        return compact('form');
    }

    public function index()
    {
        $addressable = $this->getAddressable();

        return $addressable->addresses()->get();
    }

    private function getAddressable()
    {
        return $this->getAddressableClass()::find(request()->get('id'));
    }

    private function getAddressableClass()
    {
        $class = config('enso.addresses.addressables.'.request()->get('type'));

        if (!$class) {
            throw new AddressException(__(
                'Entity :entity does not exist in enso/addresses.php config file',
                ['entity' => request()->get('type')]
            ));
        }

        return $class;
    }

    private function getFormPath(): string
    {
        $publishedForm = app_path('Forms/vendor/addresses/address.json');

        if (file_exists($publishedForm)) {
            return $publishedForm;
        }

        return __DIR__.'/../../Forms/addresses/address.json';
    }

    private function unsetDefaultAddress(Address $address)
    {
        $defaultAddress = $address->addressable->addresses()
            ->whereIsDefault(true)
            ->first();

        if (!is_null($defaultAddress)) {
            $defaultAddress->is_default = false;
            $defaultAddress->save();
        }
    }

    private function isTheFirst(Address $address): bool
    {
        $count = $address->addressable->addresses()->count();

        return $count === 0;
    }
}
