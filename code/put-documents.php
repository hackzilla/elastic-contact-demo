<?php

require __DIR__ . '/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build()
;

$index = 'simple';
$type = 'contact';

$faker = \Faker\Factory::create('en_GB');
$documents = [];

$params = [
    'index' => $index,
    'type'  => $type,
    'body' => [],
];

for ($i = 0; $i < 10; $i++) {
    $params['body'][] = [
        'index' => [
            '_index' => $index,
            '_type'  => $type,
        ],
    ];

    $params['body'][] = [
        'first_name' => $faker->firstName,
        'last_name'  => $faker->lastName,
        'email'      => $faker->email,
        'birthday'   => $faker->dateTimeThisCentury->format('Y-m-d'),
        'company'    => $faker->company,
        'address'    => [
            'street'   => $faker->streetAddress,
            'city'     => $faker->city,
            'county'   => $faker->county,
            'postcode' => $faker->postcode,
        ],
        'details'    => $faker->text(400),
    ];
}

try {
    $response = $client->bulk($params);

    $items = [];

    foreach ($response['items'] as $item) {
        $items[] = $item['index']['_id'];
    }

    echo 'Documents created: ' . $index . '/' . $type . '/[' . implode(',', $items) . ']' . PHP_EOL;
} catch (\Exception $e) {
    echo 'Failed to create documents [' . $index . '/' . $type . ']: ' . $e->getMessage() . PHP_EOL;
}
