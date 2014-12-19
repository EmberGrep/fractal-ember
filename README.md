# League Skeleton

[![Latest Version](https://img.shields.io/github/release/embergrep/fractal-ember.svg?style=flat-square)](https://github.com/embergrep/fractal-ember/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/embergrep/fractal-ember/master.svg?style=flat-square)](https://travis-ci.org/embergrep/fractal-ember)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/embergrep/fractal-ember.svg?style=flat-square)](https://scrutinizer-ci.com/g/embergrep/fractal-ember/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/embergrep/fractal-ember.svg?style=flat-square)](https://scrutinizer-ci.com/g/embergrep/fractal-ember)
[![Total Downloads](https://img.shields.io/packagist/dt/embergrep/fractal-ember.svg?style=flat-square)](https://packagist.org/packages/embergrep/fractal-ember)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ composer require embergrep/fractal-ember
```

## Usage

``` php
use Acme\Model\Book;
use Acme\Transformer\BookTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Embergrep\Serializers\EmberSerializer;

$manager = new Manager();
$manager->setSerializer(new EmberSerializer());

// Some sort of ORM call
$book = Book::find(1);

// Make a resource out of the data and
$resource = new Item($book, new BookTransformer(), 'book');

// Run all transformers
$manager->createData($resource)->toArray();

// Outputs:
// [
//     'book' => [
//         'id' => 'Foo',
//         'title' => 'Foo',
//         'year' => 1991,
//     ],
//     'authors' => [
//         [
//             'id' => 'Baz',
//             'name' => 'Walter',
//     ],
// ];
```

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/embergrep/fractal-ember/blob/master/CONTRIBUTING.md) for details.

## Credits

- [Ryan Tablada](https://github.com/rtablada)
- [All Contributors](https://github.com/embergrep/fractal-ember/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
