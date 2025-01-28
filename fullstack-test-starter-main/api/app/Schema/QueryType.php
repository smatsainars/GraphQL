<?php

namespace App\Schema;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use App\Schema\Entities\Product;
use App\Schema\Types;

class QueryType extends ObjectType {
    private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;

        parent::__construct([
            'name' => 'Query',
            'fields' => [
                'products' => [
                    'type' => Type::listOf(Types::productType()),
                    'args' => [
                        'category' => ['type' => Type::string()],
                    ],
                    'resolve' => function ($root, $args) {
                        $criteria = [];
                        if (isset($args['category'])) {
                            $criteria['category'] = $args['category'];
                        }
                        return $this->entityManager
                            ->getRepository(Product::class)
                            ->findBy($criteria);
                    },
                ],
                'categories' => [
                    'type' => Type::listOf(Types::categoryType()),
                    'resolve' => function () {
                        return $this->entityManager
                            ->getRepository(Category::class)
                            ->findAll();
                    },
                ],
            ],
        ]);
    }
}