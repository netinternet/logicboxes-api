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
     * @param mixed $stausIndex
     *
     * @return array
     */
    public function check($tlds = ['com'], $suggest = false, $stausIndex = 0)
    {
        $query = [
            'domain-name' => $this->domain,
            'suggest-alternative' => json_encode($suggest),
            'tlds' => $tlds,
        ];

        $result = $this->request('domains/available.json', $query, 'GET', true);

        try {
            $status = $result['response']->{$this->domain.'.'.$tlds[$stausIndex]}->status;
        } catch (\Exception $e) {
            $status = 'unknown';
        }

        $result['domain-status'] = $status;

        return $result;
    }

    /**
     * Get only orderId.
     *
     * @return array
     */
    public function orderId()
    {
        return $this->request('domains/orderid.json', [
            'domain-name' => $this->domain,
        ], 'GET');
    }

    /**
     * @return array
     */
    public function enableTheftProtection()
    {
        return $this->requestWithOrderId('domains/enable-theft-protection.json', [], 'POST');
    }

    /**
     * @return array
     */
    public function disableTheftProtection()
    {
        return $this->requestWithOrderId('domains/disable-theft-protection.json', [], 'POST');
    }

    /**
     * @param array $ns
     *
     * @return array
     */
    public function modifyNameServers(array $ns)
    {
        $query = [
            'ns' => $ns,
        ];

        return $this->requestWithOrderId('domains/modify-ns.json', $query, 'POST', true);
    }

    /**
     * @return array
     */
    public function delete()
    {
        return $this->requestWithOrderId('domains/delete.json', [], 'POST');
    }

    /**
     * @return array
     */
    public function cancelTransfer()
    {
        return $this->requestWithOrderId('domains/cancel-transfer.json', [], 'POST');
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function register($query)
    {
        $query['domain-name'] = $this->domain;

        return $this->request('domains/register.json', $query, 'POST', true);
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function transfer($query)
    {
        $query['domain-name'] = $this->domain;

        return $this->request('domains/transfer.json', $query, 'POST', true);
    }

    /**
     * @param $authCode
     *
     * @return array
     */
    public function authCode($authCode)
    {
        $query = $this->prepareAuthCode($authCode);
        if (! $authCode === $query['auth-code']) {
            return $query;
        }

        return $this->request('domains/transfer/submit-auth-code.json', $query, 'POST');
    }

    /**
     * @param $authCode
     *
     * @return array
     */
    public function modifyAuthCode($authCode)
    {
        $query = $this->prepareAuthCode($authCode);
        if (! $authCode === $query['auth-code']) {
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
            'domain-name' => $this->domain,
        ];

        return $this->request('domains/validate-transfer.json', $query, 'GET');
    }

    /**
     * @param $years
     * @param $date
     * @param $invoiceOption
     * @param bool $purchasePrivacy
     *
     * @return array
     */
    public function renew($years, $date, $invoiceOption, $purchasePrivacy = false)
    {
        $query = [
            'years' => $years,
            'exp-date' => $date,
            'invoice-option' => $invoiceOption,
            'purchase-privacy' => $purchasePrivacy,
        ];

        return $this->requestWithOrderId('domains/renew.json', $query, 'POST');
    }

    /**
     * @param $customerId
     *
     * @return array
     */
    public function customerDefaultNameServers($customerId)
    {
        $query = [
            'customer-id' => $customerId,
        ];

        return $this->request('domains/customer-default-ns.json', $query, 'GET');
    }

    /**
     * @return array
     */
    public function isDomainPremium()
    {
        $query = [
            'domain-name' => $this->domain,
        ];

        return $this->request('domains/premium-check.json', $query, 'GET');
    }

    /**
     * @param $cns
     * @param $ip
     *
     * @return array
     */
    public function addChildNs($cns, $ip)
    {
        $query = [
            'cns' => $cns,
            'ip' => $ip,
        ];

        return $this->requestWithOrderId('domains/add-cns.json', $query, 'POST', true);
    }

    public function requestWithOrderId($url, $query, $method, $string = false)
    {
        $resp = $this->orderId();
        if (! $resp['status']) {
            return $resp;
        }
        $orderId = $resp['response'];
        $query['order-id'] = $orderId;

        return $this->request($url, $query, $method, $string);
    }

    public function modifyChildNsHostName($oldCns, $newCns)
    {
        $query = [
            'old-cns' => $oldCns,
            'new-cns' => $newCns,
        ];

        return $this->requestWithOrderId('domains/modify-cns-name.json', $query, 'POST');
    }

    /**
     * @return array
     */
    public function getListLockApplied()
    {
        return $this->requestWithOrderId('domains/locks.json', [], 'GET');
    }

    /**
     * @param mixed $reason
     *
     * @return array
     */
    public function suspend($reason)
    {
        $query = [
            'reason' => $reason,
        ];

        return $this->requestWithOrderId('orders/suspend.json', $query, 'POST');
    }

    /**
     * @return array
     */
    public function unSuspend()
    {
        return $this->requestWithOrderId('orders/unsuspend.json', [], 'POST');
    }

    public function suggestName($keyword, $tldOnly = false, $exactMatch = false)
    {
        $query = [
            'keyword' => $keyword,
            'exact-match' => $exactMatch,
        ];

        if ($tldOnly) {
            $query['tld-only'] = $tldOnly;
        }

        return $this->request('domains/v5/suggest-names.json', $query, 'GET');
    }

    public function isPremium()
    {
        $query = [
            'domain-name' => $this->domain,
        ];

        return $this->request('domains/premium-check.json', $query, 'GET');
    }

    /**
     * @param $query
     *
     * @return array
     */
    public function modifyContact($query)
    {
        return $this->requestWithOrderId('domains/modify-contact.json', $query, 'POST');
    }

    private function domain($option)
    {
        return $this->request($this->url, [
            'domain-name' => $this->domain,
            'options' => $option,
        ]);
    }

    /**
     * @param $authCode
     *
     * @return array
     */
    private function prepareAuthCode($authCode)
    {
        $resp = $this->orderId();
        if (! $resp['status']) {
            return $resp;
        }

        $orderId = $resp['response'];

        return [
            'order-id' => $orderId,
            'auth-code' => $authCode,
        ];
    }
}
