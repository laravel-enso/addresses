@extends('laravel-enso/core::layouts.app')

@section('pageTitle', __("Addresses"))

@section('content')

    <page v-cloak>
        <div class="col-md-12">
            <addresses type="user" :id="1">

            </addresses>
        </div>
        <div class="col-md-12">
            <data-table source="addresses"
                @edit-address="edit"
                id="addresses"
                ref="addresses">
            </data-table>
        </div>
        <address-modal-form
            v-if="showForm"
            :address="address"
            @form-close="showForm=false;address={};form=null;"
            @patch="updateTable"
            @delete="updateTable">
        </address-modal-form>
    </page>

@endsection

@push('scripts')

    <script>

        const vm = new Vue({
            el: '#app',

            data: {
                showForm: false,
                address: {},
                form: null
            },

            methods: {
                async edit(id) {
                    let data = this.$refs.addresses.dtHandle.data().toArray(),
                        address = data.find(function(address) {
                            return address.DT_RowId === id;
                        });

                    this.setAddress(address);
                    this.showForm = true;
                },
                setAddress(address) {
                    Object.assign(this.address, address);
                    this.address.id = address.DT_RowId;
                },
                updateTable() {
                    this.showForm = false;
                    this.$refs.addresses.dtHandle.ajax.reload();
                },
            }
        });

    </script>

@endpush