<?php
/**
 * AuthorizeRequest
 *
 * PHP version 7.3
 *
 * @category Class
 * @package  Booooza\DatatransClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 */

/**
 * Datatrans API Reference
 *
 * Welcome to the Datatrans API reference. This document is meant to be used in combination with https://docs.datatrans.ch. All the parameters used in the curl and web samples are described here. Reach out to support@datatrans.ch if something is missing or unclear.  Last updated: 16.03.22 - 09:13 UTC  # Payment Process The following steps describe how transactions are processed with Datatrans. We separate payments in three categories: Customer-initiated payments, merchant-initiated payments and after the payment.  ## Customer Initiated Payments We have three integrations available: [Redirect](https://docs.datatrans.ch/docs/redirect-lightbox), [Lightbox](https://docs.datatrans.ch/docs/redirect-lightbox) and [Secure Fields](https://docs.datatrans.ch/docs/secure-fields).  ### Redirect & Lightbox - Send the required parameters to initialize a `transactionId` to the [init](#operation/init) endpoint. - Let the customer proceed with the payment by redirecting them to the correct link - or showing them your payment form.   - Redirect: Redirect the browser to the following URL structure     ```     https://pay.sandbox.datatrans.com/v1/start/transactionId     ```   - Lightbox: Load the JavaScript library and initialize the payment form:     ```js     <script src=\"https://pay.sandbox.datatrans.com/upp/payment/js/datatrans-2.0.0.js\">     ```     ```js     payButton.onclick = function() {       Datatrans.startPayment({         transactionId:  \"transactionId\"       });     };     ``` - Your customer proceeds with entering their payment information and finally hits the pay or continue button. - For card payments, we check the payment information with your acquirers. The acquirers check the payment information with the issuing parties. The customer proceeds with 3D Secure whenever required. - Once the transaction is completed, we return all relevant information to you (check our [Webhook section](#section/Webhook) for more details). The browser will be redirected to the success, cancel or error URL with our `datatransTrxId` in the response.  ### Secure Fields - Send the required parameters to initialize a transactionId to our [secureFieldsInit](#operation/secureFieldsInit) endpoint. - Load the Secure Fields JavaScript libarary and initialize Secure Fields:   ```js   <script src=\"https://pay.sandbox.datatrans.com/upp/payment/js/secure-fields-2.0.0.js\">   ```   ```js   var secureFields = new SecureFields();   secureFields.init(     {{transactionId}}, {         cardNumber: \"cardNumberPlaceholder\",         cvv: \"cvvPlaceholder\",     });   ``` - Handle the success event of the secureFields.submit() call. - If 3D authentication is required for a specific transaction, the `redirect` property inside the `data` object will indicate the URL that the customer needs to be redirected to. - Use the [Authorize an authenticated transaction](#operation/authorize-split)endpoint to fully authorize the Secure Fields transaction. This is required to finalize the authorization process with Secure Fields.  ## Merchant Initiated Payments Once you have processed a customer-initiated payment or registration you can call our API to process recurring payments. Check our [authorize](#operation/authorize) endpoint to see how to create a recurring payment or our [validate](#operation/validate) endpoint to validate your customers??? saved payment details.  ## After the payment Use the `transactionId` to check the [status](#operation/status) and to [settle](#operation/settle), [cancel](#operation/cancel) or [refund](#operation/credit) a transaction.  # Idempotency  To retry identical requests with the same effect without accidentally performing the same operation more than needed, you can add the header `Idempotency-Key` to your requests. This is useful when API calls are disrupted or you did not receive a response. In other words, retrying identical requests with our idempotency key will not have any side effects. We will return the same response for any identical request that includes the same idempotency key.  If your request failed to reach our servers, no idempotent result is saved because no API endpoint processed your request. In such cases, you can simply retry your operation safely. Idempotency keys remain stored for 60 minutes. After 60 minutes have passed, sending the same request together with the previous idempotency key will create a new operation.  Please note that the idempotency key has to be unique for each request and has to be defined by yourself. We recommend assigning a random value as your idempotency key and using UUID v4. Idempotency is only available for `POST` requests.  Idempotency was implemented according to the [\"The Idempotency HTTP Header Field\" Internet-Draft](https://tools.ietf.org/id/draft-idempotency-header-01.html)  |Scenario|Condition|Expectation| |:---|:---|:---| |First time request|Idempotency key has not been seen during the past 60 minutes.|The request is processed normally.| |Repeated request|The request was retried after the first time request completed.| The response from the first time request will be returned.| |Repeated request|The request was retried before the first time request completed.| 409 Conflict. It is recommended that clients time their retries using an exponential backoff algorithm.| |Repeated request|The request body is different than the one from the first time request.| 422 Unprocessable Entity.|  Example: ```sh curl -i 'https://api.sandbox.datatrans.com/v1/transactions' \\     -H 'Authorization: Basic MTEwMDAwNzI4MzpobDJST1NScUN2am5EVlJL' \\     -H 'Content-Type: application/json; charset=UTF-8' \\     -H 'Idempotency-Key: e75d621b-0e56-4b71-b889-1acec3e9d870' \\     -d '{     \"refno\" : \"58b389331dad\",     \"amount\" : 1000,     \"currency\" : \"CHF\",     \"paymentMethods\" : [ \"VIS\", \"ECA\", \"PAP\" ],     \"option\" : {        \"createAlias\" : true     } }' ```  # Authentication Authentication to the APIs is performed with HTTP basic authentication. Your `merchantId` acts as the username. To get the password, login to the <a href='https://admin.sandbox.datatrans.com/' target='_blank'>dashboard</a> and navigate to the security settings under `UPP Administration > Security`.  Create a base64 encoded value consisting of merchantId and password (most HTTP clients are able to handle the base64 encoding automatically) and submit the Authorization header with your requests. Here???s an example:  ``` base64(merchantId:password) = MTAwMDAxMTAxMTpYMWVXNmkjJA== ```  ``` Authorization: Basic MTAwMDAxMTAxMTpYMWVXNmkjJA== ````  All API requests must be done over HTTPS with TLS >= 1.2.   <!-- ReDoc-Inject: <security-definitions> -->  # Errors Datatrans uses HTTP response codes to indicate if an API call was successful or resulted in a failure. HTTP `2xx` status codes indicate a successful API call whereas HTTP `4xx` status codes indicate client errors or if something with the transaction went wrong - for example a decline. In rare cases HTTP `5xx` status codes are returned. Those indicate errors on Datatrans side.  Here???s the payload of a sample HTTP `400` error, showing that your request has wrong values in it ``` {   \"error\" : {     \"code\" : \"INVALID_PROPERTY\",     \"message\" : \"init.initRequest.currency The given currency does not have the right format\"   } } ```  # Webhook After each authorization Datatrans tries to call the configured Webhook (POST) URL. The Webhook URL can be configured within the <a href='https://admin.sandbox.datatrans.com/' target='_blank'>dashboard</a>. The Webhook payload contains the same information as the response of a [Status API](#operation/status) call.  ## Webhook signing If you want your webhook requests to be signed, setup a HMAC key in your merchant configuration. To get your HMAC key, login to our dashboard and navigate to the Security settings in your merchant configuration to view your server to server security settings. Select the radio button `Important parameters will be digitally signed (HMAC-SHA256) and sent with payment messages`. Datatrans will use this key to sign the webhook payload and will add a `Datatrans-Signature` HTTP request header:  ```sh Datatrans-Signature: t=1559303131511,s0=33819a1220fd8e38fc5bad3f57ef31095fac0deb38c001ba347e694f48ffe2fc ```  On your server, calculate the signature of the webhook payload and finally compare it to `s0`. `timestamp` is the `t` value from the Datatrans-Signature header, `payload` represents all UTF-8 bytes from the body of the payload and finally `key` is the HMAC key you configured within the dashboard. If the value of `sign` is equal to `s0` from the `Datatrans-Signature` header, the webhook payload is valid and was not tampered.  **Java**  ```java // hex bytes of the key byte[] key = Hex.decodeHex(key);  // Create sign with timestamp and payload String algorithm = \"HmacSha256\"; SecretKeySpec macKey = new SecretKeySpec(key, algorithm); Mac mac = Mac.getInstance(algorithm); mac.init(macKey); mac.update(String.valueOf(timestamp).getBytes()); byte[] result = mac.doFinal(payload.getBytes()); String sign = Hex.encodeHexString(result); ```  **Python**  ```python # hex bytes of the key key_hex_bytes = bytes.fromhex(key)  # Create sign with timestamp and payload sign = hmac.new(key_hex_bytes, bytes(str(timestamp) + payload, 'utf-8'), hashlib.sha256) ```  # Release notes <details>   <summary>Details</summary>    ### 2.0.26 - 16.03.2022 * Added the OpenAPI description for the `GET /v1/aliases/{alias}` response.  ### 2.0.25 - 02.03.2022 * New API `/v1/transactions/{transactionId}/increase` to increase the amount for an authorized transaction (credit cards only).  ### 2.0.24 - 15.12.2021 ???? * Added full support for `invoiceOnDelivery` when using `MFX` or `MPX` as payment method. * The Status API now returns the ESR data for `MFX` and `MPX` when `invoiceOnDelivery=true` was used.  ### 2.0.23 - 20.10.2021 * Added support for Klarna `KLN` hotel extended merchant data (EMD)  ### 2.0.22 - 21.07.2021 * Added full support for Swisscom Pay `ESY` * The `marketplace` object now accepts an array of splits.  ### 2.0.21 - 21.05.2021 * Updated idempotency handling. See the details here https://api-reference.datatrans.ch/#section/Idempotency  ### 2.0.20 - 18.05.2021 * In addition to `debit` and `credit` the Status API now also returns `prepaid` in the `card.info.type` property. * paysafecard - Added support for `merchantClientId`   ### 2.0.19 - 03.05.2021 * Fixed `PAP.orderTransactionId` to be a string * Added support for `PAP.fraudSessionId` (PayPal FraudNet)  ### 2.0.18 - 21.04.2021 * Added new `POST /v1/transactions/screen` API to check a customer's credit score before sending an actual authorization request. Currently only `INT` (Byjuno) is supported.  ### 2.0.17 - 20.04.2021 * Added new `GET /v1/aliases` API to receive more information about a particular alias.  ### 2.0.16 - 13.04.2021 * Added support for Migros Bank E-Pay <code>MDP</code>  ### 2.0.15 - 24.03.2021 * Byjuno - renamed `subPaymentMethod` to `subtype` (`subPaymentMethod` still works) * Klarna - Returning the `subtype` (`pay_now`, `pay_later`, `pay_over_time`, `direct_debit`, `direct_bank_transfer`) from the Status API  ### 2.0.14 - 09.03.2021 * Byjuno - Added support for `customData` and `firstRateAmount` * Returning the `transactionId` (if available) for a failed Refund API call.  ### 2.0.13 - 15.02.2021 * The Status and Webhook payloads now include the `language` property * Fixed a bug where `card.3D.transStatusReason` and `card.3D.cardholderInfo` was not returned  ### 2.0.12 - 04.02.2021 * Added support for PayPal transaction context (STC) * Fixed a bug where the transaction status did not switch to `failed` after it timed out * Fixed a bug with `option.rememberMe` not returning the Alias from the Status API  ### 2.0.11 - 01.02.2021 * Returning `card.3D.transStatusReason` (if available) from the Status API  ### 2.0.10 - 18.01.2021 * Returning `card.3D.cardholderInfo` (if available) from the Status API  ### 2.0.9 - 21.12.2020 * Added support for Alipay <code>ALP</code>  ### 2.0.8 - 21.12.2020 * Added full support for Klarna <code>KLN</code> * Added support for swissbilling <code>SWB</code>  </details>
 *
 * The version of the OpenAPI document: 2.0.26
 * Contact: support@datatrans.ch
 * Generated by: https://openapi-generator.tech
 * OpenAPI Generator version: 5.4.0
 */

/**
 * NOTE: This class is auto generated by OpenAPI Generator (https://openapi-generator.tech).
 * https://openapi-generator.tech
 * Do not edit the class manually.
 */

namespace Booooza\DatatransClient\Model;

use \ArrayAccess;
use \Booooza\DatatransClient\ObjectSerializer;

/**
 * AuthorizeRequest Class Doc Comment
 *
 * @category Class
 * @package  Booooza\DatatransClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class AuthorizeRequest implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'AuthorizeRequest';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'currency' => 'string',
        'refno' => 'string',
        'refno2' => 'string',
        'auto_settle' => 'bool',
        'customer' => '\Booooza\DatatransClient\Model\CustomerRequest',
        'billing' => '\Booooza\DatatransClient\Model\BillingAddress',
        'shipping' => '\Booooza\DatatransClient\Model\ShippingAddress',
        'order' => '\Booooza\DatatransClient\Model\OrderRequest',
        'card' => '\Booooza\DatatransClient\Model\CardAuthorizeRequest',
        'bon' => '\Booooza\DatatransClient\Model\BoncardRequest',
        'pap' => '\Booooza\DatatransClient\Model\PayPalAuthorizeRequest',
        'pfc' => '\Booooza\DatatransClient\Model\PfcAuthorizeRequest',
        'rek' => '\Booooza\DatatransClient\Model\RekaRequest',
        'kln' => '\Booooza\DatatransClient\Model\KlarnaAuthorizeRequest',
        'twi' => '\Booooza\DatatransClient\Model\TwintAuthorizeRequest',
        'int' => '\Booooza\DatatransClient\Model\ByjunoAuthorizeRequest',
        'esy' => '\Booooza\DatatransClient\Model\ESY',
        'airline_data' => '\Booooza\DatatransClient\Model\AirlineDataRequest',
        'amount' => 'int',
        'acc' => '\Booooza\DatatransClient\Model\AccardaRequest',
        'pay' => '\Booooza\DatatransClient\Model\GooglePayRequest',
        'apl' => '\Booooza\DatatransClient\Model\ApplePayRequest',
        'marketplace' => '\Booooza\DatatransClient\Model\MarketPlaceAuthorize',
        'swb' => '\Booooza\DatatransClient\Model\SwissBillingAuthorizeRequest'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'currency' => null,
        'refno' => null,
        'refno2' => null,
        'auto_settle' => null,
        'customer' => null,
        'billing' => null,
        'shipping' => null,
        'order' => null,
        'card' => null,
        'bon' => null,
        'pap' => null,
        'pfc' => null,
        'rek' => null,
        'kln' => null,
        'twi' => null,
        'int' => null,
        'esy' => null,
        'airline_data' => null,
        'amount' => 'int64',
        'acc' => null,
        'pay' => null,
        'apl' => null,
        'marketplace' => null,
        'swb' => null
    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPITypes()
    {
        return self::$openAPITypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function openAPIFormats()
    {
        return self::$openAPIFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'currency' => 'currency',
        'refno' => 'refno',
        'refno2' => 'refno2',
        'auto_settle' => 'autoSettle',
        'customer' => 'customer',
        'billing' => 'billing',
        'shipping' => 'shipping',
        'order' => 'order',
        'card' => 'card',
        'bon' => 'BON',
        'pap' => 'PAP',
        'pfc' => 'PFC',
        'rek' => 'REK',
        'kln' => 'KLN',
        'twi' => 'TWI',
        'int' => 'INT',
        'esy' => 'ESY',
        'airline_data' => 'airlineData',
        'amount' => 'amount',
        'acc' => 'ACC',
        'pay' => 'PAY',
        'apl' => 'APL',
        'marketplace' => 'marketplace',
        'swb' => 'SWB'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'currency' => 'setCurrency',
        'refno' => 'setRefno',
        'refno2' => 'setRefno2',
        'auto_settle' => 'setAutoSettle',
        'customer' => 'setCustomer',
        'billing' => 'setBilling',
        'shipping' => 'setShipping',
        'order' => 'setOrder',
        'card' => 'setCard',
        'bon' => 'setBon',
        'pap' => 'setPap',
        'pfc' => 'setPfc',
        'rek' => 'setRek',
        'kln' => 'setKln',
        'twi' => 'setTwi',
        'int' => 'setInt',
        'esy' => 'setEsy',
        'airline_data' => 'setAirlineData',
        'amount' => 'setAmount',
        'acc' => 'setAcc',
        'pay' => 'setPay',
        'apl' => 'setApl',
        'marketplace' => 'setMarketplace',
        'swb' => 'setSwb'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'currency' => 'getCurrency',
        'refno' => 'getRefno',
        'refno2' => 'getRefno2',
        'auto_settle' => 'getAutoSettle',
        'customer' => 'getCustomer',
        'billing' => 'getBilling',
        'shipping' => 'getShipping',
        'order' => 'getOrder',
        'card' => 'getCard',
        'bon' => 'getBon',
        'pap' => 'getPap',
        'pfc' => 'getPfc',
        'rek' => 'getRek',
        'kln' => 'getKln',
        'twi' => 'getTwi',
        'int' => 'getInt',
        'esy' => 'getEsy',
        'airline_data' => 'getAirlineData',
        'amount' => 'getAmount',
        'acc' => 'getAcc',
        'pay' => 'getPay',
        'apl' => 'getApl',
        'marketplace' => 'getMarketplace',
        'swb' => 'getSwb'
    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$openAPIModelName;
    }


    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['currency'] = $data['currency'] ?? null;
        $this->container['refno'] = $data['refno'] ?? null;
        $this->container['refno2'] = $data['refno2'] ?? null;
        $this->container['auto_settle'] = $data['auto_settle'] ?? null;
        $this->container['customer'] = $data['customer'] ?? null;
        $this->container['billing'] = $data['billing'] ?? null;
        $this->container['shipping'] = $data['shipping'] ?? null;
        $this->container['order'] = $data['order'] ?? null;
        $this->container['card'] = $data['card'] ?? null;
        $this->container['bon'] = $data['bon'] ?? null;
        $this->container['pap'] = $data['pap'] ?? null;
        $this->container['pfc'] = $data['pfc'] ?? null;
        $this->container['rek'] = $data['rek'] ?? null;
        $this->container['kln'] = $data['kln'] ?? null;
        $this->container['twi'] = $data['twi'] ?? null;
        $this->container['int'] = $data['int'] ?? null;
        $this->container['esy'] = $data['esy'] ?? null;
        $this->container['airline_data'] = $data['airline_data'] ?? null;
        $this->container['amount'] = $data['amount'] ?? null;
        $this->container['acc'] = $data['acc'] ?? null;
        $this->container['pay'] = $data['pay'] ?? null;
        $this->container['apl'] = $data['apl'] ?? null;
        $this->container['marketplace'] = $data['marketplace'] ?? null;
        $this->container['swb'] = $data['swb'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['currency'] === null) {
            $invalidProperties[] = "'currency' can't be null";
        }
        if ((mb_strlen($this->container['currency']) > 3)) {
            $invalidProperties[] = "invalid value for 'currency', the character length must be smaller than or equal to 3.";
        }

        if ((mb_strlen($this->container['currency']) < 3)) {
            $invalidProperties[] = "invalid value for 'currency', the character length must be bigger than or equal to 3.";
        }

        if ($this->container['refno'] === null) {
            $invalidProperties[] = "'refno' can't be null";
        }
        if ((mb_strlen($this->container['refno']) > 20)) {
            $invalidProperties[] = "invalid value for 'refno', the character length must be smaller than or equal to 20.";
        }

        if ((mb_strlen($this->container['refno']) < 1)) {
            $invalidProperties[] = "invalid value for 'refno', the character length must be bigger than or equal to 1.";
        }

        if (!is_null($this->container['refno2']) && (mb_strlen($this->container['refno2']) > 17)) {
            $invalidProperties[] = "invalid value for 'refno2', the character length must be smaller than or equal to 17.";
        }

        if (!is_null($this->container['refno2']) && (mb_strlen($this->container['refno2']) < 0)) {
            $invalidProperties[] = "invalid value for 'refno2', the character length must be bigger than or equal to 0.";
        }

        if ($this->container['amount'] === null) {
            $invalidProperties[] = "'amount' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->container['currency'];
    }

    /**
     * Sets currency
     *
     * @param string $currency 3 letter <a href='https://en.wikipedia.org/wiki/ISO_4217' target='_blank'>ISO-4217</a> character code. For example `CHF` or `USD`
     *
     * @return self
     */
    public function setCurrency($currency)
    {
        if ((mb_strlen($currency) > 3)) {
            throw new \InvalidArgumentException('invalid length for $currency when calling AuthorizeRequest., must be smaller than or equal to 3.');
        }
        if ((mb_strlen($currency) < 3)) {
            throw new \InvalidArgumentException('invalid length for $currency when calling AuthorizeRequest., must be bigger than or equal to 3.');
        }

        $this->container['currency'] = $currency;

        return $this;
    }

    /**
     * Gets refno
     *
     * @return string
     */
    public function getRefno()
    {
        return $this->container['refno'];
    }

    /**
     * Sets refno
     *
     * @param string $refno The merchant's reference number. It should be unique for each transaction.
     *
     * @return self
     */
    public function setRefno($refno)
    {
        if ((mb_strlen($refno) > 20)) {
            throw new \InvalidArgumentException('invalid length for $refno when calling AuthorizeRequest., must be smaller than or equal to 20.');
        }
        if ((mb_strlen($refno) < 1)) {
            throw new \InvalidArgumentException('invalid length for $refno when calling AuthorizeRequest., must be bigger than or equal to 1.');
        }

        $this->container['refno'] = $refno;

        return $this;
    }

    /**
     * Gets refno2
     *
     * @return string|null
     */
    public function getRefno2()
    {
        return $this->container['refno2'];
    }

    /**
     * Sets refno2
     *
     * @param string|null $refno2 Optional customer's reference number. Supported by some payment methods or acquirers.
     *
     * @return self
     */
    public function setRefno2($refno2)
    {
        if (!is_null($refno2) && (mb_strlen($refno2) > 17)) {
            throw new \InvalidArgumentException('invalid length for $refno2 when calling AuthorizeRequest., must be smaller than or equal to 17.');
        }
        if (!is_null($refno2) && (mb_strlen($refno2) < 0)) {
            throw new \InvalidArgumentException('invalid length for $refno2 when calling AuthorizeRequest., must be bigger than or equal to 0.');
        }

        $this->container['refno2'] = $refno2;

        return $this;
    }

    /**
     * Gets auto_settle
     *
     * @return bool|null
     */
    public function getAutoSettle()
    {
        return $this->container['auto_settle'];
    }

    /**
     * Sets auto_settle
     *
     * @param bool|null $auto_settle Whether to automatically settle the transaction after an authorization or not. If not present with the init request, the settings defined in the dashboard ('Authorisation / Settlement' or 'Direct Debit') will be used. Those settings will only be used for web transactions and not for server to server API calls.
     *
     * @return self
     */
    public function setAutoSettle($auto_settle)
    {
        $this->container['auto_settle'] = $auto_settle;

        return $this;
    }

    /**
     * Gets customer
     *
     * @return \Booooza\DatatransClient\Model\CustomerRequest|null
     */
    public function getCustomer()
    {
        return $this->container['customer'];
    }

    /**
     * Sets customer
     *
     * @param \Booooza\DatatransClient\Model\CustomerRequest|null $customer customer
     *
     * @return self
     */
    public function setCustomer($customer)
    {
        $this->container['customer'] = $customer;

        return $this;
    }

    /**
     * Gets billing
     *
     * @return \Booooza\DatatransClient\Model\BillingAddress|null
     */
    public function getBilling()
    {
        return $this->container['billing'];
    }

    /**
     * Sets billing
     *
     * @param \Booooza\DatatransClient\Model\BillingAddress|null $billing billing
     *
     * @return self
     */
    public function setBilling($billing)
    {
        $this->container['billing'] = $billing;

        return $this;
    }

    /**
     * Gets shipping
     *
     * @return \Booooza\DatatransClient\Model\ShippingAddress|null
     */
    public function getShipping()
    {
        return $this->container['shipping'];
    }

    /**
     * Sets shipping
     *
     * @param \Booooza\DatatransClient\Model\ShippingAddress|null $shipping shipping
     *
     * @return self
     */
    public function setShipping($shipping)
    {
        $this->container['shipping'] = $shipping;

        return $this;
    }

    /**
     * Gets order
     *
     * @return \Booooza\DatatransClient\Model\OrderRequest|null
     */
    public function getOrder()
    {
        return $this->container['order'];
    }

    /**
     * Sets order
     *
     * @param \Booooza\DatatransClient\Model\OrderRequest|null $order order
     *
     * @return self
     */
    public function setOrder($order)
    {
        $this->container['order'] = $order;

        return $this;
    }

    /**
     * Gets card
     *
     * @return \Booooza\DatatransClient\Model\CardAuthorizeRequest|null
     */
    public function getCard()
    {
        return $this->container['card'];
    }

    /**
     * Sets card
     *
     * @param \Booooza\DatatransClient\Model\CardAuthorizeRequest|null $card card
     *
     * @return self
     */
    public function setCard($card)
    {
        $this->container['card'] = $card;

        return $this;
    }

    /**
     * Gets bon
     *
     * @return \Booooza\DatatransClient\Model\BoncardRequest|null
     */
    public function getBon()
    {
        return $this->container['bon'];
    }

    /**
     * Sets bon
     *
     * @param \Booooza\DatatransClient\Model\BoncardRequest|null $bon bon
     *
     * @return self
     */
    public function setBon($bon)
    {
        $this->container['bon'] = $bon;

        return $this;
    }

    /**
     * Gets pap
     *
     * @return \Booooza\DatatransClient\Model\PayPalAuthorizeRequest|null
     */
    public function getPap()
    {
        return $this->container['pap'];
    }

    /**
     * Sets pap
     *
     * @param \Booooza\DatatransClient\Model\PayPalAuthorizeRequest|null $pap pap
     *
     * @return self
     */
    public function setPap($pap)
    {
        $this->container['pap'] = $pap;

        return $this;
    }

    /**
     * Gets pfc
     *
     * @return \Booooza\DatatransClient\Model\PfcAuthorizeRequest|null
     */
    public function getPfc()
    {
        return $this->container['pfc'];
    }

    /**
     * Sets pfc
     *
     * @param \Booooza\DatatransClient\Model\PfcAuthorizeRequest|null $pfc pfc
     *
     * @return self
     */
    public function setPfc($pfc)
    {
        $this->container['pfc'] = $pfc;

        return $this;
    }

    /**
     * Gets rek
     *
     * @return \Booooza\DatatransClient\Model\RekaRequest|null
     */
    public function getRek()
    {
        return $this->container['rek'];
    }

    /**
     * Sets rek
     *
     * @param \Booooza\DatatransClient\Model\RekaRequest|null $rek rek
     *
     * @return self
     */
    public function setRek($rek)
    {
        $this->container['rek'] = $rek;

        return $this;
    }

    /**
     * Gets kln
     *
     * @return \Booooza\DatatransClient\Model\KlarnaAuthorizeRequest|null
     */
    public function getKln()
    {
        return $this->container['kln'];
    }

    /**
     * Sets kln
     *
     * @param \Booooza\DatatransClient\Model\KlarnaAuthorizeRequest|null $kln kln
     *
     * @return self
     */
    public function setKln($kln)
    {
        $this->container['kln'] = $kln;

        return $this;
    }

    /**
     * Gets twi
     *
     * @return \Booooza\DatatransClient\Model\TwintAuthorizeRequest|null
     */
    public function getTwi()
    {
        return $this->container['twi'];
    }

    /**
     * Sets twi
     *
     * @param \Booooza\DatatransClient\Model\TwintAuthorizeRequest|null $twi twi
     *
     * @return self
     */
    public function setTwi($twi)
    {
        $this->container['twi'] = $twi;

        return $this;
    }

    /**
     * Gets int
     *
     * @return \Booooza\DatatransClient\Model\ByjunoAuthorizeRequest|null
     */
    public function getInt()
    {
        return $this->container['int'];
    }

    /**
     * Sets int
     *
     * @param \Booooza\DatatransClient\Model\ByjunoAuthorizeRequest|null $int int
     *
     * @return self
     */
    public function setInt($int)
    {
        $this->container['int'] = $int;

        return $this;
    }

    /**
     * Gets esy
     *
     * @return \Booooza\DatatransClient\Model\ESY|null
     */
    public function getEsy()
    {
        return $this->container['esy'];
    }

    /**
     * Sets esy
     *
     * @param \Booooza\DatatransClient\Model\ESY|null $esy esy
     *
     * @return self
     */
    public function setEsy($esy)
    {
        $this->container['esy'] = $esy;

        return $this;
    }

    /**
     * Gets airline_data
     *
     * @return \Booooza\DatatransClient\Model\AirlineDataRequest|null
     */
    public function getAirlineData()
    {
        return $this->container['airline_data'];
    }

    /**
     * Sets airline_data
     *
     * @param \Booooza\DatatransClient\Model\AirlineDataRequest|null $airline_data airline_data
     *
     * @return self
     */
    public function setAirlineData($airline_data)
    {
        $this->container['airline_data'] = $airline_data;

        return $this;
    }

    /**
     * Gets amount
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->container['amount'];
    }

    /**
     * Sets amount
     *
     * @param int $amount The amount of the transaction in the currency???s smallest unit. For example use 1000 for CHF 10.00.
     *
     * @return self
     */
    public function setAmount($amount)
    {
        $this->container['amount'] = $amount;

        return $this;
    }

    /**
     * Gets acc
     *
     * @return \Booooza\DatatransClient\Model\AccardaRequest|null
     */
    public function getAcc()
    {
        return $this->container['acc'];
    }

    /**
     * Sets acc
     *
     * @param \Booooza\DatatransClient\Model\AccardaRequest|null $acc acc
     *
     * @return self
     */
    public function setAcc($acc)
    {
        $this->container['acc'] = $acc;

        return $this;
    }

    /**
     * Gets pay
     *
     * @return \Booooza\DatatransClient\Model\GooglePayRequest|null
     */
    public function getPay()
    {
        return $this->container['pay'];
    }

    /**
     * Sets pay
     *
     * @param \Booooza\DatatransClient\Model\GooglePayRequest|null $pay pay
     *
     * @return self
     */
    public function setPay($pay)
    {
        $this->container['pay'] = $pay;

        return $this;
    }

    /**
     * Gets apl
     *
     * @return \Booooza\DatatransClient\Model\ApplePayRequest|null
     */
    public function getApl()
    {
        return $this->container['apl'];
    }

    /**
     * Sets apl
     *
     * @param \Booooza\DatatransClient\Model\ApplePayRequest|null $apl apl
     *
     * @return self
     */
    public function setApl($apl)
    {
        $this->container['apl'] = $apl;

        return $this;
    }

    /**
     * Gets marketplace
     *
     * @return \Booooza\DatatransClient\Model\MarketPlaceAuthorize|null
     */
    public function getMarketplace()
    {
        return $this->container['marketplace'];
    }

    /**
     * Sets marketplace
     *
     * @param \Booooza\DatatransClient\Model\MarketPlaceAuthorize|null $marketplace marketplace
     *
     * @return self
     */
    public function setMarketplace($marketplace)
    {
        $this->container['marketplace'] = $marketplace;

        return $this;
    }

    /**
     * Gets swb
     *
     * @return \Booooza\DatatransClient\Model\SwissBillingAuthorizeRequest|null
     */
    public function getSwb()
    {
        return $this->container['swb'];
    }

    /**
     * Sets swb
     *
     * @param \Booooza\DatatransClient\Model\SwissBillingAuthorizeRequest|null $swb swb
     *
     * @return self
     */
    public function setSwb($swb)
    {
        $this->container['swb'] = $swb;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return $this->container[$offset] ?? null;
    }

    /**
     * Sets value based on offset.
     *
     * @param int|null $offset Offset
     * @param mixed    $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @link https://www.php.net/manual/en/jsonserializable.jsonserialize.php
     *
     * @return mixed Returns data which can be serialized by json_encode(), which is a value
     * of any type other than a resource.
     */
    public function jsonSerialize()
    {
       return ObjectSerializer::sanitizeForSerialization($this);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            ObjectSerializer::sanitizeForSerialization($this),
            JSON_PRETTY_PRINT
        );
    }

    /**
     * Gets a header-safe presentation of the object
     *
     * @return string
     */
    public function toHeaderValue()
    {
        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}


