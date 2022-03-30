# Booooza\DatatransClient\V1AliasesApi

All URIs are relative to https://api.sandbox.datatrans.com.

Method | HTTP request | Description
------------- | ------------- | -------------
[**aliasesConvert()**](V1AliasesApi.md#aliasesConvert) | **POST** /v1/aliases | Convert alias
[**aliasesDelete()**](V1AliasesApi.md#aliasesDelete) | **DELETE** /v1/aliases/{alias} | Delete alias
[**aliasesInfo()**](V1AliasesApi.md#aliasesInfo) | **GET** /v1/aliases/{alias} | Get alias info


## `aliasesConvert()`

```php
aliasesConvert($alias_convert_request): \Booooza\DatatransClient\Model\AliasConvertResponse
```

Convert alias

Convert a legacy (numeric or masked) alias to the most recent alias format. Currently, only credit card aliases can be converted.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1AliasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$alias_convert_request = {"legacyAlias":"424242SKMPRI4242"}; // \Booooza\DatatransClient\Model\AliasConvertRequest

try {
    $result = $apiInstance->aliasesConvert($alias_convert_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1AliasesApi->aliasesConvert: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **alias_convert_request** | [**\Booooza\DatatransClient\Model\AliasConvertRequest**](../Model/AliasConvertRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\AliasConvertResponse**](../Model/AliasConvertResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `aliasesDelete()`

```php
aliasesDelete($alias)
```

Delete alias

Delete an alias with immediate effect. The alias will no longer be recognized if used later with any API call.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1AliasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$alias = AAABeCBPbiHssdexyrAAAYkaznYWAPYt; // string

try {
    $apiInstance->aliasesDelete($alias);
} catch (Exception $e) {
    echo 'Exception when calling V1AliasesApi->aliasesDelete: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **alias** | **string**|  |

### Return type

void (empty response body)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `aliasesInfo()`

```php
aliasesInfo($alias): \Booooza\DatatransClient\Model\AliasInfoResponse
```

Get alias info

Get alias info.

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1AliasesApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$alias = AAABeCBPbiHssdexyrAAAYkaznYWAPYt; // string

try {
    $result = $apiInstance->aliasesInfo($alias);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1AliasesApi->aliasesInfo: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **alias** | **string**|  |

### Return type

[**\Booooza\DatatransClient\Model\AliasInfoResponse**](../Model/AliasInfoResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: Not defined
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
