<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build()
;

$index = 'simple';

try {
    $response = $client->indices()->create([
        'index' => $index,
        'body' => [
            'settings' => [
                'number_of_shards' => 2,
                'number_of_replicas' => 0,
            ],
        ],
    ]);
    echo 'Index created: ' . $index . PHP_EOL;
} catch (\Exception $e) {
    echo 'Failed to create index [' . $index . ']: ' . $e->getMessage() . PHP_EOL;
}
