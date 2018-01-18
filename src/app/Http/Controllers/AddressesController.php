<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEnso\AddressesManager\app\Enums\StreetTypes;
use LaravelEnso\AddressesManager\app\Exceptions\AddressException;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\Core\app\Exceptions\EnsoException;
use LaravelEnso\FormBuilder\app\Classes\FormBuilder;

class AddressesController extends Controller
{
    public function store(ValidateAddressRequest $request)
    {
        $params = (object) $request->get('_params');

        $address = new Address($request->all());
        $address->addressable_id = $params->id;
        $address->addressable_type = config('addresses.addressables.'.$params->type);
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

    /**
     * @param Address $address
     *
     * @throws \Exception
     * @throws \Throwable
     *
     * @return array
     */
    public function setDefault(Address $address)
    {
        DB::transaction(function () use ($address) {
            $this->unsetDefaultAddress($address);
            $address->is_default = true;
            $address->save();
        });

        return [
            'message' => __('Address set as default'),
        ];
    }

    /**
     * @param Address $address
     *
     * @throws \Exception
     *
     * @return array
     */
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
        $editForm = (new FormBuilder($this->getFormPath(), $address))
            ->setTitle('Edit')
            ->setAction('PATCH')
            ->setUrl('/addresses/'.$address->id)
            ->setSelectOptions('street_type', (object) (new StreetTypes())->getData())
            ->getData();

        return $editForm;
    }

    public function create(Request $request)
    {
        $createForm = (new FormBuilder($this->getFormPath()))
            ->setTitle('Insert')
            ->setAction('POST')
            ->setUrl('/addresses')
            ->setSelectOptions('street_type', (object) (new StreetTypes())->getData())
            ->getData();

        return $createForm;
    }

    /**
     * @throws EnsoException
     *
     * @return mixed
     */
    public function index()
    {
        $addressable = $this->getAddressable();

        return $addressable->addresses()->orderBy('is_default', 'desc')->get();
    }

    /**
     * @throws EnsoException
     *
     * @return mixed
     */
    private function getAddressable()
    {
        return $this->getAddressableClass()::find(request()->get('id'));
    }

    /**
     * @throws EnsoException
     *
     * @return \Illuminate\Config\Repository|mixed
     */
    private function getAddressableClass()
    {
        $class = config('addresses.addressables.'.request()->get('type'));

        if (!$class) {
            throw new EnsoException(
                __('Current entity does not exist in contacts.php config file: ').request()->get('type')
            );
        }

        return $class;
    }

    /**
     * @return string
     */
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

    private function isTheFirst(Address $address)
    {
        $count = $address->addressable->addresses()->count();

        return $count === 0;
    }
}
