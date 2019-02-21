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

    public function addFunds($id, $amount, $description, $transactionType = 'receipt', $transactionKey = false, $updateTotal = true)
    {
        return $this->request('billing/add-reseller-fund.json', [
            'reseller-id' => $id,
            'amount' => $amount,
            'description' => $description,
            'transaction-type' => $transactionType,
            'transaction-key' => $transactionKey ?? md5(uniqid($id.time(), true)),
            'update-total-receipt' => $updateTotal,
        ], 'POST', false);
    }

    public function getBalance($id)
    {
        return $this->request('billing/reseller-balance.json', [
            'reseller-id' => $id,
        ], 'GET', false);
    }

    public function getPricing($id)
    {
        return $this->request('products/reseller-price.json', [
            'reseller-id' => $id,
        ], 'GET', false, true);
    }

    public function getCustomerPricing($id)
    {
        return $this->request('products/customer-price.json', [], 'GET', false, true);
    }
}
