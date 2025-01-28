<?php

namespace App\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Schema\Types;

class ProductType extends ObjectType {
    public function __construct() {
        parent::__construct([
            'name' => 'Product',
            'fields' => [
                'id' => Type::string(),
                'name' => Type::string(),
                'inStock' => Type::boolean(),
                'gallery' => Type::listOf(Type::string()),
                'description' => Type::string(),
                'category' => Types::categoryType(), // Define CategoryType similarly
                'attributes' => Type::listOf(Types::attributeSetType()),
                'prices' => Type::listOf(Types::priceType()),
                'brand' => Type::string(),
            ],
        ]);
    }
}