# Booooza\DatatransClient\V1TransactionsApi

All URIs are relative to https://api.sandbox.datatrans.com.

Method | HTTP request | Description
------------- | ------------- | -------------
[**authorize()**](V1TransactionsApi.md#authorize) | **POST** /v1/transactions/authorize | Authorize a transaction
[**authorizeSplit()**](V1TransactionsApi.md#authorizeSplit) | **POST** /v1/transactions/{transactionId}/authorize | Authorize an authenticated transaction
[**cancel()**](V1TransactionsApi.md#cancel) | **POST** /v1/transactions/{transactionId}/cancel | Cancel a transaction
[**credit()**](V1TransactionsApi.md#credit) | **POST** /v1/transactions/{transactionId}/credit | Refund a transaction
[**increase()**](V1TransactionsApi.md#increase) | **POST** /v1/transactions/{transactionId}/increase | Increase the authorized amount of a transaction
[**init()**](V1TransactionsApi.md#init) | **POST** /v1/transactions | Initialize a transaction
[**screen()**](V1TransactionsApi.md#screen) | **POST** /v1/transactions/screen | Screen the customer details
[**secureFieldsInit()**](V1TransactionsApi.md#secureFieldsInit) | **POST** /v1/transactions/secureFields | Initialize a Secure Fields transaction
[**secureFieldsUpdate()**](V1TransactionsApi.md#secureFieldsUpdate) | **PATCH** /v1/transactions/secureFields/{transactionId} | Update the amount of a Secure Fields transaction
[**settle()**](V1TransactionsApi.md#settle) | **POST** /v1/transactions/{transactionId}/settle | Settle a transaction
[**status()**](V1TransactionsApi.md#status) | **GET** /v1/transactions/{transactionId} | Checking the status of a transaction
[**validate()**](V1TransactionsApi.md#validate) | **POST** /v1/transactions/validate | Validate an existing alias


## `authorize()`

```php
authorize($authorize_request): \Booooza\DatatransClient\Model\AuthorizeResponse
```

Authorize a transaction

To create a transaction without user interaction, send all required parameters to our authorize endpoint. This is the API call for merchant-initiated transactions with an existing `alias`. Depending on the payment method, additional parameters will be required. Refer to the payment method specific objects (for example `PAP`) to see which parameters are required additionally send. For credit cards, the `card` object has to be used

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$authorize_request = {"currency":"CHF","refno":"p0xYmoPhJ","card":{"alias":"AAABcH0Bq92s3kgAESIAAbGj5NIsAHWC","expiryMonth":"06","expiryYear":"25"},"amount":1000}; // \Booooza\DatatransClient\Model\AuthorizeRequest

try {
    $result = $apiInstance->authorize($authorize_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->authorize: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **authorize_request** | [**\Booooza\DatatransClient\Model\AuthorizeRequest**](../Model/AuthorizeRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\AuthorizeResponse**](../Model/AuthorizeResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `authorizeSplit()`

```php
authorizeSplit($transaction_id, $authorize_split_request): \Booooza\DatatransClient\Model\AuthorizeSplitResponse
```

Authorize an authenticated transaction

Use this API endpoint to fully authorize an already authenticated transaction. This call is required for any transaction done with our Secure Fields or if during the initialization of a transaction the parameter `option.authenticationOnly` was set to `true`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$authorize_split_request = {"amount":1000,"refno":"xTscpWgQU"}; // \Booooza\DatatransClient\Model\AuthorizeSplitRequest

try {
    $result = $apiInstance->authorizeSplit($transaction_id, $authorize_split_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->authorizeSplit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **authorize_split_request** | [**\Booooza\DatatransClient\Model\AuthorizeSplitRequest**](../Model/AuthorizeSplitRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\AuthorizeSplitResponse**](../Model/AuthorizeSplitResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `cancel()`

```php
cancel($transaction_id, $cancel_request)
```

Cancel a transaction

Cancel requests can be used to release a blocked amount from an authorization. The transaction must either be in status `authorized` or `settled`. The `transactionId` is needed to cancel an authorization

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$cancel_request = {"refno":"nsxLnpOHm"}; // \Booooza\DatatransClient\Model\CancelRequest | Cancel a transaction

try {
    $apiInstance->cancel($transaction_id, $cancel_request);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->cancel: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **cancel_request** | [**\Booooza\DatatransClient\Model\CancelRequest**](../Model/CancelRequest.md)| Cancel a transaction |

### Return type

void (empty response body)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `credit()`

```php
credit($transaction_id, $credit_request): \Booooza\DatatransClient\Model\CreditResponse
```

Refund a transaction

Refund requests can be used to credit a transaction which is in status `settled`. The previously settled amount must not be exceeded.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$credit_request = {"amount":1000,"currency":"CHF","refno":"E59I8RNLY"}; // \Booooza\DatatransClient\Model\CreditRequest | Credit a transaction

try {
    $result = $apiInstance->credit($transaction_id, $credit_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->credit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **credit_request** | [**\Booooza\DatatransClient\Model\CreditRequest**](../Model/CreditRequest.md)| Credit a transaction |

### Return type

[**\Booooza\DatatransClient\Model\CreditResponse**](../Model/CreditResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `increase()`

```php
increase($transaction_id, $increase_request): \Booooza\DatatransClient\Model\IncreaseResponse
```

Increase the authorized amount of a transaction

Use this API to increase the authorized amount for a transaction. The transaction must be in status `authorized`. The `transactionId` is needed to increase the amount for an authorization. Only credit cards support increase of the authorized amount.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$increase_request = {"amount":1000,"currency":"GBP","refno":"Ruke3lqZC"}; // \Booooza\DatatransClient\Model\IncreaseRequest | Increase authorization amount

try {
    $result = $apiInstance->increase($transaction_id, $increase_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->increase: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **increase_request** | [**\Booooza\DatatransClient\Model\IncreaseRequest**](../Model/IncreaseRequest.md)| Increase authorization amount |

### Return type

[**\Booooza\DatatransClient\Model\IncreaseResponse**](../Model/IncreaseResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `init()`

```php
init($init_request): \Booooza\DatatransClient\Model\InitResponse
```

Initialize a transaction

Securely send all the needed parameters to the transaction initialization API. The result of this API call is a `HTTP 201` status code with a `transactionId` in the response body and the `Location` header set. This call is required to proceed with our Redirect and Lightbox integration

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$init_request = {"currency":"CHF","refno":"atk6nsI34","amount":1337,"redirect":{"successUrl":"https://pay.sandbox.datatrans.com/upp/merchant/successPage.jsp","cancelUrl":"https://pay.sandbox.datatrans.com/upp/merchant/cancelPage.jsp","errorUrl":"https://pay.sandbox.datatrans.com/upp/merchant/errorPage.jsp"}}; // \Booooza\DatatransClient\Model\InitRequest

try {
    $result = $apiInstance->init($init_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->init: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **init_request** | [**\Booooza\DatatransClient\Model\InitRequest**](../Model/InitRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\InitResponse**](../Model/InitResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `screen()`

```php
screen($screen_request): \Booooza\DatatransClient\Model\AuthorizeResponse
```

Screen the customer details

Check the customer's credit score before sending an actual authorization request. No amount will be blocked on the customers account. Currently, only invoicing method `INT` support screening.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$screen_request = {"amount":2000,"currency":"CHF","refno":"IcsVyjhup","customer":{"id":"10067822","title":"Herr","firstName":"Markus","lastName":"Uberland","street":"Amstelstrasse","street2":"11","city":"Allschwil","country":"CH","zipCode":"4123","phone":"0448111111","cellPhone":"0448222222","email":"test@gmail.com","gender":"male","birthDate":"1986-05-14","language":"DE","type":"P","ipAddress":"213.55.184.229"},"INT":{"deliveryMethod":"POST","deviceFingerprintId":"635822543440473727","paperInvoice":false,"repaymentType":4,"riskOwner":"IJ","verifiedDocument1Type":"swiss-travel-pass","verifiedDocument1Number":"5000200001","verifiedDocument1Issuer":"SBB"}}; // \Booooza\DatatransClient\Model\ScreenRequest | Screen request

try {
    $result = $apiInstance->screen($screen_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->screen: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **screen_request** | [**\Booooza\DatatransClient\Model\ScreenRequest**](../Model/ScreenRequest.md)| Screen request |

### Return type

[**\Booooza\DatatransClient\Model\AuthorizeResponse**](../Model/AuthorizeResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `secureFieldsInit()`

```php
secureFieldsInit($secure_fields_init_request): \Booooza\DatatransClient\Model\SecureFieldsInitResponse
```

Initialize a Secure Fields transaction

Proceed with the steps below to process [Secure Fields payment transactions](https://docs.datatrans.ch/docs/integrations-secure-fields):  - Call the /v1/transactions/secureFields endpoint to retrieve a `transactionId`. The success result of this API call is a `HTTP 201` status code with a `transactionId` in the response body. - Initialize the `SecureFields` JavaScript library with the returned `transactionId`: ```js var secureFields = new SecureFields(); secureFields.init(     transactionId, {         cardNumber: \"cardNumberPlaceholder\",         cvv: \"cvvPlaceholder\",     }); ``` - Handle the `success` event of the `secureFields.submit()` call. Example `success` event data: ```json {     \"event\":\"success\",     \"data\": {         \"transactionId\":\"{transactionId}\",         \"cardInfo\":{\"brand\":\"MASTERCARD\",\"type\":\"credit\",\"usage\":\"consumer\",\"country\":\"CH\",\"issuer\":\"DATATRANS\"},         \"redirect\":\"https://pay.sandbox.datatrans.com/upp/v1/3D2/{transactionId}\"     } } ``` - If 3D authentication is required, the `redirect` property will indicate the URL that the browser needs to be redirected to. - Use the [Authorize an authenticated transaction](#operation/authorize-split) endpoint to authorize the Secure Fields transaction. This is required to finalize the authorization process with Secure Fields. - Use the `transactionId` to check the [status](#operation/status) and to [settle](#operation/settle), [cancel](#operation/cancel) or [credit (refund)](#operation/refund) an transaction.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$secure_fields_init_request = {"amount":100,"currency":"CHF","returnUrl":"http://example.org/return"}; // \Booooza\DatatransClient\Model\SecureFieldsInitRequest

try {
    $result = $apiInstance->secureFieldsInit($secure_fields_init_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->secureFieldsInit: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **secure_fields_init_request** | [**\Booooza\DatatransClient\Model\SecureFieldsInitRequest**](../Model/SecureFieldsInitRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\SecureFieldsInitResponse**](../Model/SecureFieldsInitResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `secureFieldsUpdate()`

```php
secureFieldsUpdate($transaction_id, $secure_fields_update_request)
```

Update the amount of a Secure Fields transaction

Use this API to update the amount of a Secure Fields transaction. This action is only allowed before the 3D process. At least one property must be updated.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$secure_fields_update_request = {"amount":1338}; // \Booooza\DatatransClient\Model\SecureFieldsUpdateRequest

try {
    $apiInstance->secureFieldsUpdate($transaction_id, $secure_fields_update_request);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->secureFieldsUpdate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **secure_fields_update_request** | [**\Booooza\DatatransClient\Model\SecureFieldsUpdateRequest**](../Model/SecureFieldsUpdateRequest.md)|  |

### Return type

void (empty response body)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `settle()`

```php
settle($transaction_id, $settle_request)
```

Settle a transaction

The Settlement request is often also referred to as “Capture” or “Clearing”. It can be used for the settlement of previously authorized transactions. Only after settling a transaction the funds will be credited to your bank accountThe `transactionId` is needed to settle an authorization. This API call is not needed if `autoSettle` was set to `true` when [initializing a transaction](#operation/init).

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int
$settle_request = {"amount":1000,"currency":"CHF","refno":"t5TjQUMxb"}; // \Booooza\DatatransClient\Model\SettleRequest

try {
    $apiInstance->settle($transaction_id, $settle_request);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->settle: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |
 **settle_request** | [**\Booooza\DatatransClient\Model\SettleRequest**](../Model/SettleRequest.md)|  |

### Return type

void (empty response body)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `status()`

```php
status($transaction_id): \Booooza\DatatransClient\Model\StatusResponse
```

Checking the status of a transaction

The API endpoint status can be used to check the status of any transaction, see its history, and retrieve the card information.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$transaction_id = 56; // int

try {
    $result = $apiInstance->status($transaction_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->status: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **transaction_id** | **int**|  |

### Return type

[**\Booooza\DatatransClient\Model\StatusResponse**](../Model/StatusResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `validate()`

```php
validate($validate_request): \Booooza\DatatransClient\Model\AuthorizeResponse
```

Validate an existing alias

An existing alias can be validated at any time with the transaction validate API. No amount will be blocked on the customers account. Only credit cards (including Apple Pay and Google Pay), `PFC`, `KLN` and `PAP` support validation of an existing alias.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1TransactionsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$validate_request = {"refno":"T7tTxHKra","currency":"CHF","card":{"alias":"AAABcH0Bq92s3kgAESIAAbGj5NIsAHWC","expiryMonth":"06","expiryYear":"25"}}; // \Booooza\DatatransClient\Model\ValidateRequest | Validate an alias

try {
    $result = $apiInstance->validate($validate_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1TransactionsApi->validate: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **validate_request** | [**\Booooza\DatatransClient\Model\ValidateRequest**](../Model/ValidateRequest.md)| Validate an alias |

### Return type

[**\Booooza\DatatransClient\Model\AuthorizeResponse**](../Model/AuthorizeResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
