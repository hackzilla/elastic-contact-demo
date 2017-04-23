<?php

require __DIR__.'/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build();

$index = 'simple';
$type = 'contact';

if (!isset($_GET['id'])) {
    die('id not set');
}

$id = $_GET['id'];

try {
    $response = $client->delete(
        [
            'index' => $index,
            'type'  => $type,
            'id'  => $id,
        ]
    );

    header('Location: search.php');
} catch (\Exception $e) {
    echo 'Failed to delete document ['.$index.'/'.$type.']: '.$e->getMessage().PHP_EOL;
    die;
}
