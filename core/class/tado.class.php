<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

/* * ***************************Includes********************************* */
require_once __DIR__  . '/../../../../core/php/core.inc.php';

if (!class_exists('TadoApiHandler')) {
	require_once __DIR__ . '/../../3rdparty/TadoApiHandler.class.php';
}

use Tado\Api\Model\TadoSystemType;
use Tado\Api\Model\Power;
use Tado\Api\Model\OverlayTerminationConditionType;

class tado extends eqLogic {
	/*     * *************************Attributs****************************** */

	private static $_apiHandlers = array();
	private static $_globalConfig = null;

	/*     * ***********************Methode static*************************** */

	public static function getApiHandler($user) {
		if (!isset(tado::$_apiHandlers[$user]) || tado::$_apiHandlers[$user] == null) {
			tado::$_apiHandlers[$user] = new TadoApiHandler($user);
		}
		return tado::$_apiHandlers[$user];
	}

	public static function getGConfig($_key) {
		$keys = explode('::', $_key);
		if (tado::$_globalConfig == null) {
			$confStr = file_get_contents(__DIR__ . '/../config/config.json');
			tado::$_globalConfig = json_decode($confStr, true);
		}
		$return = tado::$_globalConfig;
		foreach ($keys as $key) {
			if (!isset($return[$key])) {
				return '';
			}
			$return = $return[$key];
		}
		return $return;
	}

	public static function syncEqLogicWithTado() {
		$conf_tokens = config::byKey('tadoTokens', 'tado');
		foreach ($conf_tokens as $user => $conf_token) {
			$me = tado::getApiHandler($user)->getMe();
			foreach ($me->homes as $home) {
				$home_id = $home->id;
				$eqLogic = eqLogic::byLogicalId($home_id . "_HOME", 'tado');
				if (!is_object($eqLogic)) {
					$eqLogic = new tado();
					$eqLogic->setIsVisible(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName("$home->name");
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home_id . "_HOME");
					$eqLogic->setConfiguration('eqType', "home");
					$eqLogic->setConfiguration('homeId', $home_id);
					$eqLogic->save();
				}
				$eqLogic->setIsEnable(1);
				$eqLogic->syncData();

				$eqLogic = eqLogic::byLogicalId($home_id . "_WEATHER", 'tado');
				if (!is_object($eqLogic)) {
					$eqLogic = new tado();
					$eqLogic->setIsVisible(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName("Météo - $home->name");
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home_id . "_WEATHER");
					$eqLogic->setConfiguration('eqType', "weather");
					$eqLogic->setConfiguration('homeId', $home_id);
					$eqLogic->save();
				}
				$eqLogic->setIsEnable(1);
				$eqLogic->syncData();

				$zones = tado::getApiHandler($user)->listZones($home_id);
				foreach ($zones as $zone) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_Z" . $zone->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$zone->name - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home_id . "_Z" . $zone->id);
						$eqLogic->setConfiguration('eqType', $zone->type);
						$eqLogic->setConfiguration('homeId', $home_id);
						$eqLogic->setConfiguration('zoneId', $zone->id);
						$eqLogic->save();
					}
					$eqLogic->setIsEnable(1);
					$deviceList = array();
					foreach ($zone->devices as $device) {
						$deviceList[] = array('deviceType' => $device->deviceType, 'shortSerialNo' => $device->shortSerialNo);
					}
					$eqLogic->syncOpenWindowState($zone);
					$eqLogic->setConfiguration('devices', $deviceList);
					$eqLogic->setConfiguration('capabilities', tado::getApiHandler($user)->getZoneCapabilities($home_id, $zone->id));
					$eqLogic->syncData();
				}

				$devices = tado::getApiHandler($user)->listDevices($home_id);
				foreach ($devices as $device) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_" . $device->shortSerialNo, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(0);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$device->shortSerialNo - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home_id . "_" . $device->shortSerialNo);
						$eqLogic->setConfiguration('eqType', $device->deviceType);
						$eqLogic->setConfiguration('homeId', $home_id);
						$eqLogic->setConfiguration('deviceId', $device->shortSerialNo);
						$eqLogic->save();
					}
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('battery_type', self::getGConfig($device->deviceType . '::bat_type'));
					$eqLogic->setConfiguration('currentFwVersion', $device->currentFwVersion);
					$eqLogic->setConfiguration('characteristics', $device->characteristics);
					$eqLogic->syncData();
				}

				$mobileDevices = tado::getApiHandler($user)->listMobileDevices($home_id);
				foreach ($mobileDevices as $mobileDevice) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_MB" . $mobileDevice->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$mobileDevice->name - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home_id . "_MB" . $mobileDevice->id);
						$eqLogic->setConfiguration('eqType', 'mobileDevice');
						$eqLogic->setConfiguration('homeId', $home_id);
						$eqLogic->setConfiguration('mobileDeviceId', $mobileDevice->id);
						$eqLogic->save();
					}
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('deviceMetadata', $mobileDevice->deviceMetadata);
					$eqLogic->syncData();
				}
			}
		}
	}

	public static function byType($_tado_type = '', $_onlyEnable = false) {
		$eqLogics = eqLogic::byType('tado', $_onlyEnable);
		$return = array();
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == $_tado_type) {
				$return[] = $eqLogic;
			}
		}
		return $return;
	}

	public static function byUser($_tado_user = '', $_onlyEnable = false) {
		$eqLogics = eqLogic::byType('tado', $_onlyEnable);
		$return = array();
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('user') == $_tado_user) {
				$return[] = $eqLogic;
			}
		}
		return $return;
	}

	public static function cron() {
		$eqLogics = eqLogic::byType('tado');

		foreach ($eqLogics as $eqLogic) {
			$eqLogicType = $eqLogic->getConfiguration('eqLogicType');
			if ($eqLogicType == 'mobileDevice' || $eqLogicType == 'home') {
				$eqLogic->syncData();
			}
		}
	}

	public static function cron5() {
		$eqLogics = eqLogic::byType('tado');

		foreach ($eqLogics as $eqLogic) {
			$eqLogicType = $eqLogic->getConfiguration('eqLogicType');
			if ($eqLogicType == 'zone') {
				$eqLogic->syncData();
			}
		}
	}

	public static function cron15() {
		$eqLogics = eqLogic::byType('tado');

		foreach ($eqLogics as $eqLogic) {
			$eqLogicType = $eqLogic->getConfiguration('eqLogicType');
			if ($eqLogicType == 'weather' || $eqLogicType == 'device') {
				$eqLogic->syncData();
			}
		}
	}


	/*     * *********************Méthodes d'instance************************* */
	public function getHome() {
		$eqLogics = eqLogic::byType('tado');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'home' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$home = $eqLogic;
			}
		}
		return $home;
	}

	public function getZones() {
		$eqLogics = eqLogic::byType('tado');
		$zones = array();
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'zone' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$zones[] = $eqLogic;
			}
		}
		return $zones;
	}

	public function getMobileDevices() {
		$eqLogics = eqLogic::byType('tado');
		$mobileDevices = array();
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'mobileDevice' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$mobileDevices[] = $eqLogic;
			}
		}
		return $mobileDevices;
	}

	public function getDevices() {
		$eqLogics = eqLogic::byType('tado');
		$devices = array();
		foreach ($eqLogics as $eqLogic) {
			if (($eqLogic->getConfiguration('eqLogicType') == 'device') && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$devices[] = $eqLogic;
			}
		}
		return $devices;
	}

	public function getWeather() {
		$eqLogics = eqLogic::byType('tado');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'weather' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$weather = $eqLogic;
			}
		}
		return $weather;
	}

	public function syncData() {
		if ($this->getIsEnable() == 0) {
			return;
		}
		try {
			$me = tado::getApiHandler($this->getConfiguration('user'))->getMe();
		} catch (Exception $e) {
			log::add('tado', 'debug', $e->getMessage());
			log::add('tado', 'error', 'Connexion to Tado servers seems to be broken. Please try to re-login from plugin configuration page.');
			return;
		}
		$home_id = $this->getConfiguration('homeId');

		switch ($this->getConfiguration('eqLogicType')) {
			case 'home':
				$homeState = tado::getApiHandler($this->getConfiguration('user'))->getHomeState($home_id);
				log::add('tado', 'info', __METHOD__ . ' - homeState : ' . json_encode($homeState));
				if (isset($homeState->showHomePresenceSwitchButton)) {
					if ($homeState->showHomePresenceSwitchButton && $homeState->presence == "AWAY" && $this->getConfiguration('presenceModeAssist') == 'yes') {
						tado::getApiHandler($this->getConfiguration('user'))->updateHomePresence(json_encode(array('homePresence' => "HOME")), $home_id);
						log::add('tado', 'info', __METHOD__ . ' - Automatic HOME mode switch');
					} elseif ($homeState->showHomePresenceSwitchButton && $homeState->presence == "HOME" && $this->getConfiguration('presenceModeAssist') == 'yes') {
						tado::getApiHandler($this->getConfiguration('user'))->updateHomePresence(json_encode(array('homePresence' => "AWAY")), $home_id);
						log::add('tado', 'info', __METHOD__ . ' - Automatic AWAY mode switch');
					}
				}
				foreach ($this->getCmd() as $eqLogic_cmd) {
					switch ($eqLogic_cmd->getLogicalId()) {
						case 'presence':
							$value = $homeState->presence == "HOME" ? true : false;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
					}
				}
				break;

			case 'weather':
				$weather = tado::getApiHandler($this->getConfiguration('user'))->getHomeWeather($home_id);
				foreach ($this->getCmd() as $eqLogic_cmd) {
					switch ($eqLogic_cmd->getLogicalId()) {
						case 'solarIntensity':
							$value = $weather->solarIntensity->percentage;
							$collectDate = date('Y-m-d H:i:s', strtotime($weather->solarIntensity->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
						case 'temperature':
							$value = $weather->outsideTemperature->celsius;
							$collectDate = date('Y-m-d H:i:s', strtotime($weather->outsideTemperature->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
						case 'weatherState':
							$value = $weather->weatherState->value;
							$collectDate = date('Y-m-d H:i:s', strtotime($weather->weatherState->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
					}
				}
				break;
			case 'zone':
				$zone_id = $this->getConfiguration('zoneId');
				$zoneState = tado::getApiHandler($this->getConfiguration('user'))->getZoneState($home_id, $zone_id);
				$zoneDetails = tado::getApiHandler($this->getConfiguration('user'))->getZoneDetails($home_id, $zone_id);
				$this->syncOpenWindowState($zoneDetails);
				log::add('tado', 'info', __METHOD__ . ' - zoneState : ' . json_encode($zoneState));
				if (isset($zoneState->openWindowDetected) && $zoneState->openWindowDetected && $this->getConfiguration('openWindowDetectionAssist') == 'yes') {
					tado::getApiHandler($this->getConfiguration('user'))->activateOpenWindow($home_id, $zone_id);
				}
				foreach ($this->getCmd() as $eqLogic_cmd) {
					switch ($eqLogic_cmd->getLogicalId()) {
						case 'tadoMode':
							$value = $zoneState->tadoMode;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'temperature':
							$value = $zoneState->sensorDataPoints->insideTemperature->celsius;
							$collectDate = date('Y-m-d H:i:s', strtotime($zoneState->sensorDataPoints->insideTemperature->timestamp));
							// Temperature offset tunning							
							$value = $zoneState->sensorDataPoints->insideTemperature->celsius;
							$collectDate = date('Y-m-d H:i:s', strtotime($zoneState->sensorDataPoints->insideTemperature->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
						case 'humidity':
							$value = $zoneState->sensorDataPoints->humidity->percentage;
							$collectDate = date('Y-m-d H:i:s', strtotime($zoneState->sensorDataPoints->humidity->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
						case 'power':
							$value = $zoneState->setting->power == "ON" ? true : false;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'overlayMode':
							if (is_object($zoneState->openWindow)) {
								$value = "OW";
							} elseif (is_object($zoneState->overlay)) {
								$value = $zoneState->overlay->termination->typeSkillBasedApp;
							} else {
								$value = "AUTO";
							}
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'acMode':
							$value = $zoneState->setting->mode;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'acFanSpeed':
							$value = $zoneState->setting->fanSpeed;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'acSwing':
							$value = $zoneState->setting->swing;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'targetTemperature':
							$value = $zoneState->setting->power == "ON" ? $zoneState->setting->temperature->celsius : 0;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'heatingPower':
							$value = $zoneState->activityDataPoints->heatingPower->percentage;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'openWindow':
							$value = (isset($zoneState->openWindowDetected) && $zoneState->openWindowDetected) || is_object($zoneState->openWindow);
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
					}
				}
				break;

			case 'mobileDevice':

				$mobile_id = $this->getConfiguration('mobileDeviceId');
				$mobileDevice = tado::getApiHandler($this->getConfiguration('user'))->getMobileDevice($home_id, $mobile_id);

				foreach ($this->getCmd() as $eqLogic_cmd) {
					switch ($eqLogic_cmd->getLogicalId()) {
						case 'atHome':
							$value = $mobileDevice->location->atHome;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'bearingFromHome':
							$value = $mobileDevice->location->bearingFromHome->degrees;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
						case 'relativeDistanceFromHomeFence':
							$value = $mobileDevice->location->relativeDistanceFromHomeFence;
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value);
							break;
					}
				}
				break;

			case ('device'):

				$device_id = $this->getConfiguration('deviceId');
				$device = tado::getApiHandler($this->getConfiguration('user'))->getDevice($device_id);

				foreach ($this->getCmd() as $eqLogic_cmd) {
					switch ($eqLogic_cmd->getLogicalId()) {
						case 'connectionState':
							$value = $device->connectionState->value;
							$collectDate = date('Y-m-d H:i:s', strtotime($device->connectionState->timestamp));
							$this->checkAndUpdateCmd($eqLogic_cmd->getLogicalId(), $value, $collectDate);
							break;
					}
				}
				if (isset($device->batteryState)) {
					if ($device->batteryState == 'NORMAL') {
						$this->batteryStatus(100);
					} else {
						$this->batteryStatus(10);
					}
				}
				break;
		}
	}

	public function syncOpenWindowState($zoneDetails) {
		// Mise a jour du status de détection des fenêtres ouverte, au cas ou cela aurais été fait à partir de l'App Tado
		if (!empty($zoneDetails->openWindowDetection) && json_encode($this->getConfiguration('openWindowDetection')) != json_encode($zoneDetails->openWindowDetection)) {
			$this->setConfiguration('openWindowDetection', $zoneDetails->openWindowDetection);
			if ($zoneDetails->openWindowDetection->supported) {
				$this->setConfiguration('openWindowDetectionEnabled', $zoneDetails->openWindowDetection->enabled ? "yes" : "no");
				$this->setConfiguration('openWindowTimeout', $zoneDetails->openWindowDetection->timeoutInSeconds / 60);
			}
			$this->save();
			log::add('tado', 'debug', __METHOD__ . ' - Open Window detection updated - ' . json_encode($zoneDetails->openWindowDetection));
		}
	}

	public function postSave() {
		if ($this->getIsEnable() == 1 && $this->getConfiguration('eqLogicType') == 'zone') {
			$eqLogic = eqLogic::byId($this->id);
			$capabilities = $eqLogic->getConfiguration('capabilities');
			if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
				$coolCmdState = $eqLogic->getCmd(null, 'coolCmdState');
				$cool = $eqLogic->getCmd(null, 'cool');
				if (is_object($coolCmdState) && is_object($cool)) {
					if ($coolCmdState->execCmd() == 1) {
						$capabilities = $capabilities['COOL'];
					} else {
						$capabilities = $capabilities['HEAT'];
					}
					$cool->setValue($coolCmdState->getId());
					$cool->save();
				}
			}
			if (isset($capabilities['temperatures']) && (!isset($capabilities['canSetTemperature']) || isset($capabilities['canSetTemperature']) && $capabilities['canSetTemperature'])) {
				$order = $eqLogic->getCmd(null, 'targetTemperature');
				$thermostat = $eqLogic->getCmd(null, 'thermostat');
				if (is_object($thermostat) && is_object($order)) {
					$thermostat->setValue($order->getId());

					$order->setConfiguration('maxValue', $capabilities['temperatures']['celsius']['max']);
					$order->setConfiguration('minValue', min(0, $capabilities['temperatures']['celsius']['min'] - 1));
					$thermostat->setConfiguration('maxValue', $capabilities['temperatures']['celsius']['max']);
					$thermostat->setConfiguration('minValue', $capabilities['temperatures']['celsius']['min'] - 1);

					$order->save();
					$thermostat->save();
				}
			}
		}
	}

	public function preUpdate() {
		if ($this->getConfiguration('eqLogicType') == 'zone') {
			if ($this->getConfiguration('overlayTimeoutSelection') == 'TIMER') {
				$value = $this->getConfiguration('overlayTimeout');
				if ($value == '') {
					throw new Exception(__('La durée du timer ne peut être vide', __FILE__));
				} elseif (!is_numeric($value)) {
					throw new Exception(__('La valeur du timer doit etre numérique', __FILE__));
				} elseif ($value < 5) {
					throw new Exception(__('La valeur du timer doit être supérieure à 5 min', __FILE__));
				} elseif ($value > 720) {
					throw new Exception(__('La valeur du timer doit être inférieure à 720 min', __FILE__));
				}
			}
			$oldEqLogic = eqLogic::byId($this->id);
			$oldConf = $oldEqLogic->getConfiguration('openWindowDetectionEnabled');
			$newConf = $this->getConfiguration('openWindowDetectionEnabled');
			$oldTimeout = $oldEqLogic->getConfiguration('openWindowTimeout');
			$newTimeout = $this->getConfiguration('openWindowTimeout');

			if (($oldConf != $newConf || $oldTimeout != $newTimeout) && is_numeric($newTimeout)) {
				$payload = array(
					'enabled' => ($newConf == 'yes') ? true : false,
					'timeoutInSeconds' => $newTimeout * 60
				);
				$Data = tado::getApiHandler($this->getConfiguration('user'))->updateZoneOpenWindowDetection(json_encode($payload), $this->getConfiguration('homeId'), $this->getConfiguration('zoneId'));
				if (!is_object($Data)) {
					throw new Exception(__('Erreur lors de la mise a jour de la détection de fenêtre ouverte'));
				} else {
					$conf = (object) $this->getConfiguration('openWindowDetection');
					$conf->enabled = $payload['enabled'];
					$conf->timeoutInSeconds = $payload['timeoutInSeconds'];
					$this->setConfiguration('openWindowDetection', $conf);
				}
			}
		}
	}

	public function runtimeByDay($_startDate = null, $_endDate = null) {
		if ($this->getConfiguration('eqType') == 'HOT_WATER') {
			//$actifCmd = $this->getCmd(null, 'power');
		} else {
			$actifCmd = $this->getCmd(null, 'heatingPower');
		}
		if (!is_object($actifCmd)) {
			return array();
		}
		$return = array();
		$prevValue = 0;
		$prevDatetime = 0;
		$day = null;
		$day = strtotime($_startDate . ' 00:00:00 UTC');
		$endDatetime = strtotime($_endDate . ' 00:00:00 UTC');
		while ($day <= $endDatetime) {
			$return[date('Y-m-d', $day)] = array($day * 1000, 0);
			$day = $day + 3600 * 24;
		}
		foreach ($actifCmd->getHistory($_startDate, $_endDate) as $history) {
			if (date('Y-m-d', strtotime($history->getDatetime())) != $day && $prevValue > 0 && $day != null) {
				if (strtotime($day . ' 23:59:59') > $prevDatetime) {
					$return[$day][1] += (strtotime($day . ' 23:59:59') - $prevDatetime) / 60;
				}
				$prevDatetime = strtotime(date('Y-m-d 00:00:00', strtotime($history->getDatetime())));
			}
			$day = date('Y-m-d', strtotime($history->getDatetime()));
			if (!isset($return[$day])) {
				$return[$day] = array(strtotime($day . ' 00:00:00 UTC') * 1000, 0);
			}
			if ($history->getValue() > 0 && $prevValue == 0) {
				$prevDatetime = strtotime($history->getDatetime());
				$prevValue = $history->getValue();
			}
			if ($history->getValue() == 0 && $prevValue > 0) {
				if ($prevDatetime > 0 && strtotime($history->getDatetime()) > $prevDatetime) {
					$return[$day][1] += (strtotime($history->getDatetime()) - $prevDatetime) / 60;
				}
				$prevValue = 0;
			}
		}
		return $return;
	}
	/*     * **********************Getteur Setteur*************************** */
}

class tadoCmd extends cmd {
	/*     * *************************Attributs****************************** */


	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

	public function execute($_options = array()) {
		$lId = $this->getLogicalId();
		$eqLogic = $this->getEqLogic();

		if ($lId == 'refresh') {
			$eqLogic->syncData();
		} elseif ($lId == 'activateOpenWindow') {
			// Open window activation : Does not work when no open window is detected. Works when open window is actually detected
			$home_id = $eqLogic->getConfiguration('homeId');
			$zone_id = $eqLogic->getConfiguration('zoneId');
			$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->activateOpenWindow($home_id, $zone_id);
			$eqLogic->syncData();
		} elseif ($lId == 'auto') {
			// Cancel Open Window mode
			//$eqLogic->getCmd(null, 'targetTemperature')->execCmd()
			$home_id = $eqLogic->getConfiguration('homeId');
			$zone_id = $eqLogic->getConfiguration('zoneId');
			$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->deleteZoneOverlay($home_id, $zone_id);
			if ($eqLogic->getConfiguration('eqType') != "HOT_WATER") {
				$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->deleteOpenWindow($home_id, $zone_id);
			}
			$eqLogic->syncData();
		} elseif ($lId == 'away') {
			$home_id = $eqLogic->getConfiguration('homeId');
			$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->updateHomePresenceLock(json_encode(array('homePresence' => "AWAY")), $home_id);
			$eqLogic->syncData();
			$zones = eqLogic::byType('tado');
			foreach ($zones as $zone) {
				if ($zone->getConfiguration('eqLogicType') == 'zone') {
					$zone->syncData();
				}
			}
		} elseif ($lId == 'home') {
			$home_id = $eqLogic->getConfiguration('homeId');
			$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->updateHomePresenceLock(json_encode(array('homePresence' => "HOME")), $home_id);
			$eqLogic->syncData();
			$zones = eqLogic::byType('tado');
			foreach ($zones as $zone) {
				if ($zone->getConfiguration('eqLogicType') == 'zone') {
					$zone->syncData();
				}
			}
		} elseif ($lId == 'cool') {
			if (!isset($_options['slider']) || $_options['slider'] == '' || !is_numeric(intval($_options['slider']))) {
				return;
			}
			$eqLogic->checkAndUpdateCmd('coolCmdState', $_options['slider']);
			$eqLogic->save();
			$eqLogic->refreshWidget();
		} elseif ($lId == 'thermostat' && $eqLogic->getConfiguration('eqLogicType') == 'zone') {
			if (!isset($_options['slider']) || $_options['slider'] == '' || !is_numeric(intval($_options['slider']))) {
				return;
			}
			$changed = ($eqLogic->getCmd(null, 'targetTemperature')->execCmd() != $_options['slider']);
			if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
				if ($eqLogic->getCmd(null, 'coolCmdState')->execCmd() == 1) {
					$localMode = 'COOL';
				} else {
					$localMode = 'HEAT';
				}
				$changed = $changed || ($eqLogic->getCmd(null, 'acMode')->execCmd() != $localMode);
			}
			if ($changed) {
				$home_id = $eqLogic->getConfiguration('homeId');
				$zone_id = $eqLogic->getConfiguration('zoneId');
				$capabilities = $eqLogic->getConfiguration('capabilities');
				if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
					if ($eqLogic->getCmd(null, 'coolCmdState')->execCmd() == 1) {
						$capabilities  = $capabilities['COOL'];
					} else {
						$capabilities  = $capabilities['HEAT'];
					}
				}

				if (isset($capabilities['canSetTemperature']) && !$capabilities['canSetTemperature']) {
					return;
				}
				if ($_options['slider'] >= $capabilities['temperatures']['celsius']['min'] && $_options['slider'] <= $capabilities['temperatures']['celsius']['max']) {
					$setting = array(
						'type' => $eqLogic->getConfiguration('eqType'),
						'power' => 'ON',
						'temperature' => array(
							'celsius' => $_options['slider']
						)
					);
					if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
						if (isset($capabilities['fanSpeeds'])) {
							$setting['fanSpeed'] = 'AUTO';
						}
						if (isset($capabilities['swings'])) {
							$setting['swing'] = 'OFF';
						}
						if ($eqLogic->getCmd(null, 'coolCmdState')->execCmd() == 1) {
							$setting['mode'] = 'COOL';
						} else {
							$setting['mode'] = 'HEAT';
						}
					}
				} else {
					$setting = array(
						'type' => $eqLogic->getConfiguration('eqType'),
						'power' => 'OFF',
					);
				}
				$Timeout = $eqLogic->getConfiguration('overlayTimeoutSelection');
				$termination = array('typeSkillBasedApp' => 'NEXT_TIME_BLOCK');
				if ($Timeout == 'TIMER' && is_numeric($eqLogic->getConfiguration('overlayTimeout'))) {
					$termination['typeSkillBasedApp'] = 'TIMER';
					$termination['durationInSeconds'] = $eqLogic->getConfiguration('overlayTimeout') * 60;
				} elseif ($Timeout == 'NEXT_TIME_BLOCK') {
					$termination['typeSkillBasedApp'] = 'TADO_MODE';
				} elseif ($Timeout == 'MANUAL') {
					$termination['typeSkillBasedApp'] = 'MANUAL';
				}

				$payload = array(
					'setting' => $setting,
					'termination' => $termination
				);
				$Data = tado::getApiHandler($eqLogic->getConfiguration('user'))->updateZoneOverlay(json_encode($payload), $home_id, $zone_id);
				$eqLogic->syncData();
			}
		}
	}

	/*     * **********************Getteur Setteur*************************** */
}
