<?php
namespace Netinternet\Logicboxes\Test;

trait BaseTrait
{
    public function customerDetails()
    {
        return [
            'username' => $this->faker->email,
            'passwd' => 'Qs3jiA5fd8mq4',
            'name' => $this->faker->name,
            'company' => $this->faker->company,
            'address-line-1' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->countryCode,
            'zipcode' => $this->faker->postcode,
            'phone-cc' => 90,
            'phone' => 5053123498,
            'lang-pref' => 'en'
        ];
    }
    public function createCustomer($attributes = [])
    {
        $details = array_merge([
            'username' => $this->faker->email,
            'passwd' => 'Qs3jiA5fd8mq4',
            'name' => $this->faker->name,
            'company' => $this->faker->company,
            'address-line-1' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->countryCode,
            'zipcode' => $this->faker->postcode,
            'phone-cc' => 90,
            'phone' => 5053123498,
            'lang-pref' => 'en'
        ], $attributes);

        $customer = logicboxes()->customer()->create($details);

        $details['customer-id'] = $customer['response'];

        return $details;
    }

    public function createContact($attributes = [])
    {
        $details = array_merge([
            'name' =>  $this->faker->name,
            'company' => $this->faker->company,
            'email' => $this->faker->email,
            'address-line-1' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'country' => 'TR',
            'zipcode' => '20070',
            'phone-cc' => '90',
            'phone' => '5555555555',
            'type' => 'Contact'
        ], $attributes);

        $customer = logicboxes()->contact()->add($details);
        $details['contact-id'] = $customer['response'];
        return $details;
    }

    public function prepareDomainData($customerId, $contactId)
    {
        $details = [
            'years' => 1,
            'ns' => ['dns3.parkpage.foundationapi.com', 'dns4.parkpage.foundationapi.com'],
            'customer-id' => $customerId,
            'reg-contact-id' => $contactId,
            'admin-contact-id' => $contactId,
            'tech-contact-id' => $contactId,
            'billing-contact-id' => $contactId,
            'invoice-option' => 'NoInvoice',
            'purchase-privacy' => true,
            'protect-privacy' => true,
        ];
        return $details;
    }

    public function domain()
    {
        return $this->faker->domainName;
    }
}