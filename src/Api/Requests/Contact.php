<?php

namespace Netinternet\Logicboxes\Api\Requests;

use Netinternet\Logicboxes\Api\Base;

class Contact extends Base
{
    public $domain;

    public function __construct($domain)
    {
        $this->domain = $domain;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @throws \Exception
     * @return array
     */
    public function __call($name, $arguments)
    {
        $actions = [
            'ids' => 'ContactIds',
            'tech' => 'TechContactDetails',
            'admin' => 'AdminContactDetails',
            'billing' => 'BillingContactDetails',
            'registrant' => 'RegistrantContactDetails',
        ];

        if (array_key_exists($name, $actions)) {
            return $this->detail($actions[$name]);
        }

        throw new \Exception('Given method does not exists in contact details');
    }
    private function detail($name)
    {
        return $this->request('domains/details-by-name.json', [
            'domain-name' => $this->domain,
            'options' => $name
        ]);
    }
}
