# OverlayTerminationCondition

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**type** | [**\Tado\Api\Model\OverlayTerminationConditionType**](OverlayTerminationConditionType.md) |  | 
**projected_expiry** | [**\DateTime**](\DateTime.md) | [ISO8601 datetime](https://en.wikipedia.org/wiki/ISO_8601). E.g. &#x60;2015-09-28T15:03:20Z&#x60; with second precision. Only relevant when receiving an overlay, ignored when overlay is sent to the server. Indicates the expected time of termination for this overlay, if no app user moves. &#x60;null&#x60; means that the overlay never expires (by itself, unless manully removed). | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

