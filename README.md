<!--h-->
# AddressesManager
[![StyleCI](https://styleci.io/repos/113445673/shield?branch=master)](https://styleci.io/repos/113445673)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1bd97370791b452f977c70e9ae39c72c)](https://www.codacy.com/app/mihai-ocneanu/AddressesManager?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/AddressesManager&amp;utm_campaign=Badge_Grade)
[![License](https://poser.pugx.org/laravel-enso/addressesmanager/license)](https://https://packagist.org/packages/laravel-enso/addressesmanager)
[![Total Downloads](https://poser.pugx.org/laravel-enso/addressesmanager/downloads)](https://packagist.org/packages/laravel-enso/addressesmanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/addressesmanager/version)](https://packagist.org/packages/laravel-enso/addressesmanager)
<!--/h-->

Free-form addresses manager for [Laravel Enso](https://github.com/laravel-enso/Enso)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041.png)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042.png)

### Features

- can be used to attach addresses to any entity, via using a polymorphic relationship
- allows saving of multiple addresses for an addresable entity
- features and easy flow for setting the default address 
- comes with an additional table for Countries, with all the countries pre-populated
- brings its own free-form form for the edit and creation of addresses
- has a publishable configuration file, where you can define the addresable models, 
set custom validations via the Laravel syntax, as well as other options
- comes with its own VueJS component `addresses` 
- includes an `Addressable` trait, for defining relationships and attributes
- the VueJS component as well as the whole package is designed to be extendable, 
so you could create a custom versions for specific countries 

### Usage
1. the configuration should be published, and inside you need to define the addresable types
2. use the package's `Addresable` trait for the models you want to make addressable
3. insert the `Addreses` vue component where required in your pages/components. The `id` and `type` parameters are 
the essential ones.

```
<addresses :id="modelId" type="modelAlias">
</addresses>
```

### Options

- `type` - string, the addressable model alias you set in the config | required
- `id` - number, the id of the addressable model | required
- `theme` - string, the class used for setting the styling of the box. Defaults to `primary`.
- `solid` - boolean, a flag for showing a solid type of a box. Defaults to `false`.
- `open` - boolean, a flag for the starting style (open/closed) of the box. Defaults to `true`.
- `title` - string, the text for the box title. Defaults to null.

Note that the labels are take from the global Store - if needed you may customize them in `config/labels.php`.

### Commands
The package comes with an artisan command, to help you migrate from previous versions to 2.1.28+, 
which introduced a new column, `building_type`:
- `php artisan enso:migrate --buildingType`

### Publishes
- `php artisan vendor:publish --tag=addresses-config` - configuration file
- `php artisan vendor:publish --tag=addresses-form` - form used for creating/editing addresses
- `php artisan vendor:publish --tag=enso-config` - a common alias for when wanting to update the config,
once a newer version is released

 
### Notes

The [Laravel Enso Core](https://github.com/laravel-enso/Core) package comes with this package included.


For an example of extending this package, you may take a look at 
[RoAddresses](https://github.com/laravel-enso/RoAddresses) the Romanian Addresses extension.

<!--h-->
### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
<!--/h--> 