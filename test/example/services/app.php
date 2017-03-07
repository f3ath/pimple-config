<?php
// Generic application settings
return function (\Pimple\Container $container, array $config, string $env) {
    $container['env'] = $env;
    $container['debug'] = $config['debug'];
};
