<?php
return array_replace_recursive(require __DIR__ . '/common.php', [ // inherit from common config
    'debug' => true,
    'foo' => 'dev_foo', // override this key
    'password' => 'dev_password',
]);
