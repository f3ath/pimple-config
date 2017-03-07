## Simple multi-environment configuration for Pimple/Silex with secret storage support
## Install
```
composer install f3ath/pimple-config
```
## Configuration structure
### Environment-specific config
A config is a file named `<environment_name>.php` which returns an array:
```php
<?php
// dev.php
return [
    'debug' => true,
    'foo' => [
        'bar' => 'baz'
    ]
];
```
To reduce duplication, here is some sort of "inheritance":
```php
<?php
// stage.php
return array_replace_recursive(require __DIR__ . '/common.php', [ // inherit from common config
    'debug' => false,
]);
```
### Secret config
It is a healthy practice to store sensitive data like passwords outside of the repository. The simplest implementation
would be to store such files right on the server. These files may be edited directly, so they should not be php scripts,
since there is a good chance to accidentally remove the `<?php` header and expose their content. A natural choice in
this case is JSON. PimpleConfig supports a special `secret_json` key to include such files.
```php
<?php
// prod.php
return array_replace_recursive(require __DIR__ . '/common.php', [ // inherit from common config
    'secret_json' => '/etc/my_application/secret.json',
    'debug' => false,
]);
```
### Services
Pimple services are configured in the set of files in the `services` directory. In your configuration you define:
```php
<?php
// common.php
return [
    'services' => [
        'application'   => __DIR__ . '/services/application.php',
        'storage'       => __DIR__ . '/services/storage.php',
        'controllers'   => __DIR__ . '/services/controllers.php',
    ],
];
```
A service config is a php script which returns a special function:
```php
<?php
// services/application.php
return function (\Pimple\Container $container, array $config, string $env) {
    $container['hello'] = function () use ($config, $env) {
        // here you create and return a service in Pimple way
    };
};
```
## Register the configuration

```php
   <?php
   $pimple = new \Pimple\Container();
   $env_name = 'prod';
   $config_root = '/path-to-config';
   $pimple->register(new \F3\PimpleConfig\Config($config_root, $env_name));
```

For more examples see the [unit test](test/ConfigTest.php).

### Contribution
Please do!
