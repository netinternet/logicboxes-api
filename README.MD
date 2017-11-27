[![Total Downloads](https://poser.pugx.org/netinternet/logicboxes/downloads)](https://packagist.org/packages/netinternet/logicboxes)
[![Latest Stable Version](https://poser.pugx.org/netinternet/logicboxes/v/stable)](https://packagist.org/packages/netinternet/logicboxes)


## Installation
Composer json file:
```json
{
    "require": {
        "netinternet/logicboxes": "^0.0.1"
    }
}
```
After run the install command.
```
$ composer install
```

OR run the following command directly.

```
$ composer require netinternet/logicboxes
```


### Usage
You can access logicboxes instances with facede or helper function.

```php
use Logicboxes;
// With Facade
```
or with helper
```php
public function myMethod()
{
	logicboxes()->
}
```

#### Example

```php
public function getUsersNameServers()
{
	return logicboxes()->domain('mydomain.com')->ns();
}
```

### Avalaible Methods

```php
// get domain nameservers.
logicboxes()->domain('domain-name.tld')->nameservers();
// get domain nameservers short.
logicboxes()->domain('domain-name.tld')->ns();
// get domains all details.
logicboxes()->domain('domain-name.tld')->details();
// get domains status
logicboxes()->domain('domain-name.tld')->status();
// get domains order details
logicboxes()->domain('domain-name.tld')->order();
// get domains dnssec details
logicboxes()->domain('domain-name.tld')->dnssec();
// get domains contact id list.
logicboxes()->domain('domain-name.tld')->contact()->ids();
// get domains registrant contact details
logicboxes()->domain('domain-name.tld')->contact()->registrant();
// get domains admin contact details
logicboxes()->domain('domain-name.tld')->contact()->admin();
// get domains tech contact details
logicboxes()->domain('domain-name.tld')->contact()->tech();
// get domains billing contact details
logicboxes()->domain('domain-name.tld')->contact()->billing();
// check for domain
logicboxes()->domain('hakanersu3')->check(['com','net'])
// first parameter is array of tlds and second parameter domain suggessions as a boolean. Default is false.
//
// get domain order id
logicboxes()->domain('domain-name.tld')->orderId();
// set enable theft protection
logicboxes()->domain('domain-name.tld')->enableTheftProtection();
// set disable theft protection
logicboxes()->domain('domain-name.tld')->disableTheftProtection();
// modify domain nameservers
logicboxes()->domain('domain-name.tld')->modifyNameServers((array) $ns);
// delete this domain
logicboxes()->domain('domain-name.tld')->delete();
// cancel domain transfer process
logicboxes()->domain('domain-name.tld')->cancelTransfer();
// register domain
logicboxes()->domain('domain-name.tld')->register([
    'years' => $years,
    'ns' => (array) $ns,
    'customer-id' => $customerId,
    'reg-contact-id' => $regContactId,
    'admin-contact-id' => $adminContactId,
    'tech-contact-id' => $techContactId,
    'billing-contact-id' => $billingContactId,
    'invoice-option' => 'KeepInvoice',
    'purchase-privacy' => $purchasePrivacy,
    'protect-privacy' => $protectPrivacy,
]);

// Domain transfer
logicboxes()->domain('domain-name.tld')->transfer([
    'auth-code' => $authCode,
    'years' => $years,
    'ns' => (array)$ns,
    'customer-id' => $customerId,
    'reg-contact-id' => $regContactId,
    'admin-contact-id' => $adminContactId,
    'tech-contact-id' => $techContactId,
    'billing-contact-id' => $billingContactId,
    'invoice-option' => $invoiceOption,
    'purchase-privacy' => $purchasePrivacy,
    'protect-privacy' => $protectPrivacy,
]);

// set Auth Code
logicboxes()->domain('domain-name.tld')->authCode('authcode');

// modify Auth Code
logicboxes()->domain('domain-name.tld')->modifyAuthCode('authcode');

// modify Auth Code
logicboxes()->domain('domain-name.tld')->validateTransferRequest();

// renew domain
logicboxes()->domain('domain-name.tld')->renew($years, $date, $invoiceOption, true);
// $purchasePrivacy is default false

// deafult customer nameservers
logicboxes()->domain()->customerDefaultNameServers($customerId);

// Check premium
logicboxes()->domain('domain-name.tld')->isDomainPremium();

// add new child nameserver
logicboxes()->domain('domain-name.tld')->addChildNs('ns1.domain.com', ['0.0.0.0', '0.0.0.1']);

// get lock applied list
logicboxes()->domain('domain-name.tld')->getListLockApplied();

// set suspend
logicboxes()->domain('domain-name.tld')->suspend('reason text');
// set unsuspend
logicboxes()->domain('domain-name.tld')->unSuspend();

```

#### Customer

```php
// Creating a customer
logicboxes()->customer()->create([
	'username' =>  $this->faker->email,
	'passwd' => 'Qs3jiA5fd8mq4',
	'name' => $this->faker->name,
	'company' => $this->faker->company,
	'address-line-1' => $this->faker->streetAddress,
	'city' => $this->faker->city,
	'state' => $this->faker->state,
	'country' => $this->faker->countryCode,
	'zipcode' => $this->faker->postcode,
	'phone-cc' => 90,
	'phone' => 5555555555,
	'lang-pref' => 'en'
]);

// getting a customer by email or id
logicboxes()->customer()->get('app@yourdomain.com')
//or by id
logicboxes()->customer()->get(17939294)
// Changing customers password
logicboxes()->customer()->get('app@yourdomain.com','myNew8CharPassword')
```

## Contributing

1. Fork it ( https://github.com/netinternet/logicboxes-api/ )
2. Create your feature branch (git checkout -b my-new-feature)
3. Commit your changes (git commit -am 'Add some feature')
4. Push to the branch (git push origin my-new-feature)
5. Create a new Pull Request