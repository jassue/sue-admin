<?php
/**
 * Created by PhpStorm.
 * User: mattsue15@163.com
 * Date: 2019/7/14
 * Time: 12:02
 */

namespace app\common\command;


use think\console\Command;
use think\console\Input;
use think\console\input\Option;
use think\console\Output;

class InitConfig extends Command
{
    protected function configure()
    {
        $this->setName('init')
            ->addOption('db', null, Option::VALUE_REQUIRED, 'mysql config')
            ->addOption('redis', null, Option::VALUE_REQUIRED, 'redis config')
            ->setDescription('initConfig');
    }

    protected function execute(Input $input, Output $output)
    {
        $dbConfigStr = $input->getOption('db');
        $redisConfigStr = $input->getOption('redis');
        if (is_null($dbConfigStr)) {
            exception('Option "db" is not defined');
        }
        if (is_null($redisConfigStr)) {
            exception('Option "redis" is not defined');
        }
        $this->removeEnvContent();
        $this->writeToEnv($this->parseDbConfigStr($dbConfigStr));
        $this->writeToEnv($this->parseRedisConfigStr($redisConfigStr));
        $output->writeln('init success');
    }

    /**
     * @param string $configStr
     * @return mixed
     */
    private function parseDbConfigStr(string $configStr)
    {
        $config['db_type'] = substr($configStr, 0, strpos($configStr, ':'));
        $configStr = ltrim($configStr, $config['db_type'] . '://');
        $config['db_username'] = substr($configStr, 0, strpos($configStr, ':'));
        $configStr = ltrim($configStr, $config['db_username']);
        $config['db_password'] = substr($configStr, 1, strripos($configStr, '@') - 1);
        $configStr = substr($configStr, strripos($configStr, '@') + 1);
        $config['db_hostname'] = substr($configStr, 0, strpos($configStr, ':'));
        $configStr = ltrim($configStr, $config['db_hostname'] . ':');
        $config['db_hostport'] = substr($configStr, 0, strpos($configStr, '/'));
        $configStr = ltrim($configStr, $config['db_hostport'] . '/');
        $config['db_database'] = substr($configStr, 0, strpos($configStr, '#'));
        $config['db_charset'] = substr($configStr, strpos($configStr, '#') + 1);
        return $config;
    }

    /**
     * @param string $configStr
     * @return mixed
     */
    private function parseRedisConfigStr(string $configStr)
    {
        $config['redis_password'] = substr($configStr, 0, strripos($configStr, '@'));
        $configStr = substr($configStr, strripos($configStr, '@') + 1);
        $config['redis_host'] = substr($configStr, 0, strpos($configStr, ':'));
        $config['redis_port'] = substr($configStr, strripos($configStr, ':') + 1);
        return $config;
    }

    private function removeEnvContent()
    {
        file_put_contents(getcwd() . '/.env', '');
    }

    /**
     * @param array $config
     */
    private function writeToEnv(Array $config)
    {
        $envStr = '';
        foreach ($config as $name => $value) {
            $envStr .= strtoupper($name) . '=' . $value . "\r\n";
        }
        file_put_contents(getcwd() . '/.env', $envStr, FILE_APPEND);
    }
}