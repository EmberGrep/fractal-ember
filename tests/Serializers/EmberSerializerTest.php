<?php

use EmberGrep\Serializers\EmberSerializer;
use EmberGrep\Serializers\Test\Stubs\GenericBookTransformer;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Scope;

class EmberSerializerTest extends PHPUnit_Framework_TestCase
{
    private $manager;

    public function setUp()
    {
        $this->manager = new Manager();
        $this->manager->setSerializer(new EmberSerializer());
    }

    public function testSerializingEmptyIncludes()
    {
        $this->manager->parseIncludes('author');

        $bookData = [
            'title'   => 'Foo',
            'year'    => '1991',
            '_author' => [
                'name' => 'Dave',
            ],
        ];

        $resource = new Item($bookData, new GenericBookTransformer(), 'books');

        $scope = new Scope($this->manager, $resource);

        $expected = [
            'books'  => [
                [
                    'title' => 'Foo',
                    'year'  => 1991,
                ],
            ],
            'author' => [
                [
                    'name' => 'Dave',
                ],
            ],
        ];

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"books":[{"title":"Foo","year":1991}],"author":[{"name":"Dave"}]}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testSerializingItemResource()
    {
        $this->manager->parseIncludes('author');

        $bookData = [
            'title'   => 'Foo',
            'year'    => '1991',
            '_author' => [
                'name' => 'Dave',
            ],
        ];

        $resource = new Item($bookData, new GenericBookTransformer(), 'books');

        $scope = new Scope($this->manager, $resource);

        $expected = [
            'books'  => [
                [
                    'title' => 'Foo',
                    'year'  => 1991,
                ],
            ],
            'author' => [
                [
                    'name' => 'Dave',
                ],
            ],
        ];

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"books":[{"title":"Foo","year":1991}],"author":[{"name":"Dave"}]}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testSerializingCollectionResource()
    {
        $this->manager->parseIncludes('author');

        $booksData = [
            [
                'title'   => 'Foo',
                'year'    => '1991',
                '_author' => [
                    'name' => 'Dave',
                ],
            ],
            [
                'title'   => 'Bar',
                'year'    => '1997',
                '_author' => [
                    'name' => 'Bob',
                ],
            ],
        ];

        $resource = new Collection($booksData, new GenericBookTransformer(), 'books');
        $scope = new Scope($this->manager, $resource);

        $expected = [
            'books'  => [
                [
                    'title' => 'Foo',
                    'year'  => 1991,
                ],
                [
                    'title' => 'Bar',
                    'year'  => 1997,
                ],
            ],
            'author' => [
                ['name' => 'Dave'],
                ['name' => 'Bob'],
            ],
        ];

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"books":[{"title":"Foo","year":1991},{"title":"Bar","year":1997}],"author":[{"name":"Dave"},{"name":"Bob"}]}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testSerializingItemResourceWithMeta()
    {
        $this->manager->parseIncludes('author');

        $bookData = [
            'title'   => 'Foo',
            'year'    => '1991',
            '_author' => [
                'name' => 'Dave',
            ],
        ];

        $resource = new Item($bookData, new GenericBookTransformer(), 'book');
        $resource->setMetaValue('foo', 'bar');

        $scope = new Scope($this->manager, $resource);

        $expected = [
            'book'   => [
                [
                    'title' => 'Foo',
                    'year'  => 1991,
                ],
            ],
            'author' => [
                [
                    'name' => 'Dave',
                ],
            ],
            'meta'   => [
                'foo' => 'bar',
            ],
        ];

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"book":[{"title":"Foo","year":1991}],"author":[{"name":"Dave"}],"meta":{"foo":"bar"}}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testSerializingCollectionResourceWithMeta()
    {
        $this->manager->parseIncludes('author');

        $booksData = [
            [
                'title'   => 'Foo',
                'year'    => '1991',
                '_author' => [
                    'name' => 'Dave',
                ],
            ],
            [
                'title'   => 'Bar',
                'year'    => '1997',
                '_author' => [
                    'name' => 'Bob',
                ],
            ],
        ];

        $resource = new Collection($booksData, new GenericBookTransformer(), 'book');
        $resource->setMetaValue('foo', 'bar');

        $scope = new Scope($this->manager, $resource);

        $expected = [
            'book'   => [
                [
                    'title' => 'Foo',
                    'year'  => 1991,
                ],
                [
                    'title' => 'Bar',
                    'year'  => 1997,
                ],
            ],
            'author' => [
                ['name' => 'Dave'],
                ['name' => 'Bob'],
            ],
            'meta'   => [
                'foo' => 'bar',
            ],
        ];

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"book":[{"title":"Foo","year":1991},{"title":"Bar","year":1997}],"author":[{"name":"Dave"},{"name":"Bob"}],"meta":{"foo":"bar"}}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testSerializingCollectionResourceWithDuplicatedIncludeData()
    {
        $this->manager->parseIncludes('author');

        $booksData = array(
            array(
                'title' => 'Foo',
                'year' => '1991',
                '_author' => array(
                    'id' => 1,
                    'name' => 'Dave',
                ),
            ),
            array(
                'title' => 'Bar',
                'year' => '1997',
                '_author' => array(
                    'id' => 1,
                    'name' => 'Dave',
                ),
            ),
        );

        $resource = new Collection($booksData, new GenericBookTransformer(), 'book');
        $scope = new Scope($this->manager, $resource);

        $expected = array(
            'book' => array(
                array(
                    'title' => 'Foo',
                    'year' => 1991,
                ),
                array(
                    'title' => 'Bar',
                    'year' => 1997,
                ),
            ),
            'author' => array(
                array(
                    'id' => 1,
                    'name' => 'Dave',
                ),
            ),
        );

        $this->assertEquals($expected, $scope->toArray());

        $expectedJson = '{"book":[{"title":"Foo","year":1991},{"title":"Bar","year":1997}],"author":[{"id":1,"name":"Dave"}]}';
        $this->assertEquals($expectedJson, $scope->toJson());
    }

    public function testResourceKeyMissing()
    {
        $this->manager->setSerializer(new EmberSerializer());

        $bookData = array(
            'title' => 'Foo',
            'year' => '1991',
        );

        $resource = new Item($bookData, new GenericBookTransformer());
        $scope = new Scope($this->manager, $resource);

        $expected = array(
            'data' => array(
                array(
                    'title' => 'Foo',
                    'year' => 1991,
                ),
            ),
        );

        $this->assertEquals($expected, $scope->toArray());
    }

    public function tearDown()
    {
        Mockery::close();
    }
}
