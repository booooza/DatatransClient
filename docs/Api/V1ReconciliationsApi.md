# Booooza\DatatransClient\V1ReconciliationsApi

All URIs are relative to https://api.sandbox.datatrans.com.

Method | HTTP request | Description
------------- | ------------- | -------------
[**bulkSaleReport()**](V1ReconciliationsApi.md#bulkSaleReport) | **POST** /v1/reconciliations/sales/bulk | Bulk reporting of sales
[**saleReport()**](V1ReconciliationsApi.md#saleReport) | **POST** /v1/reconciliations/sales | Report a sale


## `bulkSaleReport()`

```php
bulkSaleReport($bulk_sale_report_request): \Booooza\DatatransClient\Model\SaleReportResponse
```

Bulk reporting of sales

If you are a merchant using our reconciliation services, you can use this API to confirm multiple sales with a single API call. The matching is based on the `transactionId`. The status of the transaction will change to `compensated`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1ReconciliationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$bulk_sale_report_request = {"sales":[{"date":"2022-03-16T09:14:27.855+00:00","transactionId":"220316101427455749","currency":"CHF","amount":1000,"type":"payment","refno":"pHBTuZFay"},{"date":"2022-03-16T09:14:28.349+00:00","transactionId":"220316101427945759","currency":"CHF","amount":1000,"type":"payment","refno":"xv8XWrFbT"}]}; // \Booooza\DatatransClient\Model\BulkSaleReportRequest

try {
    $result = $apiInstance->bulkSaleReport($bulk_sale_report_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1ReconciliationsApi->bulkSaleReport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **bulk_sale_report_request** | [**\Booooza\DatatransClient\Model\BulkSaleReportRequest**](../Model/BulkSaleReportRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\SaleReportResponse**](../Model/SaleReportResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)

## `saleReport()`

```php
saleReport($sale_report_request): \Booooza\DatatransClient\Model\SaleReportResponse
```

Report a sale

If you are a merchant using our reconciliation services, you can use this API to confirm a sale. The matching is based on the `transactionId`. The status of the transaction will change to `compensated`

### Example

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');


// Configure HTTP basic authorization: Basic
$config = Booooza\DatatransClient\Configuration::getDefaultConfiguration()
              ->setUsername('YOUR_USERNAME')
              ->setPassword('YOUR_PASSWORD');


$apiInstance = new Booooza\DatatransClient\Api\V1ReconciliationsApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$sale_report_request = {"date":"2022-03-16T09:14:27.123+00:00","transactionId":"220316101425695741","currency":"CHF","amount":1000,"type":"payment","refno":"8LkOXfMm7"}; // \Booooza\DatatransClient\Model\SaleReportRequest

try {
    $result = $apiInstance->saleReport($sale_report_request);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling V1ReconciliationsApi->saleReport: ', $e->getMessage(), PHP_EOL;
}
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **sale_report_request** | [**\Booooza\DatatransClient\Model\SaleReportRequest**](../Model/SaleReportRequest.md)|  |

### Return type

[**\Booooza\DatatransClient\Model\SaleReportResponse**](../Model/SaleReportResponse.md)

### Authorization

[Basic](../../README.md#Basic)

### HTTP request headers

- **Content-Type**: `application/json`
- **Accept**: `application/json`

[[Back to top]](#) [[Back to API list]](../../README.md#endpoints)
[[Back to Model list]](../../README.md#models)
[[Back to README]](../../README.md)
