<?php

namespace Netinternet\Logicboxes\Api;

use Netinternet\Logicboxes\Api\Requests\Contact;

class Domain extends Base
{
    public $domain;

    private $url = 'domains/details-by-name.json';

    public function __construct($arguments)
    {
        if (isset($arguments[0])) {
            $this->domain = $arguments[0];
        }
    }

    /**
     * Get domain details.
     *
     * @return array
     */
    public function nameservers()
    {
        return $this->domain('NsDetails');
    }

    /**
     * Get domain details.
     *
     * @return array
     */
    public function details()
    {
        return $this->domain('All');
    }

    /**
     * Get domain status.
     *
     * @return array
     */
    public function status()
    {
        return $this->domain('DomainStatus');
    }

    /**
     * Get order details.
     *
     * @return array
     */
    public function order()
    {
        return $this->domain('OrderDetails');
    }

    /**
     * Get dnssec information.
     *
     * @return array
     */
    public function dnssec()
    {
        return $this->domain('DNSSECDetails');
    }

    /**
     * Get contact details object.
     *
     * @return Contact
     */
    public function contact()
    {
        return new Contact($this->domain);
    }

    /**
     * @alias nameservers
     *
     * @return array
     */
    public function ns()
    {
        return $this->nameservers();
    }

    /**
     * Check for given domain name. Tlds must be without dot.
     *
     * @param array $tlds
     * @param bool  $suggest
     *
     * @return array
     */
    public function check($tlds = ['com'], $suggest = false)
    {
        $query = [
            'domain-name' => $this->domain,
            'suggest-alternative' => json_encode($suggest),
            'tlds' => $tlds
        ];

        return $this->request('domains/available.json', $query, 'GET', true);
    }


    private function domain($option)
    {
        return $this->request($this->url, [
            'domain-name' => $this->domain,
            'options'     => $option
        ]);
    }
    /**
     * Get only orderId
     *
     * @return array
     */
    public function orderId()
    {
        return $this->request('domains/orderid.json', [
            'domain-name' => $this->domain
        ], 'GET');
    }

    /**
     * @return array
     */
    public function enableTheftProtection()
    {
        $resp = $this->orderId();

        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];
        $query = [
            'order-id' => $orderId
        ];
        return $this->request('domains/enable-theft-protection.json', $query, 'POST');
    }

    /**
     * @return array
     */
    public function disableTheftProtection()
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];
        $query = [
            'order-id' => $orderId
        ];

        return $this->request('domains/disable-theft-protection.json', $query, 'POST');
    }

    /**
     * @param array $ns
     * @return array
     */
    public function modifyNameServers(array $ns)
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        $query = [
            'order-id' => $orderId,
            'ns' => $ns
        ];
        return $this->request('domains/modify-ns.json', $query, 'POST', true);
    }

    /**
     * @return array
     */
    public function delete()
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];
        $query = [
            'order-id' => $orderId
        ];

        return $this->request('domains/delete.json', $query, 'POST');
    }

    /**
     * @return array
     */
    public function cancelTransfer()
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];
        $query = [
            'order-id' => $orderId
        ];

        return $this->request('domains/cancel-transfer.json', $query, 'POST');
    }

    /**
     * @param $years
     * @param $ns
     * @param $customerId
     * @param $regContactId
     * @param $adminContactId
     * @param $techContactId
     * @param $billingContactId
     * @param $invoiceOption
     * @param bool $purchasePrivacy
     * @param bool $protectPrivacy
     * @return array
     */
    public function register(
        $years,
        $ns,
        $customerId,
        $regContactId,
        $adminContactId,
        $techContactId,
        $billingContactId,
        $invoiceOption,
        $purchasePrivacy = false,
        $protectPrivacy = false
    ) {
        $query = [
            'domain-name' => $this->domain,
            'years' => $years,
            'ns' => $ns,
            'customer-id' => $customerId,
            'reg-contact-id' => $regContactId,
            'admin-contact-id' => $adminContactId,
            'tech-contact-id' => $techContactId,
            'billing-contact-id' => $billingContactId,
            'invoice-option' => $invoiceOption,
            'purchase-privacy' => $purchasePrivacy,
            'protect-privacy' => $protectPrivacy,
        ];
        return $this->request('domains/register.json', $query, 'POST', true);
    }

    /**
     * @param $authCode
     * @param $years
     * @param $ns
     * @param $customerId
     * @param $regContactId
     * @param $adminContactId
     * @param $techContactId
     * @param $billingContactId
     * @param $invoiceOption
     * @param bool $purchasePrivacy
     * @param bool $protectPrivacy
     * @return array
     */
    public function transfer(
        $authCode,
        $years,
        $ns,
        $customerId,
        $regContactId,
        $adminContactId,
        $techContactId,
        $billingContactId,
        $invoiceOption,
        $purchasePrivacy = false,
        $protectPrivacy = false
    ) {
        $query = [
            'domain-name' => $this->domain,
            'auth-code' => $authCode,
            'years' => $years,
            'ns' => $ns,
            'customer-id' => $customerId,
            'reg-contact-id' => $regContactId,
            'admin-contact-id' => $adminContactId,
            'tech-contact-id' => $techContactId,
            'billing-contact-id' => $billingContactId,
            'invoice-option' => $invoiceOption,
            'purchase-privacy' => $purchasePrivacy,
            'protect-privacy' => $protectPrivacy,
        ];

        return $this->request('domains/transfer.json', $query, 'POST', true);
    }

    /**
     * @param $authCode
     * @return array
     */
    private function prepareAuthCode($authCode)
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];
        return [
            'order-id'  => $orderId,
            'auth-code' => $authCode,
        ];
    }

    /**
     * @param $authCode
     * @return array
     */
    public function authCode($authCode)
    {
        $query = $this->prepareAuthCode($authCode);
        if (!$authCode === $query['auth-code']) {
            return $query;
        }
        return $this->request('domains/transfer/submit-auth-code.json', $query, 'POST');
    }

    /**
     * @param $authCode
     * @return array
     */
    public function modifyAuthCode($authCode)
    {
        $query = $this->prepareAuthCode($authCode);
        if (!$authCode === $query['auth-code']) {
            return $query;
        }
        return $this->request('domains/modify-auth-code.json', $query, 'POST');
    }

    /**
     * @return array
     */
    public function validateTransferRequest()
    {
        $query = [
            'domain-name'   => $this->domain,
        ];
        return $this->request('domains/validate-transfer.json', $query, 'GET');
    }

    /**
     * @param $years
     * @param $date
     * @param $invoiceOption
     * @param bool $purchasePrivacy
     * @return array
     */
    public function renew($years, $date, $invoiceOption, $purchasePrivacy = false)
    {
        $resp = $this->orderId();

        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        $query = [
            'order-id'         => $orderId,
            'years'            => $years,
            'exp-date'         => strtotime($date),
            'invoice-option'   => $invoiceOption,
            'purchase-privacy' => $purchasePrivacy
        ];
        return $this->request('domains/renew.json', $query, 'POST');
    }

    /**
     * @param $customerId
     * @return array
     */
    public function customerDefaultNameServers($customerId)
    {
        $query = [
            'customer-id' => $customerId
        ];
        return $this->request('domains/customer-default-ns.json', $query, 'GET');
    }

    /**
     * @return array
     */
    public function isDomainPremium()
    {
        $query = [
            'domain-name' => $this->domain
        ];
        return $this->request('domains/premium-check.json', $query, 'GET');
    }

    /**
     * @param $cns
     * @param $ip
     * @return array
     */
    public function addChildNs($cns, $ip)
    {
        $resp = $this->orderId();

        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        $query = [
            'order-id' => $orderId,
            'cns' => $cns,
            'ip' => $ip
        ];
        return $this->request('domains/add-cns.json', $query, 'POST', true);
    }

    public function test($url, $query)
    {
        $resp = $this->orderId();

        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        return $this->request($url, $query, 'POST', true);

    }

    public function modifyChildNs($oldCns, $newCns)
    {
        $resp = $this->orderId();
        if (!$resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        $query = [
            'order-id' => $orderId,
            'old-cns' => $oldCns,
            'new-cns' => $newCns
        ];
        return $this->request('domains/add-cns.json', $query, 'POST');
    }
}
