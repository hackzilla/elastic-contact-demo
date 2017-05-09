Elastic Contact Demo
====================

# Requirements

You will need to [install docker](https://store.docker.com/search?offering=community&q=&type=edition) and update the [vm_map_max_count](https://www.elastic.co/guide/en/elasticsearch/reference/current/docker.html) before Elastic will run properly.

# Installation

* git clone git@github.com:hackzilla/elastic-contact-demo.git
* composer install --no-interaction --working-dir=./code;
* docker-compose up -d
* ./connect.sh

# Examples

## CLI

Once you run ```./connect.sh``` you will be able to run these examples.
E.g. ```php create-index.php```

* create-index.php [Create Index]
* create-mapping.php [Create Type and Mapping]
* put-document.php [Generate Document]
* put-documents.php [Generate Documents]
* update-documents.php [Update Document, requires id being set manually]
* delete-index.php [Delete Index]
* delete-document.php [Delete Document]

## Browser

Visit ```http://127.0.0.1:8888/``` to run these examples.

* search.php [List Documents]
* fetch.php  [View Document]

# Warning

This is are examples on how to use Elastic Search, and not how to write secure PHP.

For a better example, see [elastic dashboard demo](https://github.com/hackzilla/elastic-dashboard-demo).
