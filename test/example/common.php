<?php
return [
    'services' => [ // services are executed in this order
        'app' => __DIR__ . '/services/app.php',
        'hello' => __DIR__ . '/services/hello.php',
    ],
    'debug' => false,
    'foo' => 'common_foo',
    'bar' => 'common_bar',
    'password' => '',
];
