<?php
/**
 * MobileDeviceSettingsPushNotifications
 *
 * PHP version 5
 *
 * @category Class
 * @package  Tado\Api
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * tado° API
 *
 * No description provided (generated by Swagger Codegen https://github.com/swagger-api/swagger-codegen)
 *
 * OpenAPI spec version: v2
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 * Swagger Codegen version: 3.0.14
 */
/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Tado\Api\Model;

use \ArrayAccess;
use \Tado\Api\ObjectSerializer;

/**
 * MobileDeviceSettingsPushNotifications Class Doc Comment
 *
 * @category Class
 * @package  Tado\Api
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class MobileDeviceSettingsPushNotifications implements ModelInterface, ArrayAccess
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'MobileDeviceSettings_pushNotifications';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'low_battery_reminder' => 'bool',
'away_mode_reminder' => 'bool',
'home_mode_reminder' => 'bool',
'open_window_reminder' => 'bool',
'energy_savings_report_reminder' => 'bool'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'low_battery_reminder' => null,
'away_mode_reminder' => null,
'home_mode_reminder' => null,
'open_window_reminder' => null,
'energy_savings_report_reminder' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes;
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats;
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'low_battery_reminder' => 'lowBatteryReminder',
'away_mode_reminder' => 'awayModeReminder',
'home_mode_reminder' => 'homeModeReminder',
'open_window_reminder' => 'openWindowReminder',
'energy_savings_report_reminder' => 'energySavingsReportReminder'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'low_battery_reminder' => 'setLowBatteryReminder',
'away_mode_reminder' => 'setAwayModeReminder',
'home_mode_reminder' => 'setHomeModeReminder',
'open_window_reminder' => 'setOpenWindowReminder',
'energy_savings_report_reminder' => 'setEnergySavingsReportReminder'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'low_battery_reminder' => 'getLowBatteryReminder',
'away_mode_reminder' => 'getAwayModeReminder',
'home_mode_reminder' => 'getHomeModeReminder',
'open_window_reminder' => 'getOpenWindowReminder',
'energy_savings_report_reminder' => 'getEnergySavingsReportReminder'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return self::$getters;
    }

    /**
     * The original name of the model.
     *
     * @return string
     */
    public function getModelName()
    {
        return self::$swaggerModelName;
    }

    

    /**
     * Associative array for storing property values
     *
     * @var mixed[]
     */
    protected $container = [];

    /**
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->container['low_battery_reminder'] = isset($data['low_battery_reminder']) ? $data['low_battery_reminder'] : null;
        $this->container['away_mode_reminder'] = isset($data['away_mode_reminder']) ? $data['away_mode_reminder'] : null;
        $this->container['home_mode_reminder'] = isset($data['home_mode_reminder']) ? $data['home_mode_reminder'] : null;
        $this->container['open_window_reminder'] = isset($data['open_window_reminder']) ? $data['open_window_reminder'] : null;
        $this->container['energy_savings_report_reminder'] = isset($data['energy_savings_report_reminder']) ? $data['energy_savings_report_reminder'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = [];

        if ($this->container['low_battery_reminder'] === null) {
            $invalidProperties[] = "'low_battery_reminder' can't be null";
        }
        if ($this->container['away_mode_reminder'] === null) {
            $invalidProperties[] = "'away_mode_reminder' can't be null";
        }
        if ($this->container['home_mode_reminder'] === null) {
            $invalidProperties[] = "'home_mode_reminder' can't be null";
        }
        if ($this->container['open_window_reminder'] === null) {
            $invalidProperties[] = "'open_window_reminder' can't be null";
        }
        if ($this->container['energy_savings_report_reminder'] === null) {
            $invalidProperties[] = "'energy_savings_report_reminder' can't be null";
        }
        return $invalidProperties;
    }

    /**
     * Validate all the properties in the model
     * return true if all passed
     *
     * @return bool True if all properties are valid
     */
    public function valid()
    {
        return count($this->listInvalidProperties()) === 0;
    }


    /**
     * Gets low_battery_reminder
     *
     * @return bool
     */
    public function getLowBatteryReminder()
    {
        return $this->container['low_battery_reminder'];
    }

    /**
     * Sets low_battery_reminder
     *
     * @param bool $low_battery_reminder low_battery_reminder
     *
     * @return $this
     */
    public function setLowBatteryReminder($low_battery_reminder)
    {
        $this->container['low_battery_reminder'] = $low_battery_reminder;

        return $this;
    }

    /**
     * Gets away_mode_reminder
     *
     * @return bool
     */
    public function getAwayModeReminder()
    {
        return $this->container['away_mode_reminder'];
    }

    /**
     * Sets away_mode_reminder
     *
     * @param bool $away_mode_reminder away_mode_reminder
     *
     * @return $this
     */
    public function setAwayModeReminder($away_mode_reminder)
    {
        $this->container['away_mode_reminder'] = $away_mode_reminder;

        return $this;
    }

    /**
     * Gets home_mode_reminder
     *
     * @return bool
     */
    public function getHomeModeReminder()
    {
        return $this->container['home_mode_reminder'];
    }

    /**
     * Sets home_mode_reminder
     *
     * @param bool $home_mode_reminder home_mode_reminder
     *
     * @return $this
     */
    public function setHomeModeReminder($home_mode_reminder)
    {
        $this->container['home_mode_reminder'] = $home_mode_reminder;

        return $this;
    }

    /**
     * Gets open_window_reminder
     *
     * @return bool
     */
    public function getOpenWindowReminder()
    {
        return $this->container['open_window_reminder'];
    }

    /**
     * Sets open_window_reminder
     *
     * @param bool $open_window_reminder open_window_reminder
     *
     * @return $this
     */
    public function setOpenWindowReminder($open_window_reminder)
    {
        $this->container['open_window_reminder'] = $open_window_reminder;

        return $this;
    }

    /**
     * Gets energy_savings_report_reminder
     *
     * @return bool
     */
    public function getEnergySavingsReportReminder()
    {
        return $this->container['energy_savings_report_reminder'];
    }

    /**
     * Sets energy_savings_report_reminder
     *
     * @param bool $energy_savings_report_reminder energy_savings_report_reminder
     *
     * @return $this
     */
    public function setEnergySavingsReportReminder($energy_savings_report_reminder)
    {
        $this->container['energy_savings_report_reminder'] = $energy_savings_report_reminder;

        return $this;
    }
    /**
     * Returns true if offset exists. False otherwise.
     *
     * @param integer $offset Offset
     *
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    /**
     * Gets offset.
     *
     * @param integer $offset Offset
     *
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    /**
     * Sets value based on offset.
     *
     * @param integer $offset Offset
     * @param mixed   $value  Value to be set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * Unsets offset.
     *
     * @param integer $offset Offset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }

    /**
     * Gets the string presentation of the object
     *
     * @return string
     */
    public function __toString()
    {
        if (defined('JSON_PRETTY_PRINT')) { // use JSON pretty print
            return json_encode(
                ObjectSerializer::sanitizeForSerialization($this),
                JSON_PRETTY_PRINT
            );
        }

        return json_encode(ObjectSerializer::sanitizeForSerialization($this));
    }
}
