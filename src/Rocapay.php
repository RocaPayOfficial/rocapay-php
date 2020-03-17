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

        return $this->executeRequest($url);
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

        return $this->executeRequest($url);
    }

    /**
     * Create a payment
     *
     * @param string|float $amount
     * @param string $fiatCurrency Symbol used to specify the fiat currency (ISO 4217)
     * @param string $callbackUrl URL on which JSON notifications will be received about the payment
     * @param string $successUrl Redirect URL after a successful payment in the widget
     * @param string $failUrl Redirect URL after a failed payment in the widget
     * @param string $cancelUrl Redirect URL after clicking the Return to Merchant button in the widget
     * @param string $description Description of the payment
     * @param string $cryptoCurrency Symbol used to specify the crypto currency
     * @return array
     * @throws Exception
     */
    public function createPayment(
        $amount,
        $fiatCurrency,
        $callbackUrl = '',
        $description = '',
        $cryptoCurrency = '',
        $successUrl = '',
        $failUrl = '',
        $cancelUrl = ''
    ) {
        $url = $this->apiBaseUrl . '/payment';

        $params = array(
            'token' => $this->apiAuthToken,
            'amount' => $amount,
            'currency' => $fiatCurrency,
            'cryptoCurrency' => $cryptoCurrency,
            'callbackUrl' => $callbackUrl,
            'description' => $description,
            'successUrl' => $successUrl,
            'failUrl' => $failUrl,
            'cancelUrl' => $cancelUrl
        );

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
            'token' => $this->apiAuthToken,
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
    private function executeRequest($url, $isPost = true, $params = null)
    {
        $curl = curl_init();

        $curlOptions = array(
            CURLOPT_URL => $url,
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
