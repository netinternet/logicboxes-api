<?php

namespace Netinternet\Logicboxes\Facades;

use Illuminate\Support\Facades\Facade;

class Logicboxes extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'logicboxes';
    }
}
