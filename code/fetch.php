<html>
<head>
    <style>
        table {
            width: 100%;
        }

        table tr th, table tr td {
            padding: 10px;
        }

        table th {
            text-align: left;
            background-color: black;
            color: white;
        }

        table tr:hover {
            background-color: crimson;
            color: white;
        }

        table td {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
<h1>Contact</h1>
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
    $response = $client->get(
        [
            'index' => $index,
            'type'  => $type,
            'id'  => $id,
        ]
    );
} catch (\Exception $e) {
    echo 'Failed to get document ['.$index.'/'.$type.']: '.$e->getMessage().PHP_EOL;
    die;
}

$document = $response['_source'];

?>
<table cellpadding="0" cellspacing="0">
<tbody>
    <tr>
        <th>Name</th>
        <td><?php echo $document['first_name'] . ' ' . $document['last_name']; ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?php echo $document['email']; ?></td>
    </tr>
    <tr>
        <th>Address</th>
        <td><?php
            echo str_replace("\n", '<br>', $document['address']['street']) . '<br>';
            echo $document['address']['city'] . '<br>';
            echo $document['address']['county'] . '<br>';
            echo $document['address']['postcode'];
        ?></td>
    </tr>
    <tr>
        <th>Birthday</th>
        <td><?php echo $document['birthday']; ?></td>
    </tr>
    <tr>
        <th>Employer</th>
        <td><?php echo $document['company']; ?></td>
    </tr>
    <tr>
        <th>Notes</th>
        <td><?php echo $document['details']; ?></td>
    </tr>
</tbody>
</table>

<p><a href="search.php">back</a></p>
</body>
</html>
