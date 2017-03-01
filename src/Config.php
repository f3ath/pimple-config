<?php
namespace F3\SilexConfig;

use Silex\Application;

class Config
{
    const KEY_SERVICES = 'services';
    const KEY_SECRET_JSON = 'secret_json';
    private $dir;

    public function __construct(string $dir)
    {
        $this->dir = $dir;
    }

    public function configure(Application $app, string $env = 'prod')
    {
        $config = array_replace_recursive(
            $this->getDefaultConfig(),
            $this->getConfig($env)
        );
        if ($config[self::KEY_SECRET_JSON]) {
            $config = array_replace_recursive(
                $config,
                $this->getSecretConfig($config[self::KEY_SECRET_JSON])
            );
        }
        array_map(
            function ($service) use ($app, $config, $env) {
                (require $service)($app, $config, $env);
            },
            $config[self::KEY_SERVICES]
        );
    }

    private function getConfig(string $env): array
    {
        $file = "{$this->dir}/{$env}.php";
        if (file_exists($file)) {
            return include $file;
        }
        throw new \InvalidArgumentException("Configuration not found for $env");
    }

    private function getDefaultConfig(): array
    {
        return [
            self::KEY_SERVICES => [],
            self::KEY_SECRET_JSON => null,
        ];
    }

    private function getSecretConfig(string $file): array
    {
        return json_decode(file_get_contents($file), true);
    }
}
