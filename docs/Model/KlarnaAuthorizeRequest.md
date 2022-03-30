# # KlarnaAuthorizeRequest

## Properties

Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**sub_payment_method** | **string** | The Klarna specific payment method used for the transaction. | [optional]
**events** | [**\Booooza\DatatransClient\Model\KlarnaEvent[]**](KlarnaEvent.md) | A list of Klarna events. | [optional]
**subscriptions** | [**\Booooza\DatatransClient\Model\KlarnaSubscription[]**](KlarnaSubscription.md) | A list of Klarna subscriptions. | [optional]
**account_infos** | [**\Booooza\DatatransClient\Model\KlarnaCustomerAccountInfo[]**](KlarnaCustomerAccountInfo.md) | A list of Klarna customer account infos. | [optional]
**history_simple** | [**\Booooza\DatatransClient\Model\KlarnaPaymentHistorySimple[]**](KlarnaPaymentHistorySimple.md) | A list of simple history entries | [optional]
**history_full** | [**\Booooza\DatatransClient\Model\KlarnaPaymentHistoryFull[]**](KlarnaPaymentHistoryFull.md) | A list of full history entries | [optional]
**hotel_reservation_details** | [**\Booooza\DatatransClient\Model\KlarnaHotelReservationDetail[]**](KlarnaHotelReservationDetail.md) | A list of hotel reservation details | [optional]
**alias** | **string** | Alias received for example from a previous transaction if &#x60;option.createAlias: true&#x60; was used. In order to retrieve the alias from a previous transaction, use the [Status API](#operation/status). |

[[Back to Model list]](../../README.md#models) [[Back to API list]](../../README.md#endpoints) [[Back to README]](../../README.md)
