<?php

namespace Rocapay;

use Exception;

class Rocapay
{

    /**
     * @var string API Auth Token
     */
    private $apiAuthToken;

    /**
     * @var string API Base URL
     */
    private $apiBaseUrl = 'https://rocapay.com/api';

    /**
     * Rocapay constructor.
     *
     * @param $apiAuthToken
     */
    public function __construct($apiAuthToken)
    {
        $this->apiAuthToken = $apiAuthToken;
    }

    /**
     * Get a list of supported crypto currencies
     *
     * @return array
     * @throws Exception
     */
    public function getCryptoCurrencies()
    {
        $url = $this->apiBaseUrl . '/crypto-currencies';

        $response = $this->executeRequest($url);

        return $response['cryptoCurrencies'];
    }

    /**
     * Get a list of supported fiat currencies
     *
     * @return array
     * @throws Exception
     */
    public function getFiatCurrencies()
    {
        $url = $this->apiBaseUrl . '/fiat-currencies';

        $response = $this->executeRequest($url);

        return $response['currencies'];
    }

    /**
     * Gets a list of supported auto convert currency pairs
     *
     * @return array
     * @throws Exception
     */
    public function getAutoConvertCurrencyPairs()
    {
        $url = $this->apiBaseUrl . '/auto-convert-currency-pairs';

        $response = $this->executeRequest($url);

        return $response['pairs'];
    }

    /**
     * Create a payment
     *
     * @param array $params Array containing the payment's parameters
     *      $params = array(
     *          'amount'            => (string|float) Amount of the payment
     *          'currency'          => (string) Symbol used to specify the fiat currency (ISO 4217),
     *          'cryptoCurrency'    => (string) Symbol used to specify the crypto currency,
     *          'convertToCurrency' => (string) 'EUR', Symbol used to specify the currency to which the crypto currency will be converted to. A list of supported convertable currency pairs can be obtained through the `getAutoConvertCurrencyPairs` method (Optional)
     *          'callbackUrl'       => (string) URL on which JSON notifications will be received about the payment,
     *          'description'       => (string) Description of the payment,
     *          'successUrl'        => (string) Redirect URL after a successful payment in the widget,
     *          'failUrl'           => (string) Redirect URL after a failed payment in the widget,
     *          'cancelUrl'         => (string) Redirect URL after clicking the Return to Merchant button in the widget
     *      )
     * @return array
     * @throws Exception
     */
    public function createPayment($params) {
        $url = $this->apiBaseUrl . '/payment';
        $params = array_merge($params, array('token' => $this->apiAuthToken));

        return $this->executeRequest($url, true, $params);
    }

    /**
     * Check a payment's status
     *
     * @param $paymentId
     * @return array
     * @throws Exception
     */
    public function checkPayment($paymentId)
    {
        $url = $this->apiBaseUrl . '/payment-type';

        $params = array(
            'token'     => $this->apiAuthToken,
            'paymentId' => $paymentId
        );

        return $this->executeRequest($url, true, $params);
    }

    /**
     * Make a CURL Request
     *
     * @param string $url
     * @param bool $isPost
     * @param array|null $params
     * @return array
     * @throws Exception
     */
    private function executeRequest($url, $isPost = true, $params = array())
    {
        $curl = curl_init();

        $curlOptions = array(
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false
        );

        if ($isPost) {
            $curlOptions[CURLOPT_POST] = true;
            $curlOptions[CURLOPT_POSTFIELDS] = http_build_query($params);
        }

        curl_setopt_array($curl, $curlOptions);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $curlError = curl_error($curl);
            curl_close($curl);
            throw new Exception($curlError);
        }

        curl_close($curl);

        return json_decode($response, true);
    }
}
