# AddressesManager
(https://api.codacy.com/project/badge/Grade/c7404086a15a4db6b2080b1d09b0688a)](https://www.codacy.com/app/laravel-enso/AddressesManager?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/AddressesManager&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://styleci.io/repos/113445673/shield?branch=master)](https://styleci.io/repos/113445673)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1bd97370791b452f977c70e9ae39c72c)][![Codacy Badge]
[![License](https://poser.pugx.org/laravel-enso/addressesmanager/license)](https://packagist.org/packages/laravel-enso/addressesmanager)
[![Total Downloads](https://poser.pugx.org/laravel-enso/addressesmanager/downloads)](https://packagist.org/packages/laravel-enso/addressesmanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/addressesmanager/version)](https://packagist.org/packages/laravel-enso/addressesmanager)

Free-form addresses manager for [Laravel Enso](https://github.com/laravel-enso/Enso)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041.png)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042.png)

### Features

- can be used to attach addresses to any entity, via a polymorphic relationship
- allows saving of multiple addresses for an addresable entity
- features and easy flow for setting the default address 
- comes with an additional table for Countries, with all the countries pre-populated
- brings its own free-form form for the edit and creation of addresses
- has a publishable configuration file, where you can define the addresable models, 
set custom validations via the Laravel syntax, as well as other options
- comes with its own VueJS component `addresses` 
- includes an `Addressable` trait, for defining relationships and attributes
- the VueJS component as well as the whole package is designed to be extendable, 
so you could create custom versions for specific countries 

### Configuration & Usage

Be sure to check out the full documentation for this package available at [docs.laravel-enso.com](https://docs.laravel-enso.com/packages/addresses-manager.html)

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.