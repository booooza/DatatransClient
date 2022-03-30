# # AuthorizeRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**currency** | **string** | 3 letter &lt;a href&#x3D;&#39;https://en.wikipedia.org/wiki/ISO_4217&#39; target&#x3D;&#39;_blank&#39;&gt;ISO-4217&lt;/a&gt; character code. For example &#x60;CHF&#x60; or &#x60;USD&#x60; |
**refno** | **string** | The merchant&#39;s reference number. It should be unique for each transaction. |
**refno2** | **string** | Optional customer&#39;s reference number. Supported by some payment methods or acquirers. | [optional]
**auto_settle** | **bool** | Whether to automatically settle the transaction after an authorization or not. If not present with the init request, the settings defined in the dashboard (&#39;Authorisation / Settlement&#39; or &#39;Direct Debit&#39;) will be used. Those settings will only be used for web transactions and not for server to server API calls. | [optional]
**customer** | [**\Booooza\DatatransClient\Model\CustomerRequest**](CustomerRequest.md) |  | [optional]
**billing** | [**\Booooza\DatatransClient\Model\BillingAddress**](BillingAddress.md) |  | [optional]
**shipping** | [**\Booooza\DatatransClient\Model\ShippingAddress**](ShippingAddress.md) |  | [optional]
**order** | [**\Booooza\DatatransClient\Model\OrderRequest**](OrderRequest.md) |  | [optional]
**card** | [**\Booooza\DatatransClient\Model\CardAuthorizeRequest**](CardAuthorizeRequest.md) |  | [optional]
**bon** | [**\Booooza\DatatransClient\Model\BoncardRequest**](BoncardRequest.md) |  | [optional]
**pap** | [**\Booooza\DatatransClient\Model\PayPalAuthorizeRequest**](PayPalAuthorizeRequest.md) |  | [optional]
**pfc** | [**\Booooza\DatatransClient\Model\PfcAuthorizeRequest**](PfcAuthorizeRequest.md) |  | [optional]
**rek** | [**\Booooza\DatatransClient\Model\RekaRequest**](RekaRequest.md) |  | [optional]
**kln** | [**\Booooza\DatatransClient\Model\KlarnaAuthorizeRequest**](KlarnaAuthorizeRequest.md) |  | [optional]
**twi** | [**\Booooza\DatatransClient\Model\TwintAuthorizeRequest**](TwintAuthorizeRequest.md) |  | [optional]
**int** | [**\Booooza\DatatransClient\Model\ByjunoAuthorizeRequest**](ByjunoAuthorizeRequest.md) |  | [optional]
**esy** | [**\Booooza\DatatransClient\Model\ESY**](ESY.md) |  | [optional]
**airline_data** | [**\Booooza\DatatransClient\Model\AirlineDataRequest**](AirlineDataRequest.md) |  | [optional]
**amount** | **int** | The amount of the transaction in the currency’s smallest unit. For example use 1000 for CHF 10.00. |
**acc** | [**\Booooza\DatatransClient\Model\AccardaRequest**](AccardaRequest.md) |  | [optional]
**pay** | [**\Booooza\DatatransClient\Model\GooglePayRequest**](GooglePayRequest.md) |  | [optional]
**apl** | [**\Booooza\DatatransClient\Model\ApplePayRequest**](ApplePayRequest.md) |  | [optional]
**marketplace** | [**\Booooza\DatatransClient\Model\MarketPlaceAuthorize**](MarketPlaceAuthorize.md) |  | [optional]
**swb** | [**\Booooza\DatatransClient\Model\SwissBillingAuthorizeRequest**](SwissBillingAuthorizeRequest.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
