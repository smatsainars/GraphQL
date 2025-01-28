<?php

namespace App\Schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Schema\Entities\Product;

class MutationType extends ObjectType {
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;

        parent::__construct([
            'name' => 'Mutation',
            'fields' => [
                'addProduct' => [
                    'type' => Types::productType(),
                    'args' => [
                        'input' => Type::nonNull(Types::productInputType()),
                    ],
                    'resolve' => function ($root, $args) {
                        $product = new Product();
                        $product->setId($args['input']['id']);
                        $product->setName($args['input']['name']);
                        // ... set other fields
                        $this->entityManager->persist($product);
                        $this->entityManager->flush();
                        return $product;
                    },
                ],
            ],
        ]);
    }
}