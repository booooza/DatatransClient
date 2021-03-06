<?php
/**
 * BuyerMetaData
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
 * BuyerMetaData Class Doc Comment
 *
 * @category Class
 * @description Buyer Meta Data
 * @package  Booooza\DatatransClient
 * @author   OpenAPI Generator team
 * @link     https://openapi-generator.tech
 * @implements \ArrayAccess<TKey, TValue>
 * @template TKey int|null
 * @template TValue mixed|null
 */
class BuyerMetaData implements ModelInterface, ArrayAccess, \JsonSerializable
{
    public const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $openAPIModelName = 'BuyerMetaData';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $openAPITypes = [
        'version' => 'string',
        'is_first_time_customer' => 'bool',
        'number_of_past_purchases' => 'int',
        'number_of_disputed_purchases' => 'int',
        'has_open_dispute' => 'bool',
        'risk_score' => 'string',
        'user_agent' => 'string',
        'language' => 'string',
        'recipient_email_matches' => 'bool',
        'buyer_is_a_traveler' => 'bool'
    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      * @phpstan-var array<string, string|null>
      * @psalm-var array<string, string|null>
      */
    protected static $openAPIFormats = [
        'version' => null,
        'is_first_time_customer' => null,
        'number_of_past_purchases' => 'int32',
        'number_of_disputed_purchases' => 'int32',
        'has_open_dispute' => null,
        'risk_score' => null,
        'user_agent' => null,
        'language' => null,
        'recipient_email_matches' => null,
        'buyer_is_a_traveler' => null
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
        'version' => 'version',
        'is_first_time_customer' => 'isFirstTimeCustomer',
        'number_of_past_purchases' => 'numberOfPastPurchases',
        'number_of_disputed_purchases' => 'numberOfDisputedPurchases',
        'has_open_dispute' => 'hasOpenDispute',
        'risk_score' => 'riskScore',
        'user_agent' => 'userAgent',
        'language' => 'language',
        'recipient_email_matches' => 'recipientEmailMatches',
        'buyer_is_a_traveler' => 'buyerIsATraveler'
    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'version' => 'setVersion',
        'is_first_time_customer' => 'setIsFirstTimeCustomer',
        'number_of_past_purchases' => 'setNumberOfPastPurchases',
        'number_of_disputed_purchases' => 'setNumberOfDisputedPurchases',
        'has_open_dispute' => 'setHasOpenDispute',
        'risk_score' => 'setRiskScore',
        'user_agent' => 'setUserAgent',
        'language' => 'setLanguage',
        'recipient_email_matches' => 'setRecipientEmailMatches',
        'buyer_is_a_traveler' => 'setBuyerIsATraveler'
    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'version' => 'getVersion',
        'is_first_time_customer' => 'getIsFirstTimeCustomer',
        'number_of_past_purchases' => 'getNumberOfPastPurchases',
        'number_of_disputed_purchases' => 'getNumberOfDisputedPurchases',
        'has_open_dispute' => 'getHasOpenDispute',
        'risk_score' => 'getRiskScore',
        'user_agent' => 'getUserAgent',
        'language' => 'getLanguage',
        'recipient_email_matches' => 'getRecipientEmailMatches',
        'buyer_is_a_traveler' => 'getBuyerIsATraveler'
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
        $this->container['version'] = $data['version'] ?? null;
        $this->container['is_first_time_customer'] = $data['is_first_time_customer'] ?? null;
        $this->container['number_of_past_purchases'] = $data['number_of_past_purchases'] ?? null;
        $this->container['number_of_disputed_purchases'] = $data['number_of_disputed_purchases'] ?? null;
        $this->container['has_open_dispute'] = $data['has_open_dispute'] ?? null;
        $this->container['risk_score'] = $data['risk_score'] ?? null;
        $this->container['user_agent'] = $data['user_agent'] ?? null;
        $this->container['language'] = $data['language'] ?? null;
        $this->container['recipient_email_matches'] = $data['recipient_email_matches'] ?? null;
        $this->container['buyer_is_a_traveler'] = $data['buyer_is_a_traveler'] ?? null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

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
     * Gets version
     *
     * @return string|null
     */
    public function getVersion()
    {
        return $this->container['version'];
    }

    /**
     * Sets version
     *
     * @param string|null $version The version of BuyerMetaData field (used for tracking schema changes to the field).
     *
     * @return self
     */
    public function setVersion($version)
    {
        $this->container['version'] = $version;

        return $this;
    }

    /**
     * Gets is_first_time_customer
     *
     * @return bool|null
     */
    public function getIsFirstTimeCustomer()
    {
        return $this->container['is_first_time_customer'];
    }

    /**
     * Sets is_first_time_customer
     *
     * @param bool|null $is_first_time_customer True if the buyer is purchasing from the merchant for the first time. Else false.
     *
     * @return self
     */
    public function setIsFirstTimeCustomer($is_first_time_customer)
    {
        $this->container['is_first_time_customer'] = $is_first_time_customer;

        return $this;
    }

    /**
     * Gets number_of_past_purchases
     *
     * @return int|null
     */
    public function getNumberOfPastPurchases()
    {
        return $this->container['number_of_past_purchases'];
    }

    /**
     * Sets number_of_past_purchases
     *
     * @param int|null $number_of_past_purchases The number of purchases the buyer has made from the merchant in the past.
     *
     * @return self
     */
    public function setNumberOfPastPurchases($number_of_past_purchases)
    {
        $this->container['number_of_past_purchases'] = $number_of_past_purchases;

        return $this;
    }

    /**
     * Gets number_of_disputed_purchases
     *
     * @return int|null
     */
    public function getNumberOfDisputedPurchases()
    {
        return $this->container['number_of_disputed_purchases'];
    }

    /**
     * Sets number_of_disputed_purchases
     *
     * @param int|null $number_of_disputed_purchases The number of purchases that has been disputed by the buyer when making purchases from the merchant.
     *
     * @return self
     */
    public function setNumberOfDisputedPurchases($number_of_disputed_purchases)
    {
        $this->container['number_of_disputed_purchases'] = $number_of_disputed_purchases;

        return $this;
    }

    /**
     * Gets has_open_dispute
     *
     * @return bool|null
     */
    public function getHasOpenDispute()
    {
        return $this->container['has_open_dispute'];
    }

    /**
     * Sets has_open_dispute
     *
     * @param bool|null $has_open_dispute True if the buyer has an ongoing dispute regarding a past purchase.
     *
     * @return self
     */
    public function setHasOpenDispute($has_open_dispute)
    {
        $this->container['has_open_dispute'] = $has_open_dispute;

        return $this;
    }

    /**
     * Gets risk_score
     *
     * @return string|null
     */
    public function getRiskScore()
    {
        return $this->container['risk_score'];
    }

    /**
     * Sets risk_score
     *
     * @param string|null $risk_score The risk score which the merchant computes for a buyer. The value must be a decimal in the range between 0 (lowest risk) and 1 (highest risk).
     *
     * @return self
     */
    public function setRiskScore($risk_score)
    {
        $this->container['risk_score'] = $risk_score;

        return $this;
    }

    /**
     * Gets user_agent
     *
     * @return string|null
     */
    public function getUserAgent()
    {
        return $this->container['user_agent'];
    }

    /**
     * Sets user_agent
     *
     * @param string|null $user_agent The user agent of the browser used by the buyer to make the purchase on merchant site. Example: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36.
     *
     * @return self
     */
    public function setUserAgent($user_agent)
    {
        $this->container['user_agent'] = $user_agent;

        return $this;
    }

    /**
     * Gets language
     *
     * @return string|null
     */
    public function getLanguage()
    {
        return $this->container['language'];
    }

    /**
     * Sets language
     *
     * @param string|null $language Language in which the buyer is viewing the site at the time of placing the order in 'language-LOCALE' format example: en-US. Use ISO 639-1:2002 code for the language part (en) and ISO 3166-1 alpha-2 for the LOCALE part (US).
     *
     * @return self
     */
    public function setLanguage($language)
    {
        $this->container['language'] = $language;

        return $this;
    }

    /**
     * Gets recipient_email_matches
     *
     * @return bool|null
     */
    public function getRecipientEmailMatches()
    {
        return $this->container['recipient_email_matches'];
    }

    /**
     * Sets recipient_email_matches
     *
     * @param bool|null $recipient_email_matches True, if the recipient email is exactly the same as the one on the amazon account used for payment, false otherwise.
     *
     * @return self
     */
    public function setRecipientEmailMatches($recipient_email_matches)
    {
        $this->container['recipient_email_matches'] = $recipient_email_matches;

        return $this;
    }

    /**
     * Gets buyer_is_a_traveler
     *
     * @return bool|null
     */
    public function getBuyerIsATraveler()
    {
        return $this->container['buyer_is_a_traveler'];
    }

    /**
     * Sets buyer_is_a_traveler
     *
     * @param bool|null $buyer_is_a_traveler True, if the account holder of the amazon account is actually one of the travelers, false otherwise.
     *
     * @return self
     */
    public function setBuyerIsATraveler($buyer_is_a_traveler)
    {
        $this->container['buyer_is_a_traveler'] = $buyer_is_a_traveler;

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


