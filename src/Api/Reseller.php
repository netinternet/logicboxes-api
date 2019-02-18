<?php

namespace Netinternet\Logicboxes\Api;

class Reseller extends Base
{
    public function get($id)
    {
        return $this->request('resellers/details.json', ['reseller-id' => $id], 'GET', false);
    }

    public function loginToken($id, $ip)
    {
        return $this->request('resellers/generate-login-token.json', [
            'reseller-id' => $id,
            'ip' => $ip,
        ], 'GET', false);
    }
}
