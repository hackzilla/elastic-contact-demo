<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build()
;

$index = 'simple';
$type = 'contact';
$id = '';

$faker = \Faker\Factory::create('en_GB');

$document = [
    'first_name' => $faker->firstName,
    'last_name' => $faker->lastName,
    'email' => $faker->email,
    'birthday' => $faker->dateTimeThisCentury->format('Y-m-d'),
    'company' => $faker->company,
    'address' => [
        'street' => $faker->streetAddress,
        'city' => $faker->city,
        'county' => $faker->county,
        'postcode' => $faker->postcode,
    ],
    'details' => $faker->text(400),
];

try {
    $response = $client->update([
        'index' => $index,
        'type'  => $type,
        'id'    => $id,
        'body'  => [
            'doc' => $document,
        ],
    ]);

    echo 'Document updated: ' . $index . '/' . $type . '/' . $id . PHP_EOL;
} catch (\Exception $e) {
    echo 'Failed to create document [' . $index . '/' . $type . ']: ' . $e->getMessage() . PHP_EOL;
}
