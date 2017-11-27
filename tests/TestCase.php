<?php
namespace Netinternet\Logicboxes\Test;

use Netinternet\Logicboxes\Facades\Logicboxes;
use Netinternet\Logicboxes\LogicboxesServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [LogicboxesServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Logicboxes' => Logicboxes::class,
        ];
    }
    protected function getEnvironmentSetUp($app)
    {
        $config = parse_ini_file("config.ini");
        $app['config']->set('logicboxes.api-key', $config['key']);
        $app['config']->set('logicboxes.auth-userid', $config['userId']);
    }
}