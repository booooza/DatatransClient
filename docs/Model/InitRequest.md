# # InitRequest

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
**card** | [**\Booooza\DatatransClient\Model\CardInitRequest**](CardInitRequest.md) |  | [optional]
**bon** | [**\Booooza\DatatransClient\Model\BoncardRequest**](BoncardRequest.md) |  | [optional]
**pap** | [**\Booooza\DatatransClient\Model\PayPalInitRequest**](PayPalInitRequest.md) |  | [optional]
**pfc** | [**\Booooza\DatatransClient\Model\PfcInitRequest**](PfcInitRequest.md) |  | [optional]
**rek** | [**\Booooza\DatatransClient\Model\RekaRequest**](RekaRequest.md) |  | [optional]
**kln** | [**\Booooza\DatatransClient\Model\KlarnaInitRequest**](KlarnaInitRequest.md) |  | [optional]
**twi** | [**\Booooza\DatatransClient\Model\TwintInitRequest**](TwintInitRequest.md) |  | [optional]
**int** | [**\Booooza\DatatransClient\Model\ByjunoAuthorizeRequest**](ByjunoAuthorizeRequest.md) |  | [optional]
**esy** | [**\Booooza\DatatransClient\Model\ESY**](ESY.md) |  | [optional]
**airline_data** | [**\Booooza\DatatransClient\Model\AirlineDataRequest**](AirlineDataRequest.md) |  | [optional]
**amount** | **int** | The amount of the transaction in the currency’s smallest unit. For example use 1000 for CHF 10.00. Can be omitted for use cases where only a registration should take place (if the payment method supports registrations) | [optional]
**language** | **string** | This parameter specifies the language (language code) in which the payment page should be presented to the cardholder. The &lt;a href&#x3D;&#39;https://en.wikipedia.org/wiki/List_of_ISO_639-1_codes&#39; target&#x3D;&#39;_blank&#39;&gt;ISO-639-1&lt;/a&gt; two letter language codes listed above are supported | [optional]
**payment_methods** | **string[]** | An array of payment method shortnames. For example &#x60;[\&quot;VIS\&quot;, \&quot;PFC\&quot;]&#x60;. If omitted, all available payment methods will be displayed on the payment page. If the Mobile SDKs are used (&#x60;returnMobileToken&#x60;), this array is mandatory. | [optional]
**theme** | [**\Booooza\DatatransClient\Model\Theme**](Theme.md) |  | [optional]
**redirect** | [**\Booooza\DatatransClient\Model\RedirectRequest**](RedirectRequest.md) |  | [optional]
**option** | [**\Booooza\DatatransClient\Model\OptionRequest**](OptionRequest.md) |  | [optional]
**swp** | [**\Booooza\DatatransClient\Model\SwissPassRequest**](SwissPassRequest.md) |  | [optional]
**mfx** | [**\Booooza\DatatransClient\Model\MFXRequest**](MFXRequest.md) |  | [optional]
**mpx** | [**\Booooza\DatatransClient\Model\MPXRequest**](MPXRequest.md) |  | [optional]
**azp** | [**\Booooza\DatatransClient\Model\AmazonPayRequest**](AmazonPayRequest.md) |  | [optional]
**eps** | [**\Booooza\DatatransClient\Model\EpsRequest**](EpsRequest.md) |  | [optional]
**alp** | [**\Booooza\DatatransClient\Model\AlipayRequest**](AlipayRequest.md) |  | [optional]
**wec** | [**\Booooza\DatatransClient\Model\WeChatRequest**](WeChatRequest.md) |  | [optional]
**swb** | [**\Booooza\DatatransClient\Model\SwissBillingRequest**](SwissBillingRequest.md) |  | [optional]
**mdp** | [**\Booooza\DatatransClient\Model\MDPInitRequest**](MDPInitRequest.md) |  | [optional]
**psc** | [**\Booooza\DatatransClient\Model\PaysafecardRequest**](PaysafecardRequest.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
