# silex-config
Simple multi-environment configuration for Silex with secret storage support
## Install
```
composer install f3ath/silex-config
```
## Usage
```php
   <?php
   $app = new \Silex\Application\Application();
   $env = 'prod';
   $path = '/path-to-config';
   (new \F3\SilexConfig\Config($path))->configure($app, $env);
```

For more examples see the [unit test](test/ConfigTest.php).