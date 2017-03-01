<?php
// Configure the hello service
return function (\Silex\Application $app, array $config) {
    $app['hello'] = function () use ($config) {
        return "foo is {$config['foo']}, bar is {$config['bar']}, password is {$config['password']}";
    };
};
