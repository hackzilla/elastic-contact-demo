<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build()
;

$index = 'simple';
$type = 'contact';

try {
    $response = $client->indices()->putMapping([
        'index' => $index,
        'type'  => $type,
        'body' => [
            $type => [
                'properties' => [
                    'first_name' => [
                        'type' => 'keyword',
                    ],
                    'last_name' => [
                        'type' => 'keyword',
                    ],
                    'email' => [
                        'type' => 'keyword',
                    ],
                    'birthday' => [
                        'type' => 'date',
                        'format' => 'yyyy-MM-dd',
                    ],
                    'address' => [
                        'type' => 'nested',
                        'properties' => [
                            'street' => ['type' => 'keyword'],
                            'city' => ['type' => 'keyword'],
                            'postcode' => ['type' => 'keyword'],
                            'county' => ['type' => 'keyword'],
                        ],
                    ],
                    'company' => [
                        'type' => 'keyword',
                    ],
                    'details' => [
                        'type' => 'text',
                    ],
                ],
            ],
        ],
        'update_all_types' => true,
    ]);
    echo 'Index mapping created: ' . $index . '/' . $type . PHP_EOL;
} catch (\Exception $e) {
    echo 'Failed to create index mapping [' . $index . '/' . $type . ']: ' . $e->getMessage() . PHP_EOL;
}
