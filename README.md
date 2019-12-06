# RocaPay
This client library provides an easy way to communicate with the [RocaPay API](https://api.rocapay.com/).
# Installation
## Composer
To get the latest version of the client through Composer, run the command:
```bash
composer require rocapayofficial/rocapay-php
```
## Direct Download
You can also download the client as a [ZIP File](https://github.com/rocapayofficial/rocapay-php/archive/master.zip) and extract it into your project.
#### Example of using the client without an autoloader
```php
<?php
require_once 'YOUR_PATH/rocapay-php/Rocapay.php';
$rocapay = new \Rocapay\Rocapay($apiKey);
```
All the files in the client are [PSR-4](https://www.php-fig.org/psr/psr-4/) compliant and can be used with your own autoloader.
# Configuration
First you have to sign up for a [RocaPay](https://rocapay.com/auth/register) account. 

Then you have to create a widget and use the API key provided under the implementation tab.
# Usage
#### Example of creating a payment
```php
 <?php
 $rocapay = new \Rocapay\Rocapay($apiKey);
 $amount = '12.00';
 $fiatCurrency = 'ALL';
 $callbackUrl = 'https://yoursite.com/callbackurl'; // Optional Parameter	
 $description = 'Order #0291092'; // Optional Parameter
 $payment = $rocapay->createPayment($amount, $fiatCurrency, $callbackUrl, $description);
```
## Available methods

 - `getCryptoCurrencies()`: Gets a list of supported cryptocurrencies.
 - `createPayment($amount, $fiatCurrency, $callbackUrl, $description)`: Creates a payment.
 - `checkPayment($paymentId)`: Fetches a payment.

