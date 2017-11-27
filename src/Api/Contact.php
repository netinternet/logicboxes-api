<?php

namespace Netinternet\Logicboxes\Api;

class Contact extends Base
{
    /**
     *
     * @param $query
     * @return array
     */
    public function add($query)
    {
        return $this->request('contacts/add.json', $query, 'POST');
    }

    /**
     * @param $contactId
     * @return array
     */
    public function getDetail($contactId)
    {
        $query = [
            'contact-id' => $contactId,
        ];
        return $this->request('contacts/details.json', $query, 'GET');
    }

    /**
     * @param $customerId
     * @param array $type
     * @return array
     */
    public function getContactWithCustomerId($customerId, $type = ['Contact'])
    {
        $query = [
            'customer-id' => $customerId,
            'type' => $type
        ];
        return $this->request('contacts/default.json', $query, 'POST', true);
    }

    /**
     * @param $query
     * @return array
     */
    public function modify($query)
    {
        return $this->request('contacts/modify.json', $query, 'POST');
    }

    /**
     * @param $customerId
     * @param array $type
     * @return array
     */
    public function getDefaultDetails($customerId, $type = ['Contact'])
    {
        $query = [
            'customer-id' => $customerId,
            'type' => $type
        ];

        return $this->request('contacts/default.json', $query, 'POST', true);
    }

    /**
     * @param $query
     * @return array
     */
    public function setDefaultContact($query)
    {
        return $this->request('contacts/modDefault.json', $query, 'POST', true);
    }

    /**
     * @param $contactId
     * @return array
     */
    public function delete($contactId)
    {
        $query = [
            'contact-id' => $contactId
        ];
        return $this->request('contacts/modDefault.json', $query, 'POST');
    }
}
