<?php
/**
 * TimerTerminationCondition
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
use \Tado\Api\ObjectSerializer;

/**
 * TimerTerminationCondition Class Doc Comment
 *
 * @category Class
 * @package  Tado\Api
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class TimerTerminationCondition extends OverlayTerminationCondition 
{
    const DISCRIMINATOR = null;

    /**
      * The original name of the model.
      *
      * @var string
      */
    protected static $swaggerModelName = 'TimerTerminationCondition';

    /**
      * Array of property to type mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerTypes = [
        'duration_in_seconds' => 'int',
'expiry' => '\DateTime',
'remaining_time_in_seconds' => 'int'    ];

    /**
      * Array of property to format mappings. Used for (de)serialization
      *
      * @var string[]
      */
    protected static $swaggerFormats = [
        'duration_in_seconds' => null,
'expiry' => 'date-time',
'remaining_time_in_seconds' => null    ];

    /**
     * Array of property to type mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerTypes()
    {
        return self::$swaggerTypes + parent::swaggerTypes();
    }

    /**
     * Array of property to format mappings. Used for (de)serialization
     *
     * @return array
     */
    public static function swaggerFormats()
    {
        return self::$swaggerFormats + parent::swaggerFormats();
    }

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @var string[]
     */
    protected static $attributeMap = [
        'duration_in_seconds' => 'durationInSeconds',
'expiry' => 'expiry',
'remaining_time_in_seconds' => 'remainingTimeInSeconds'    ];

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @var string[]
     */
    protected static $setters = [
        'duration_in_seconds' => 'setDurationInSeconds',
'expiry' => 'setExpiry',
'remaining_time_in_seconds' => 'setRemainingTimeInSeconds'    ];

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @var string[]
     */
    protected static $getters = [
        'duration_in_seconds' => 'getDurationInSeconds',
'expiry' => 'getExpiry',
'remaining_time_in_seconds' => 'getRemainingTimeInSeconds'    ];

    /**
     * Array of attributes where the key is the local name,
     * and the value is the original name
     *
     * @return array
     */
    public static function attributeMap()
    {
        return parent::attributeMap() + self::$attributeMap;
    }

    /**
     * Array of attributes to setter functions (for deserialization of responses)
     *
     * @return array
     */
    public static function setters()
    {
        return parent::setters() + self::$setters;
    }

    /**
     * Array of attributes to getter functions (for serialization of requests)
     *
     * @return array
     */
    public static function getters()
    {
        return parent::getters() + self::$getters;
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
     * Constructor
     *
     * @param mixed[] $data Associated array of property values
     *                      initializing the model
     */
    public function __construct(array $data = null)
    {
        parent::__construct($data);

        $this->container['duration_in_seconds'] = isset($data['duration_in_seconds']) ? $data['duration_in_seconds'] : null;
        $this->container['expiry'] = isset($data['expiry']) ? $data['expiry'] : null;
        $this->container['remaining_time_in_seconds'] = isset($data['remaining_time_in_seconds']) ? $data['remaining_time_in_seconds'] : null;
    }

    /**
     * Show all the invalid properties with reasons.
     *
     * @return array invalid properties with reasons
     */
    public function listInvalidProperties()
    {
        $invalidProperties = parent::listInvalidProperties();

        if ($this->container['duration_in_seconds'] === null) {
            $invalidProperties[] = "'duration_in_seconds' can't be null";
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
     * Gets duration_in_seconds
     *
     * @return int
     */
    public function getDurationInSeconds()
    {
        return $this->container['duration_in_seconds'];
    }

    /**
     * Sets duration_in_seconds
     *
     * @param int $duration_in_seconds The number of seconds that the overlay should last/was configured to last.
     *
     * @return $this
     */
    public function setDurationInSeconds($duration_in_seconds)
    {
        $this->container['duration_in_seconds'] = $duration_in_seconds;

        return $this;
    }

    /**
     * Gets expiry
     *
     * @return \DateTime
     */
    public function getExpiry()
    {
        return $this->container['expiry'];
    }

    /**
     * Sets expiry
     *
     * @param \DateTime $expiry [ISO8601 datetime](https://en.wikipedia.org/wiki/ISO_8601). E.g.: `2015-09-28T15:03:20Z` with second precision. Only relevant when receiving an overlay, ignored when overlay is sent to the server.
     *
     * @return $this
     */
    public function setExpiry($expiry)
    {
        $this->container['expiry'] = $expiry;

        return $this;
    }

    /**
     * Gets remaining_time_in_seconds
     *
     * @return int
     */
    public function getRemainingTimeInSeconds()
    {
        return $this->container['remaining_time_in_seconds'];
    }

    /**
     * Sets remaining_time_in_seconds
     *
     * @param int $remaining_time_in_seconds The number of seconds that are remaining of the timer overlay at the time that the response is assembled by the server.
     *
     * @return $this
     */
    public function setRemainingTimeInSeconds($remaining_time_in_seconds)
    {
        $this->container['remaining_time_in_seconds'] = $remaining_time_in_seconds;

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
