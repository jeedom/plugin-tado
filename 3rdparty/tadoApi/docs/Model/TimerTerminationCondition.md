# TimerTerminationCondition

## Properties
Name | Type | Description | Notes
------------ | ------------- | ------------- | -------------
**duration_in_seconds** | **int** | The number of seconds that the overlay should last/was configured to last. | 
**expiry** | [**\DateTime**](\DateTime.md) | [ISO8601 datetime](https://en.wikipedia.org/wiki/ISO_8601). E.g.: &#x60;2015-09-28T15:03:20Z&#x60; with second precision. Only relevant when receiving an overlay, ignored when overlay is sent to the server. | [optional] 
**remaining_time_in_seconds** | **int** | The number of seconds that are remaining of the timer overlay at the time that the response is assembled by the server. | [optional] 

[[Back to Model list]](../../README.md#documentation-for-models) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to README]](../../README.md)

