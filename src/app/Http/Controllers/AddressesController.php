<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use LaravelEnso\AddressesManager\app\Enums\StreetTypes;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\Core\app\Exceptions\EnsoException;
use LaravelEnso\FormBuilder\app\Classes\Form;

class AddressesController extends Controller
{
    public function store(ValidateAddressRequest $request)
    {
        $params = (object) $request->get('_params');

        $address = new Address($request->all());
        $address->addressable_id = $params->id;
        $address->addressable_type = config('enso.addresses.addressables.'.$params->type);
        $address->is_default = $this->isTheFirst($address) ?: false;

        $address->save();

        return [
            'message'  => __('Created Address'),
            'redirect' => '',
        ];
    }

    public function update(ValidateAddressRequest $request, Address $address)
    {
        $address->fill($request->all());
        $address->save();

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

            //first set all addresses as not default
            $address->addressable->addresses()->where('is_default', true)->get()
                ->each(function (Address $item) {
                    $item->is_default = false;
                    $item->save();
                });

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
            throw new EnsoException(__('The default address cannot be deleted'));
        }
        $address->delete();

        return [
            'message'  => __('Operation was successful'),
            'redirect' => '',
        ];
    }

    public function getEditForm(Address $address)
    {
        $editForm = (new Form($this->getFormPath()))
            ->edit($address)
            ->title('Edit')
            ->actions(['update', 'destroy'])
            ->options('street_type', StreetTypes::object())
            ->get();

        return compact('editForm');
    }

    public function getCreateForm(Request $request)
    {
        $createForm = (new Form($this->getFormPath()))
            ->create()
            ->title('Insert')
            ->options('street_type', StreetTypes::object())
            ->get();

        return compact('createForm');
    }

    /**
     * @throws EnsoException
     *
     * @return mixed
     */
    public function list()
    {
        $addressable = $this->getAddressable();

        return $addressable->addresses()->get();
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
        $class = config('enso.addresses.addressables.'.request()->get('type'));

        if (!$class) {
            throw new EnsoException(
                __('Current entity does not exist in enso/addresses.php config file: ').request()->get('type')
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

    private function isTheFirst(Address $address)
    {
        $count = $address->addressable->addresses()->count();

        return $count === 0;
    }
}
