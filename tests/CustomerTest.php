<?php

namespace Netinternet\Logicboxes\Test;

use Faker\Factory;

/**
 * @coversNothing
 */
class CustomerTest extends TestCase
{
    use BaseTrait;

    public $faker;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /** @test */
    public function logicboxes_create_customer()
    {
        $response = logicboxes()->customer()->create($this->customerDetails());
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function logicboxes_get_customer_details_by_username_and_customerid()
    {
        $customer = $this->createCustomer();

        $response = logicboxes()->customer()->get($customer['username']);

        $this->assertTrue($response['status']);
        $this->assertEquals($response['response']->useremail, $customer['username']);

        $response = logicboxes()->customer()->get($customer['customer-id']);
        $this->assertTrue($response['status']);
        $this->assertEquals($response['response']->useremail, $customer['username']);
    }

    /** @test */
    public function logicboxes_package_can_change_customers_password()
    {
        $customer = $this->createCustomer();
        $response = logicboxes()->customer()->password($customer['username'], 'myNew8Char13');
        $this->assertTrue($response['status']);
        $this->assertTrue($response['response']);
    }

    /** @test */
    public function logicboxes_package_can_delete_a_customer()
    {
        $customer = $this->createCustomer();
        $response = logicboxes()->customer()->delete($customer['customer-id']);
        $this->assertTrue($response['status']);
        $this->assertTrue($response['response']);
    }

    /** @test */
    public function logicboxes_change_customer()
    {
        $customer = $this->createCustomer();
        $contact = $this->createContact(['customer-id' => $customer['customer-id']]);
        $customer = $customer['customer-id'];
        $contact = $contact['contact-id'];

        $domain = strtolower(str_random(8));
        logicboxes()->domain("{$domain}.com")
            ->register($this->prepareDomainData($customer, $contact));
        // create 2. Customer
        $customer2 = $this->createCustomer();
        $customer2Id = $customer2['customer-id'];

        $response = logicboxes()->customer()->moveProduct("{$domain}.com", $customer, $customer2Id, $contact);

        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }
}
