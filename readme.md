# SitesModule

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Create Apartments

## Installation

Via Composer

``` bash
$ composer require zdrojowa/sites-module
```

## Usage

- Add module SitesModule in config/selene.php

``` bash
'modules' => [
    SitesModule::class,
],

'menu-order' => [
    'SitesModule',
],
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [author name][link-author]
- [All Contributors][link-contributors]

## License

license. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/zdrojowa/sites-module.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/zdrojowa/sites-module.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/zdrojowa/sites-module/master.svg?style=flat-square
[ico-styleci]: https://styleci.io/repos/12345678/shield

[link-packagist]: https://packagist.org/packages/zdrojowa/sites-module
[link-downloads]: https://packagist.org/packages/zdrojowa/sites-module
[link-travis]: https://travis-ci.org/zdrojowa/sites-module
[link-styleci]: https://styleci.io/repos/12345678
[link-author]: https://github.com/zdrojowa
[link-contributors]: ../../contributors
