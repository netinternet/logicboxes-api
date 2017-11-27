<?php

namespace Netinternet\Logicboxes\Api;

class Customer extends Base
{
    /**
     * @param array $customerData
     *
     * @return array
     */
    public function create(array $customerData)
    {
        return $this->request('customers/signup.json', $customerData, 'POST', false);
    }

    /**
     * Update customer details.
     *
     * @param       $customerId
     * @param array $customerData
     *
     * @return array
     */
    public function update($customerId, array $customerData)
    {
        if (filter_var($customerId, FILTER_VALIDATE_EMAIL)) {
            return [
               'status' => false,
               'message' => 'You must provide customer id not an id.',
               'response' => null
           ];
        }

        $customerData['customer-id'] = $customerId;

        return $this->request('customers/modify.json', $customerData, 'POST', false);
    }

    /**
     * Get customer by email or customer id
     *
     * @param $customer
     *
     * @return array
     */
    public function get($customer)
    {
        if (filter_var($customer, FILTER_VALIDATE_EMAIL)) {
            return $this->request('customers/details.json', [
                'username' => $customer
            ]);
        }

        return $this->request('customers/details-by-id.json', [
            'customer-id' => (int) $customer
        ]);
    }

    /**
     * Change customers password
     *
     * @param $customer
     * @param $password
     *
     * @throws \Exception
     * @return array
     */
    public function password($customer, $password)
    {
        if (filter_var($customer, FILTER_VALIDATE_EMAIL)) {
            $customer = $this->customerId($customer);
        }

        return $this->request('customers/change-password.json', [
            'customer-id' => $customer,
            'new-passwd' => $password
        ]);
    }

    /**
     * Deletes a customer.
     *
     * @param $customer
     *
     * @throws \Exception
     * @return array
     */
    public function delete($customer)
    {
        if (filter_var($customer, FILTER_VALIDATE_EMAIL)) {
            $customer = $this->customerId($customer);
        }

        return $this->request('customers/delete.json', [
            'customer-id' => $customer
        ]);
    }

    /**
     * Get customers id
     *
     * @param $customer
     *
     * @throws \Exception
     * @return bool
     */
    private function customerId($customer)
    {
        $response = $this->get($customer);

        if ($response['status'] == true) {
            return $response['response']->customerid;
        }

        throw new \Exception('Customer id cannot found');
    }
}
