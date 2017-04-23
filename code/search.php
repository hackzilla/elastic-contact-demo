<html>
<head>
    <style>
        .pagination a {
            width: 100px;
            height: 30px;
            float: left;
            padding-top: 10px;
            margin-right: 4em;
            height: 30px;
            padding-top: 10px;
        }

        .button {
            display: block;
            width: 100px;
            background: #222;
            height: 23px;
            padding-top: 4px;
            border: 1px solid black;
            color: white;
            text-align: center;
            border-radius: 25px;
        }

        table {
            width: 100%;
        }

        table tr th, table tr td {
            padding: 5px;
        }

        table th {
            text-align: left;
        }

        table tr:hover {
            background-color: crimson;
            color: white;
        }

        table thead {
            background-color: darkgray;
        }
    </style>
</head>
<body>
<?php

require __DIR__.'/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['elastic'])
    ->build();

$index = 'simple';
$type = 'contact';
$size = 10;

$page = 0;

if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
}

if ($page < 0) {
    $page = 0;
}

$from = $page * $size;

try {
    $response = $client->search(
        [
            'index' => $index,
            'type'  => $type,
            'from'  => ($page * $size),
            'size'  => $size,
//        'body' => [
//            'query' => [
//                'match' => [
//                    'testField' => 'abc'
//                ]
//            ]
//        ]
        ]
    );

} catch (\Exception $e) {
    echo 'Failed to search ['.$index.'/'.$type.']: '.$e->getMessage().PHP_EOL;
}

echo '
<h1>Contacts</h1>
<p>Found: '.$response['hits']['total'].'</p>
<p>Page: '.($page + 1).'</p>
<table cellpadding="0" cellspacing="0">
<thead>
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Actions</th>
    </tr>
</thead>
<tbody>
';

foreach ($response['hits']['hits'] as $document) {
    echo '<tr>
        <td>'.$document['_id'].'</td>
        <td>'.$document['_source']['first_name'].'</td>
        <td>'.$document['_source']['last_name'].'</td>
        <td><a href="/fetch.php?id='.$document['_id'].'" class="button">view</a></td>
    </tr>
';

}

?>
</tbody>
</table>

<p class="pagination">
    <?php if ($page) { ?><a href="/search.php?page=<?php echo $page - 1; ?>" class="button">prev</a><?php } ?>
    <?php if ((($page * $size) + $page) < $response['hits']['total']) { ?><a href="/search.php?page=<?php echo $page + 1; ?>" class="button">next</a><?php } ?>
</p>
</body>
</html>
