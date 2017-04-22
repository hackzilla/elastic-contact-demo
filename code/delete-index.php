<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build()
;

$index = 'simple';

try {
    $response = $client->indices()->delete([
        'index' => $index,
    ]);
    echo 'Index deleted: ' . $index . PHP_EOL;
} catch (\Exception $e) {
    echo 'Failed to deletee index [' . $index . ']: ' . $e->getMessage() . PHP_EOL;
}
