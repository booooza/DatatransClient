# # CardAuthorizeRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**alias** | **string** | Alias received for example from a previous transaction if &#x60;option.createAlias: true&#x60; was used. In order to retrieve the alias from a previous transaction, use the [Status API](#operation/status). | [optional]
**expiry_month** | **string** | The expiry month of the credit card alias. | [optional]
**expiry_year** | **string** | The expiry year of the credit card alias | [optional]
**_3_d** | [**\Booooza\DatatransClient\Model\EMVCo3DAuthenticationDataAuthorizeRequest**](EMVCo3DAuthenticationDataAuthorizeRequest.md) |  | [optional]

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
