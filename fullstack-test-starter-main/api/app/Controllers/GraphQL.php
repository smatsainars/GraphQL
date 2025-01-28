<?php

namespace App\Controllers;

use App\Schema\SchemaFactory;
use GraphQL\GraphQL as GraphQLBase;
use RuntimeException;
use Throwable;

class GraphQL {
    public static function handle() {
        try {
            // Use SchemaFactory to create the schema
            $schema = SchemaFactory::create();

            // Parse the incoming GraphQL request
            $rawInput = file_get_contents('php://input');
            if ($rawInput === false) {
                throw new RuntimeException('Failed to read input data.');
            }

            $input = json_decode($rawInput, true);
            if (!isset($input['query']) || empty($input['query'])) {
                throw new RuntimeException('No GraphQL query found in the request.');
            }

            $query = $input['query'];
            $variableValues = $input['variables'] ?? null;

            // Root value can be used for query context
            $rootValue = ['prefix' => 'You said: '];

            // Execute the query using the schema
            $result = GraphQLBase::executeQuery($schema, $query, $rootValue, null, $variableValues);
            $output = $result->toArray();
        } catch (Throwable $e) {
            // Handle errors and return a meaningful response
            $output = [
                'error' => [
                    'message' => $e->getMessage(),
                ],
            ];
        }

        // Return the result as JSON
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode($output);
    }
}
