<?php

namespace Netinternet\Logicboxes\Test;

use Faker\Factory;

/**
 * @coversNothing
 */
class DomainTest extends TestCase
{
    use BaseTrait;

    public $faker;
    public $customer;
    public $contact;
    public $domain;

    public function setUp()
    {
        parent::setUp();

        $this->faker = Factory::create();
    }

    /** @test */
    public function package_should_domain_register()
    {
        $customer = $this->createCustomer();
        $contact = $this->createContact(['customer-id' => $customer['customer-id']]);

        $domain = str_random(8);
        $response = logicboxes()->domain("{$domain}.com")
            ->register($this->prepareDomainData($customer['customer-id'], $contact['contact-id']));
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_customer_get_default_ns()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->customerDefaultNameServers($this->customer);
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_get_order_id()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->orderId();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_enable_theft_protection()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->enableTheftProtection();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_disable_theft_protection()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->disableTheftProtection();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_modify_name_servers()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->modifyNameServers(['ns1.ni.net.tr', 'ns2.ni.net.tr']);
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_cancel_the_domain_transfer()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->cancelTransfer();
        $this->assertFalse($response['status']);
        $this->assertEquals($response['message'], 'Invalid action status/action type for this operation');
    }

    /** @test */
    public function package_should_validate_transfer_request()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->validateTransferRequest();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_delete_domain()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->delete();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_validate_is_domain_premium()
    {
        $response = logicboxes()->domain("gotham.town")
            ->isDomainPremium();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_add_child_ns_hostname()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->addChildNs("ns1.{$this->domain}", ['0.0.0.0', '0.0.0.1']);

        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    //    /** @test */
    //    public function package_should_modify_child_ns()
    //    {
    //        $this->createDomain();
    //        logicboxes()->domain($this->domain)
    //            ->addChildNs("ns1.{$this->domain}", ['0.0.0.0', '0.0.0.1']);
    //
    //        $response = logicboxes()->domain($this->domain)
    //            ->modifyChildNs("ns1.{$this->domain}", "ns2.{$this->domain}");
    //        dd($response);
    //        $this->assertTrue($response['status']);
    //        $this->assertEquals($response['message'], 'success');
    //    }

    /** @test */
    public function package_should_get_the_list_lock_applied()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)
            ->getListLockApplied();

        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_suspend_domain_order()
    {
        $this->createDomain();
        $response = logicboxes()->domain($this->domain)->suspend('reason');
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_unsuspend_domain_order()
    {
        $this->createDomain();
        logicboxes()->domain($this->domain)->suspend('reason');

        $response = logicboxes()->domain($this->domain)->unSuspend();
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    /** @test */
    public function package_should_get_suggest_name()
    {
        $response = logicboxes()->domain()->suggestName($this->faker->firstNameMale);
        $this->assertTrue($response['status']);
        $this->assertEquals($response['message'], 'success');
    }

    private function createDomain()
    {
        $this->customer = $this->createCustomer();
        $this->contact = $this->createContact(['customer-id' => $this->customer['customer-id']]);
        $this->customer = $this->customer['customer-id'];
        $this->contact = $this->contact['contact-id'];

        $domain = str_random(8);
        logicboxes()->domain("{$domain}.com")
            ->register($this->prepareDomainData($this->customer, $this->contact));
        $this->domain = "{$domain}.com";
    }
}
