<?php
return array_replace_recursive(require __DIR__ . '/common.php', [ // inherit from common config
    'secret_json' => __DIR__.'/secret.json',
    'bar' => 'prod_bar', // override this key
]);
