<?php

require __DIR__ . '/vendor/autoload.php';

use Automattic\WooCommerce\Client;
use Automattic\WooCommerce\HttpClient\HttpClientException;

$woocommerce = new Client(
    'http://weew.ca',
    'ck_e01591aa12ab9940624896f283bad8749596529a',
    'cs_2d4f8bf3b170766aac68e48da95f6fef3ad25593',
    [
        'wp_api' => true,
        'version' => 'wc/v2',
    ]
);