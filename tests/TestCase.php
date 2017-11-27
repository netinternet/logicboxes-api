<?php
namespace Netinternet\Logicboxes\Test;

use Netinternet\Logicboxes\Facades\Logicboxes;
use Netinternet\Logicboxes\LogicboxesServiceProvider;
use PHPUnit\Framework\TestCase as BaseTestCase;

class TestCase extends BaseTestCase
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
}