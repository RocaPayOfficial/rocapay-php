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
 $amount = '12.00'; // Amount of the payment
 $fiatCurrency = 'USD'; // Symbol used to specify the fiat currency (ISO 4217)
 $callbackUrl = 'https://yoursite.com/callback-url'; // URL on which JSON notifications will be received about the payment (Optional if a global one is set from the user dashboard)
 $description = 'Order #0291092'; // Description of the payment (Optional)
 $cryptoCurrency = 'BTC'; // Symbol used to specify the crypto currency (Optional)
 $successUrl = 'https://yoursite.com/success-url'; // Redirect URL after a successful payment in the widget (Optional if a global one is set from the user dashboard)
 $failUrl = 'https://yoursite.com/fail-url'; // Redirect URL after a failed payment in the widget (Optional if a global one is set from the user dashboard)	
 $cancelUrl = 'https://yoursite.com/cancel-url'; // Redirect URL after clicking the Return to Merchant button in the widget (Optional if a global one is set from the user dashboard)	
 $payment = $rocapay->createPayment($amount, $fiatCurrency, $callbackUrl, $description, $successUrl, $failUrl, $cancelUrl);
```
## Available methods

 - `getCryptoCurrencies()`: Gets a list of supported crypto currencies.
 - `getFiatCurrencies()`: Gets a list of supported fiat currencies.
 - `createPayment($amount, $fiatCurrency, $callbackUrl, $description, $successUrl, $failUrl, $cancelUrl)`: Creates a payment.
 - `checkPayment($paymentId)`: Fetches a payment's status.

