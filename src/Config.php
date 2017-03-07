<?php
namespace F3\PimpleConfig;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Config implements ServiceProviderInterface
{
    private $dir;
    private $env;

    public function __construct(string $config_root, string $environment_name)
    {
        $this->dir = $config_root;
        $this->env = $environment_name;
    }

    public function register(Container $pimple)
    {
        $config = $this->getConfig();
        $config = $this->applySecretConfig($config);
        $this->configureServices($pimple, $config);
    }

    protected function getConfig(): array
    {
        $file = "{$this->dir}/{$this->env}.php";
        if (file_exists($file)) {
            return include $file;
        }
        throw new \InvalidArgumentException("Configuration not found for {$this->env}");
    }

    protected function applySecretConfig($config): array
    {
        return array_replace_recursive(
            $config,
            $this->getSecretConfig($config)
        );
    }

    protected function getSecretConfig(array $config): array
    {
        $secret_json = $config['secret_json'] ?? null;
        if ($secret_json) {
            return json_decode(file_get_contents($secret_json), true);
        }
        return [];
    }

    protected function configureServices(Container $container, array $config)
    {
        array_map(
            function ($service) use ($container, $config) {
                (require $service)($container, $config, $this->env);
            },
            $config['services']
        );
    }
}
