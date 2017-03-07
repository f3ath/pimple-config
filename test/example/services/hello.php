<?php
// Configure the hello service
return function (\Pimple\Container $container, array $config) {
    $container['hello'] = function () use ($config) {
        return "foo is {$config['foo']}, bar is {$config['bar']}, password is {$config['password']}";
    };
};
