<?php

namespace Netinternet\Logicboxes\Api;

class Reseller extends Base
{
    public function get($id)
    {
        return $this->request('resellers/details.json', ['reseller-id' => $id], 'GET', false);
    }
}
