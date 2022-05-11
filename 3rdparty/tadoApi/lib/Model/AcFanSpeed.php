<?php
/**
 * AcFanSpeed
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
 * AcFanSpeed Class Doc Comment
 *
 * @category Class
 * @description Cooling system fan speed.
 * @package  Tado\Api
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
class AcFanSpeed
{
    /**
     * Possible values of this enum
     */
    const LOW = 'LOW';
const MIDDLE = 'MIDDLE';
const HIGH = 'HIGH';
const AUTO = 'AUTO';
    /**
     * Gets allowable values of the enum
     * @return string[]
     */
    public static function getAllowableEnumValues()
    {
        return [
            self::LOW,
self::MIDDLE,
self::HIGH,
self::AUTO,        ];
    }
}
