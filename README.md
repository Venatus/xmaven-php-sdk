# XMAVEN SDK for PHP

[![@XmavenVideo on Twitter](http://img.shields.io/badge/twitter-%40xmavenvideo-blue.svg?style=flat)](https://twitter.com/xmavenvideo)

This library has been created for PHP developers using the Xmaven platform. It provides a very lightweight wrapper to communicate with Xmaven API. Getting started could not be easier, find our package on packagist: https://packagist.org/packages/venatus/xmaven-php-sdk

Install by adding { .. "venatus/xmaven-php-sdk": "0.1" .. } to your composer.json file.

The wrapper creates a Guzzle request object. This can be used to further extends the library where required. More information about Guzzle can be found here: http://guzzle.readthedocs.org/en/latest/

### Installing via Composer

The recommended way to install Guzzle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of Guzzle:

```bash
composer.phar require venatus/xmaven-php-sdk
```

After installing, you need to require Composer's autoloader:

```php
require 'vendor/autoload.php';
```

### PHP Examples

```php
<?php
require 'vendor/autoload.php';

//Create instance of the API Wrapper
$xm = new Xmaven\API($userId, $privateKey);

//Get all media items
$res = $xm->makeRequest('GET','/v1/media');

//Get all media items, limit to just 5 returned.
$res = $xm->makeRequest('GET','/v1/media', array(
  'limit' => 5,
));

//Create a new media item
$res = $xm->makeRequest('POST','/v1/media',array(),array(
  'title' => 'test',
));
var_dump($res);
```

### Documentation

More information can be found in the online documentation at
https://docs.xmaven.com/api/01-installation