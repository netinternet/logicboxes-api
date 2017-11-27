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
```

#### Customer

```
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
	'phone' => 5053123498,
	'lang-pref' => 'en'
]);

// getting a customer by email or id
logicboxes()->customer()->get('app@barisesen.com')
//or by id
logicboxes()->customer()->get(17939294)
// Changing customers password 
logicboxes()->customer()->get('hakanersu@gmail.com','myNew8CharPassword')
```
