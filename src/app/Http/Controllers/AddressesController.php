<?php

namespace LaravelEnso\AddressesManager\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use LaravelEnso\AddressesManager\app\Forms\Builders\AddressForm;
use LaravelEnso\AddressesManager\app\Handlers\ConfigMapper;
use LaravelEnso\AddressesManager\App\Http\Requests\ValidateAddressRequest;
use LaravelEnso\AddressesManager\app\Models\Address;
use LaravelEnso\FormBuilder\app\Classes\Form;

class AddressesController extends Controller
{
    public function index(Request $request)
    {
        return Address::whereAddressableId($request->get('id'))
            ->whereAddressableType(
                (new ConfigMapper($request->get('type')))->class()
            )->orderBy('is_default', 'desc')
            ->get();
    }

    public function create(AddressForm $form)
    {
        return ['form' => $form->create()];
    }

    public function store(ValidateAddressRequest $request, Address $address)
    {
        $address->store($request->all(), $request->get('_params'));

        return ['message' => __('Created Address')];
    }

    public function edit(Address $address, AddressForm $form)
    {
        return ['form' => $form->edit($address)];
    }

    public function update(ValidateAddressRequest $request, Address $address)
    {
        $address->update($request->all());

        return ['message' => __('The Changes have been saved!')];
    }

    public function setDefault(Address $address)
    {
        $address->setDefault();
    }

    public function destroy(Address $address)
    {
        $address->delete();

        return ['message' => __('Operation was successful')];
    }
}
