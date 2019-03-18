# Addresses Manager

[![StyleCI](https://styleci.io/repos/113445673/shield?branch=master)](https://styleci.io/repos/113445673)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/1bd97370791b452f977c70e9ae39c72c)](https://www.codacy.com/app/mihai-ocneanu/AddressesManager?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/AddressesManager&amp;utm_campaign=Badge_Grade)
[![License](https://poser.pugx.org/laravel-enso/addressesmanager/license)](https://packagist.org/packages/laravel-enso/addressesmanager)
[![Total Downloads](https://poser.pugx.org/laravel-enso/addressesmanager/downloads)](https://packagist.org/packages/laravel-enso/addressesmanager)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/addressesmanager/version)](https://packagist.org/packages/laravel-enso/addressesmanager)

Free-form addresses manager for [Laravel Enso](https://github.com/laravel-enso/Enso)

This package works exclusively within the [Enso](https://github.com/laravel-enso/Enso) ecosystem.

There is a front end implementation for this this api in the [accessories](https://github.com/enso-ui/accessories) package.

For live examples and demos, you may visit [laravel-enso.com](https://www.laravel-enso.com)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_041.png)

[![Screenshot](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042_thumb.png)](https://laravel-enso.github.io/addressesmanager/screenshots/bulma_042.png)

## Installation

Comes pre-installed in Enso.

## Features

- can be used to attach addresses to any entity, via a polymorphic relationship
- allows saving of multiple addresses for an addresable entity
- features an easy flow for setting the default address 
- comes with an additional table for Countries, with all the countries pre-populated
- brings its own free-form form for the edit and creation of addresses
- has a publishable configuration file where you can customize the module to your liking 
- includes an `Addressable` trait, for defining relationships and attributes
- the package as whole is designed to be extendable, so you could create custom versions for specific countries

### Configuration & Usage

Be sure to check out the full documentation for this package available at [docs.laravel-enso.com](https://docs.laravel-enso.com/backend/addresses-manager.html)

### Contributions

are welcome. Pull requests are great, but issues are good too.

### License

This package is released under the MIT license.
