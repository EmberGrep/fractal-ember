<?php namespace EmberGrep\Serializers\Test\Stubs;

use League\Fractal\TransformerAbstract;

class GenericAuthorTransformer extends TransformerAbstract
{
    public function transform(array $author)
    {
        return $author;
    }
}
