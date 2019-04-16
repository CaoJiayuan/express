<?php namespace Nerio\Express;


use Nerio\Express\Drivers\KdNiaoExpress;
use Nerio\Express\Drivers\SimpleClient;

/**
 * @author caojiayuan
 */
class ExpressManager
{
    protected $drivers = [];
    protected $driverRegisters = [];
    protected $config;

    protected $defaultDriver;

    public function __construct($config)
    {
        $this->config = $config;
        $this->defaultDriver = $config['default'] ?? 'kdniao';
    }

    public static function withDefaultDrivers($config, $cache = null)
    {
        $manager = new static($config);

        SimpleClient::setCache($cache);

        $manager->register('kdniao', function ($config) {
            return new KdNiaoExpress($config['ebussionsid'], $config['appKey']);
        });

        return $manager;
    }

    public function register($driver, \Closure $register)
    {
        $this->driverRegisters[$driver] = $register;
    }

    public function driver($name = null)
    {
        return $this->get($name ?: $this->defaultDriver);
    }

    /**
     * @param $name
     * @return Express
     */
    public function get($name)
    {
        if (array_key_exists($name, $this->drivers)) {
            return $this->drivers[$name];
        }

        if (!array_key_exists($name, $this->driverRegisters)) {
            throw new \InvalidArgumentException("invalid express driver [{$name}]");
        }

        return $this->drivers[$name] = call_user_func($this->driverRegisters[$name], $this->getConfigFor($name));
    }

    protected function getConfigFor($driver)
    {
        return $this->config[$driver] ?? [];
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->driver(), $name], $arguments);
    }
}