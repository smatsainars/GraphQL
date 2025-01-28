<?php

namespace App\Schema;

use GraphQL\Type\Schema;
use Doctrine\ORM\EntityManager;
use App\Schema\QueryType;
use App\Schema\MutationType; 

class SchemaFactory {
    public static function create(EntityManager $entityManager): Schema {
        return new Schema([
            'query' => new QueryType($entityManager),
            'mutation' => new MutationType($entityManager),
        ]);
    }
}