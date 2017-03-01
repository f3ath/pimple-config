<?php
// Generic application settings
return function (\Silex\Application $app, array $config, string $env) {
    $app['env'] = $env;
    $app['debug'] = $config['debug'];
};
