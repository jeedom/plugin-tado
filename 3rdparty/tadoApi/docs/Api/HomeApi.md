# Tado\Api\HomeApi

All URIs are relative to *https://my.tado.com/api/v2*

Method | HTTP request | Description
------------- | ------------- | -------------
[**activateOpenWindow**](HomeApi.md#activateopenwindow) | **POST** /homes/{home_id}/zones/{zone_id}/state/openWindow/activate | Activate the Open Window State
[**deleteMobileDevice**](HomeApi.md#deletemobiledevice) | **DELETE** /homes/{home_id}/mobileDevices/{device_id} | Delete an mobile device
[**deleteOpenWindow**](HomeApi.md#deleteopenwindow) | **DELETE** /homes/{home_id}/zones/{zone_id}/state/openWindow | Delete an Open Window state
[**deleteZoneOverlay**](HomeApi.md#deletezoneoverlay) | **DELETE** /homes/{home_id}/zones/{zone_id}/overlay | Delete an overlay
[**getDevice**](HomeApi.md#getdevice) | **GET** /devices/{device_id} | Get the details of a device
[**getDeviceTemperatureOffset**](HomeApi.md#getdevicetemperatureoffset) | **GET** /devices/{device_id}/temperatureOffset | Get the temperature offset of a device
[**getHome**](HomeApi.md#gethome) | **GET** /homes/{home_id} | Details about a specific home.
[**getHomeState**](HomeApi.md#gethomestate) | **GET** /homes/{home_id}/state | Home or Away state
[**getHomeWeather**](HomeApi.md#gethomeweather) | **GET** /homes/{home_id}/weather | Weather of a home.
[**getMe**](HomeApi.md#getme) | **GET** /me | Details about the currently logged in user
[**getMobileDevice**](HomeApi.md#getmobiledevice) | **GET** /homes/{home_id}/mobileDevices/{device_id} | Get the mobile device.
[**getMobileDeviceSettings**](HomeApi.md#getmobiledevicesettings) | **GET** /homes/{home_id}/mobileDevices/{device_id}/settings | Get the settings of a specified mobile device.
[**getZoneCapabilities**](HomeApi.md#getzonecapabilities) | **GET** /homes/{home_id}/zones/{zone_id}/capabilities | Capabilities of a zone
[**getZoneDayReport**](HomeApi.md#getzonedayreport) | **GET** /homes/{home_id}/zones/{zone_id}/dayReport | Day report of a zone
[**getZoneDefaultOverlay**](HomeApi.md#getzonedefaultoverlay) | **GET** /homes/{home_id}/zones/{zone_id}/defaultOverlay | Preferences for default overlay. If an overlay is created without a termination condition (e.g through the device UI), the given termination condition is taken for this overlay.
[**getZoneDetails**](HomeApi.md#getzonedetails) | **GET** /homes/{home_id}/zones/{zone_id}/details | Details of a zone.
[**getZoneEarlyStart**](HomeApi.md#getzoneearlystart) | **GET** /homes/{home_id}/zones/{zone_id}/earlyStart | Get early start
[**getZoneMeasuringDevice**](HomeApi.md#getzonemeasuringdevice) | **GET** /homes/{home_id}/zones/{zone_id}/measuringDevice | Measuring device of a zone.
[**getZoneOverlay**](HomeApi.md#getzoneoverlay) | **GET** /homes/{home_id}/zones/{zone_id}/overlay | Overlay of a zone
[**getZoneScheduleActiveTimetable**](HomeApi.md#getzonescheduleactivetimetable) | **GET** /homes/{home_id}/zones/{zone_id}/schedule/activeTimetable | Active Timetable of a zone schedule
[**getZoneScheduleAwayConfiguration**](HomeApi.md#getzonescheduleawayconfiguration) | **GET** /homes/{home_id}/zones/{zone_id}/schedule/awayConfiguration | Away Configuration of a zone schedule
[**getZoneState**](HomeApi.md#getzonestate) | **GET** /homes/{home_id}/zones/{zone_id}/state | State of a zone.
[**listDevices**](HomeApi.md#listdevices) | **GET** /homes/{home_id}/devices | Devices of a home.
[**listInstallations**](HomeApi.md#listinstallations) | **GET** /homes/{home_id}/installations | Installations of a home.
[**listMobileDevices**](HomeApi.md#listmobiledevices) | **GET** /homes/{home_id}/mobileDevices | List all mobile devices associated with this home.
[**listUsers**](HomeApi.md#listusers) | **GET** /homes/{home_id}/users | Users of a home.
[**listZones**](HomeApi.md#listzones) | **GET** /homes/{home_id}/zones | List all zones of a home.
[**updateDeviceTemperatureOffset**](HomeApi.md#updatedevicetemperatureoffset) | **PUT** /devices/{device_id}/temperatureOffset | Set the temperature offset of a device
[**updateHomePresence**](HomeApi.md#updatehomepresence) | **PUT** /homes/{home_id}/presence | Update Home or Away state
[**updateHomePresenceLock**](HomeApi.md#updatehomepresencelock) | **PUT** /homes/{home_id}/presenceLock | Update Home or Away state
[**updateMobileDeviceSettings**](HomeApi.md#updatemobiledevicesettings) | **PUT** /homes/{home_id}/mobileDevices/{device_id}/settings | Set mobile device settings
[**updateZoneDazzle**](HomeApi.md#updatezonedazzle) | **PUT** /homes/{home_id}/zones/{zone_id}/dazzle | Enables or disables the dazzle mode of a zone
[**updateZoneEarlyStart**](HomeApi.md#updatezoneearlystart) | **PUT** /homes/{home_id}/zones/{zone_id}/earlyStart | Set zone early start
[**updateZoneOpenWindowDetection**](HomeApi.md#updatezoneopenwindowdetection) | **PUT** /homes/{home_id}/zones/{zone_id}/openWindowDetection | Set a new setting for Open Window Detection of a zone
[**updateZoneOverlay**](HomeApi.md#updatezoneoverlay) | **PUT** /homes/{home_id}/zones/{zone_id}/overlay | Set a new overlay
[**updateZoneScheduleActiveTimetable**](HomeApi.md#updatezonescheduleactivetimetable) | **PUT** /homes/{home_id}/zones/{zone_id}/schedule/activeTimetable | Set a new active Timetable of a zone schedule
[**updateZoneScheduleAwayConfiguration**](HomeApi.md#updatezonescheduleawayconfiguration) | **PUT** /homes/{home_id}/zones/{zone_id}/schedule/awayConfiguration | Set a new Away Configuration of a zone schedule

# **activateOpenWindow**
> activateOpenWindow($home_id, $zone_id)

Activate the Open Window State

This will activate the Open Window state of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $apiInstance->activateOpenWindow($home_id, $zone_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->activateOpenWindow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteMobileDevice**
> deleteMobileDevice($home_id, $device_id)

Delete an mobile device

This will delete the mobile device of a home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$device_id = 789; // int | The ID of a mobile device.

try {
    $apiInstance->deleteMobileDevice($home_id, $device_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->deleteMobileDevice: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **device_id** | **int**| The ID of a mobile device. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteOpenWindow**
> deleteOpenWindow($home_id, $zone_id)

Delete an Open Window state

This will delete the open window state for the specified zone of a home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $apiInstance->deleteOpenWindow($home_id, $zone_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->deleteOpenWindow: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **deleteZoneOverlay**
> deleteZoneOverlay($home_id, $zone_id)

Delete an overlay

This will delete the overlay for the specified zone of a home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $apiInstance->deleteZoneOverlay($home_id, $zone_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->deleteZoneOverlay: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getDevice**
> object getDevice($device_id)

Get the details of a device

This will get the detailled information on the specified device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->getDevice($device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getDevice: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getDeviceTemperatureOffset**
> object getDeviceTemperatureOffset($device_id)

Get the temperature offset of a device

This will get the temperature offset applied on the measurment of the device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->getDeviceTemperatureOffset($device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getDeviceTemperatureOffset: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getHome**
> object getHome($home_id)

Details about a specific home.

This will return the details of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->getHome($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getHome: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getHomeState**
> object getHomeState($home_id)

Home or Away state

This will return the Home or Away state of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->getHomeState($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getHomeState: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getHomeWeather**
> object getHomeWeather($home_id)

Weather of a home.

This will return the weather forecast of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->getHomeWeather($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getHomeWeather: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getMe**
> object getMe()

Details about the currently logged in user

This will return details about the currently logged in user.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);

try {
    $result = $apiInstance->getMe();
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getMe: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters
This endpoint does not need any parameter.

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getMobileDevice**
> object getMobileDevice($home_id, $device_id)

Get the mobile device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->getMobileDevice($home_id, $device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getMobileDevice: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getMobileDeviceSettings**
> object getMobileDeviceSettings($home_id, $device_id)

Get the settings of a specified mobile device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->getMobileDeviceSettings($home_id, $device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getMobileDeviceSettings: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneCapabilities**
> object getZoneCapabilities($home_id, $zone_id)

Capabilities of a zone

This will return the capabilities of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneCapabilities($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneCapabilities: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneDayReport**
> object getZoneDayReport($home_id, $zone_id, $date)

Day report of a zone

This will return the day report of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.
$date = new \DateTime("2013-10-20"); // \DateTime | The date of the report.

try {
    $result = $apiInstance->getZoneDayReport($home_id, $zone_id, $date);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneDayReport: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |
 **date** | **\DateTime**| The date of the report. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneDefaultOverlay**
> object getZoneDefaultOverlay($home_id, $zone_id)

Preferences for default overlay. If an overlay is created without a termination condition (e.g through the device UI), the given termination condition is taken for this overlay.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneDefaultOverlay($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneDefaultOverlay: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneDetails**
> object getZoneDetails($home_id, $zone_id)

Details of a zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneDetails($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneDetails: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneEarlyStart**
> object getZoneEarlyStart($home_id, $zone_id)

Get early start

This will return xxxxx

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneEarlyStart($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneEarlyStart: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneMeasuringDevice**
> object getZoneMeasuringDevice($home_id, $zone_id)

Measuring device of a zone.

This will return the current device used to measure the temperature of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneMeasuringDevice($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneMeasuringDevice: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneOverlay**
> object getZoneOverlay($home_id, $zone_id)

Overlay of a zone

This will return the current overlay of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneOverlay($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneOverlay: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneScheduleActiveTimetable**
> object getZoneScheduleActiveTimetable($home_id, $zone_id)

Active Timetable of a zone schedule

This will return the active timetable of the schedule of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneScheduleActiveTimetable($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneScheduleActiveTimetable: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneScheduleAwayConfiguration**
> object getZoneScheduleAwayConfiguration($home_id, $zone_id)

Away Configuration of a zone schedule

This will return the Away Configuration of the schedule of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneScheduleAwayConfiguration($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneScheduleAwayConfiguration: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **getZoneState**
> object getZoneState($home_id, $zone_id)

State of a zone.

This will return the current state of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->getZoneState($home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->getZoneState: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listDevices**
> object listDevices($home_id)

Devices of a home.

This will return the list of all devices unes in the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->listDevices($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->listDevices: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listInstallations**
> object listInstallations($home_id)

Installations of a home.

This will return the list of all installations in the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->listInstallations($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->listInstallations: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listMobileDevices**
> object listMobileDevices($home_id)

List all mobile devices associated with this home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->listMobileDevices($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->listMobileDevices: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listUsers**
> object listUsers($home_id)

Users of a home.

This will return the list of all users of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->listUsers($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->listUsers: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **listZones**
> object listZones($home_id)

List all zones of a home.

This will return a list of zones that are associated with a home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$home_id = 789; // int | The ID of a home.

try {
    $result = $apiInstance->listZones($home_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->listZones: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **home_id** | **int**| The ID of a home. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: Not defined
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateDeviceTemperatureOffset**
> object updateDeviceTemperatureOffset($body, $device_id)

Set the temperature offset of a device

This will set the temperature offset to be applied on the measurment of the device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | The new Temperature offset.
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->updateDeviceTemperatureOffset($body, $device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateDeviceTemperatureOffset: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| The new Temperature offset. |
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateHomePresence**
> updateHomePresence($body, $home_id)

Update Home or Away state

This will set the Home or Away state of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | Home or Away presence state.
$home_id = 789; // int | The ID of a home.

try {
    $apiInstance->updateHomePresence($body, $home_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateHomePresence: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| Home or Away presence state. |
 **home_id** | **int**| The ID of a home. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateHomePresenceLock**
> updateHomePresenceLock($body, $home_id)

Update Home or Away state

This will set the Home or Away state of the specified home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | Home or Away presence state.
$home_id = 789; // int | The ID of a home.

try {
    $apiInstance->updateHomePresenceLock($body, $home_id);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateHomePresenceLock: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| Home or Away presence state. |
 **home_id** | **int**| The ID of a home. |

### Return type

void (empty response body)

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateMobileDeviceSettings**
> object updateMobileDeviceSettings($body, $home_id, $device_id)

Set mobile device settings

This will set the settings for the specified mobile device.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Tado\Api\Model\MobileDeviceSettings(); // \Tado\Api\Model\MobileDeviceSettings | Settings of the mobile device.
$home_id = 789; // int | The ID of a home.
$device_id = 789; // int | The ID of a mobile device.

try {
    $result = $apiInstance->updateMobileDeviceSettings($body, $home_id, $device_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateMobileDeviceSettings: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Tado\Api\Model\MobileDeviceSettings**](../Model/MobileDeviceSettings.md)| Settings of the mobile device. |
 **home_id** | **int**| The ID of a home. |
 **device_id** | **int**| The ID of a mobile device. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneDazzle**
> object updateZoneDazzle($body, $home_id, $zone_id)

Enables or disables the dazzle mode of a zone

Enables or disables the dazzle mode that shows an animation on the measuring device when the temperature is set manually.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | Dazzle mode enabled or disabled.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneDazzle($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneDazzle: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| Dazzle mode enabled or disabled. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneEarlyStart**
> object updateZoneEarlyStart($body, $home_id, $zone_id)

Set zone early start

This will set the early start capability of a zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Tado\Api\Model\EarlyStart(); // \Tado\Api\Model\EarlyStart | Enable or disable early start.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneEarlyStart($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneEarlyStart: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Tado\Api\Model\EarlyStart**](../Model/EarlyStart.md)| Enable or disable early start. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneOpenWindowDetection**
> object updateZoneOpenWindowDetection($body, $home_id, $zone_id)

Set a new setting for Open Window Detection of a zone

This will set a new setting for Open Window Detection of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | The new Open Window Detection settings.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneOpenWindowDetection($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneOpenWindowDetection: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| The new Open Window Detection settings. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneOverlay**
> object updateZoneOverlay($body, $home_id, $zone_id)

Set a new overlay

This will set the overlay for the specified zone of a home.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \Tado\Api\Model\Overlay(); // \Tado\Api\Model\Overlay | The new overlay settings.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneOverlay($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneOverlay: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**\Tado\Api\Model\Overlay**](../Model/Overlay.md)| The new overlay settings. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneScheduleActiveTimetable**
> object updateZoneScheduleActiveTimetable($body, $home_id, $zone_id)

Set a new active Timetable of a zone schedule

This will set a new active timetable of the schedule of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | The new timetable.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneScheduleActiveTimetable($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneScheduleActiveTimetable: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| The new timetable. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

# **updateZoneScheduleAwayConfiguration**
> object updateZoneScheduleAwayConfiguration($body, $home_id, $zone_id)

Set a new Away Configuration of a zone schedule

This will set a new Away Configuration of the schedule of the specified zone.

### Example
```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

// Configure OAuth2 access token for authorization: oauth
$config = Tado\Api\Configuration::getDefaultConfiguration()->setAccessToken('YOUR_ACCESS_TOKEN');

$apiInstance = new Tado\Api\Client\HomeApi(
    // If you want use custom http client, pass your client which implements `GuzzleHttp\ClientInterface`.
    // This is optional, `GuzzleHttp\Client` will be used as default.
    new GuzzleHttp\Client(),
    $config
);
$body = new \stdClass; // object | The new Away Configuration.
$home_id = 789; // int | The ID of a home.
$zone_id = 789; // int | The ID of a zone.

try {
    $result = $apiInstance->updateZoneScheduleAwayConfiguration($body, $home_id, $zone_id);
    print_r($result);
} catch (Exception $e) {
    echo 'Exception when calling HomeApi->updateZoneScheduleAwayConfiguration: ', $e->getMessage(), PHP_EOL;
}
?>
```

### Parameters

Name | Type | Description  | Notes
------------- | ------------- | ------------- | -------------
 **body** | [**object**](../Model/object.md)| The new Away Configuration. |
 **home_id** | **int**| The ID of a home. |
 **zone_id** | **int**| The ID of a zone. |

### Return type

**object**

### Authorization

[oauth](../../README.md#oauth)

### HTTP request headers

 - **Content-Type**: application/json
 - **Accept**: application/json

[[Back to top]](#) [[Back to API list]](../../README.md#documentation-for-api-endpoints) [[Back to Model list]](../../README.md#documentation-for-models) [[Back to README]](../../README.md)

