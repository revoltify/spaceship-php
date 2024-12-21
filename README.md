# Spaceship PHP Library

A PHP library for interacting with the Spaceship API. This library provides a simple and intuitive way to manage domains, nameservers, contacts, and privacy settings.

## Installation

```bash
composer require revoltify/spaceship-php
```

## Basic Setup

```php
use Spaceship\SpaceshipAPI;

$api = new SpaceshipAPI('api_key', 'api_secret');
```

## Available Methods

### Domain Management

```php
// Get domain information
$api->domain('example.com');
```

### Nameserver Management

```php
// Update nameservers
$params = NameserverParams::make()
    ->setProvider('custom')
    ->setHosts(['ns1.example.com', 'ns2.example.com']);

$api->updateNameserver('example.com', $params);
```

### Authorization Code

```php
// Get domain auth code
$api->authCode('example.com');
```

### Privacy Protection

```php
// Update privacy protection
$params = PrivacyProtectionParams::make()
    ->setPrivacyLevel(PrivacyLevel::PUBLIC); // or PrivacyLevel::HIGH

$api->updatePrivacyProtection('example.com', $params);
```

### Transfer Lock

```php
// Lock domain transfer
$params = TransferLockParams::make()->lock();

// Unlock domain transfer
$params = TransferLockParams::make()->unlock();

$api->updateTransferLock('example.com', $params);
```

### Contact Management

```php
// Create new contact
$params = CreateContactParams::make()
    ->setFirstName('John')
    ->setLastName('Doe')
    ->setEmail('john@doe.com')
    ->setAddress1('Dhaka')
    ->setCity('Dhaka')
    ->setCountryCode('BD')
    ->setPostalCode('1234')
    ->setPhone('+880.1333333333');

$api->createContact($params);

// Get contact information
$api->contact('5HebrteUuESDiv2TyC60yFpJw1oZ');

// Update contact
$params = UpdateContactParams::make()
    ->setRegistrant('1gFvGJ8mwW6t3lb2ovtUCP2YUDD')
    ->setAdmin('1gFvGJ8mwW6t3lb2ovtUCP2YUDD')
    ->setTech('1gFvGJ8mwW6t3lb2ovtUCP2YUDD')
    ->setBilling('1gFvGJ8mwW6t3lb2ovtUCP2YUDD');

$api->updateContact('example.com', $params);
```

## Response Methods

### DomainResponse
- Basic Information: `name()`, `unicodeName()`, `isPremium()`, `hasAutoRenew()`
- Dates: `registrationDate()`, `expirationDate()`, `getDomainAge()`
- Status: `verificationStatus()`, `eppStatuses()`, `isActive()`, `isSuspended()`
- Privacy: `privacyProtectionLevel()`, `hasContactForm()`, `hasHighPrivacy()`
- Nameservers: `nameserverProvider()`, `nameserverHosts()`
- Contacts: `contacts()`, `getContact()`, `getRegistrantId()`
- Expiration: `isExpired()`, `daysUntilExpiration()`

### NameserverResponse
- `success()`, `nameserverProvider()`, `nameserverHosts()`

### AuthCodeResponse
- `success()`, `authCode()`, `expireDate()`

### PrivacyProtectionResponse
- `success()`

### TransferLockResponse
- `success()`

### CreateContactResponse
- `success()`, `contactId()`

### UpdateContactResponse
- `success()`, `verificationStatus()`

### ContactResponse
- Personal: `firstName()`, `lastName()`, `organization()`, `email()`
- Address: `address1()`, `address2()`, `city()`, `state()`, `countryCode()`, `postalCode()`
- Phone: `phone()`, `phoneExt()`, `fax()`, `faxExt()`
- Other: `taxNumber()`

## Error Handling

```php
try {
    $api = new SpaceshipAPI('api_key', 'api_secret');
} catch (SpaceshipException $e) {
    // Handle error
}
```