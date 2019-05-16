# Addresses

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/c7404086a15a4db6b2080b1d09b0688a)](https://www.codacy.com/app/laravel-enso/addresses?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=laravel-enso/addresses&amp;utm_campaign=Badge_Grade)
[![StyleCI](https://github.styleci.io/repos/113445673/shield?branch=master)](https://github.styleci.io/repos/113445673)
[![License](https://poser.pugx.org/laravel-enso/addresses/license)](https://packagist.org/packages/laravel-enso/addresses)
[![Total Downloads](https://poser.pugx.org/laravel-enso/addresses/downloads)](https://packagist.org/packages/laravel-enso/addresses)
[![Latest Stable Version](https://poser.pugx.org/laravel-enso/addresses/version)](https://packagist.org/packages/laravel-enso/addresses)

Free-form addresses manager for [Laravel Enso](https://github.com/laravel-enso/Enso)

This package works exclusively within the [Enso](https://github.com/laravel-enso/Enso) ecosystem.

There is a front end implementation for this this api in the [accessories](https://github.com/enso-ui/accessories) package.

For live examples and demos, you may visit [laravel-enso.com](https://www.laravel-enso.com)

[![Screenshot](https://laravel-enso.github.io/addresses/screenshots/bulma_041_thumb.png)](https://laravel-enso.github.io/addresses/screenshots/bulma_041.png)

[![Screenshot](https://laravel-enso.github.io/addresses/screenshots/bulma_042_thumb.png)](https://laravel-enso.github.io/addresses/screenshots/bulma_042.png)

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
