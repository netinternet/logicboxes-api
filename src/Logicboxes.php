<?php

namespace Netinternet\Logicboxes;

class Logicboxes
{
    /**
     * Call requested class if exists.
     *
     * @param $name
     * @param $arguments
     *
     * @throws \Exception
     * @return bool
     */
    public function __call($name, $arguments)
    {
        if (is_null(config('logicboxes.api-key')) || is_null(config('logicboxes.auth-userid'))) {
            throw new \Exception('Logicboxes package: Please provide apikey and auth userid.');
        }
        if ($name == 'base') {
            throw new \Exception('Can\'t initialize base class');
        }

        $class = "Netinternet\\Logicboxes\\Api\\".ucwords($name);

        if (class_exists($class)) {
            $up = new $class($arguments);

            return $up;
        }

        return false;
    }
}
