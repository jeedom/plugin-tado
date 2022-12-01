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

	/*     * ***********************Methode static*************************** */

	public static function getApiHandler($user) {
		if (!isset(tado::$_apiHandlers[$user]) || tado::$_apiHandlers[$user] == null) {
			tado::$_apiHandlers[$user] = new TadoApiHandler($user);
		}
		return tado::$_apiHandlers[$user];
	}

	public static function syncEqLogicWithTado() {
		$conf_tokens = config::byKey('tadoTokens', 'tado');
		foreach ($conf_tokens as $user => $conf_token) {
			$me = tado::getApiHandler($user)->getMe();
			foreach ($me->homes as $home) {
				$eqLogic = eqLogic::byLogicalId($home->id . "_HOME", 'tado');
				if (!is_object($eqLogic)) {
					$eqLogic = new tado();
					$eqLogic->setIsVisible(1);
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName($home->name);
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home->id . "_HOME");
					$eqLogic->setConfiguration('homeId', $home->id);
				}
				$eqLogic->setConfiguration('eqLogicType', 'home');
				$eqLogic->setConfiguration('device', 'home');
				$eqLogic->save();
				$eqLogic->syncData();

				$eqLogic = eqLogic::byLogicalId($home->id . "_WEATHER", 'tado');
				if (!is_object($eqLogic)) {
					$eqLogic = new tado();
					$eqLogic->setIsVisible(1);
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName("Météo - $home->name");
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home->id . "_WEATHER");
					$eqLogic->setConfiguration('homeId', $home->id);
				}
				$eqLogic->setConfiguration('eqLogicType', 'weather');
				$eqLogic->setConfiguration('device', 'weather');
				$eqLogic->save();
				$eqLogic->syncData();

				$zones = tado::getApiHandler($user)->listZones($home->id);
				foreach ($zones as $zone) {
					$eqLogic = eqLogic::byLogicalId($home->id . "_Z" . $zone->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setIsEnable(1);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$zone->name - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home->id . "_Z" . $zone->id);
						$eqLogic->setConfiguration('homeId', $home->id);
						$eqLogic->setConfiguration('zoneId', $zone->id);
					}
					$eqLogic->setConfiguration('device', $zone->type);
					$deviceList = array();
					foreach ($zone->devices as $device) {
						$deviceList[] = array('deviceType' => $device->deviceType, 'shortSerialNo' => $device->shortSerialNo);
					}
					$eqLogic->setConfiguration('eqLogicType', 'zone');
					$eqLogic->setConfiguration('devices', $deviceList);
					$eqLogic->setConfiguration('capabilities', tado::getApiHandler($user)->getZoneCapabilities($home->id, $zone->id));
					$eqLogic->save();
					$eqLogic->syncData();
				}

				$devices = tado::getApiHandler($user)->listDevices($home->id);
				foreach ($devices as $device) {
					$eqLogic = eqLogic::byLogicalId($home->id . "_" . $device->shortSerialNo, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(0);
						$eqLogic->setIsEnable(1);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$device->shortSerialNo - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home->id . "_" . $device->shortSerialNo);
						$eqLogic->setConfiguration('homeId', $home->id);
						$eqLogic->setConfiguration('deviceId', $device->shortSerialNo);
					}
					$eqLogic->setConfiguration('eqLogicType', 'device');
					$eqLogic->setConfiguration('device', $device->deviceType);
					$eqLogic->setConfiguration('currentFwVersion', $device->currentFwVersion);
					$eqLogic->setConfiguration('characteristics', $device->characteristics);
					$eqLogic->save();
					$eqLogic->syncData();
				}

				$mobileDevices = tado::getApiHandler($user)->listMobileDevices($home->id);
				foreach ($mobileDevices as $mobileDevice) {
					$eqLogic = eqLogic::byLogicalId($home->id . "_MB" . $mobileDevice->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setIsEnable(1);
						$eqLogic->setConfiguration('user', $user);
						$eqLogic->setName("$mobileDevice->name - $home->name");
						$eqLogic->setEqType_name('tado');
						$eqLogic->setCategory('heating', 1);
						$eqLogic->setLogicalId($home->id . "_MB" . $mobileDevice->id);
						$eqLogic->setConfiguration('homeId', $home->id);
						$eqLogic->setConfiguration('mobileDeviceId', $mobileDevice->id);
					}
					$eqLogic->setConfiguration('eqLogicType', 'mobileDevice');
					$eqLogic->setConfiguration('device', 'mobileDevice');
					$eqLogic->setConfiguration('deviceMetadata', $mobileDevice->deviceMetadata);
					$eqLogic->save();
					$eqLogic->syncData();
				}
			}
		}
	}

	public static function cron5() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if (in_array($eqLogic->getConfiguration('eqLogicType'), array('zone', 'mobileDevice', 'home'))) {
				$eqLogic->syncData();
			}
		}
	}

	public static function cron15() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if (in_array($eqLogic->getConfiguration('eqLogicType'), array('weather', 'device'))) {
				$eqLogic->syncData();
			}
		}
	}

	public static function devicesParameters($_device = '') {
		$return = array();
		foreach (ls(dirname(__FILE__) . '/../config/devices', '*.json') as $file) {
			try {
				$content = is_json(file_get_contents(dirname(__FILE__) . '/../config/devices/' . $file), false);
				if ($content != false) {
					$return[str_replace('.json', '', $file)] = $content;
				}
			} catch (Exception $e) {
			}
		}
		if (isset($_device) && $_device != '') {
			if (isset($return[$_device])) {
				return $return[$_device];
			}
			return array();
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
	/*     * *********************Méthodes d'instance************************* */

	public function syncData() {
		if ($this->getIsEnable() == 0) {
			return;
		}
		try {
			tado::getApiHandler($this->getConfiguration('user'))->getMe();
		} catch (Exception $e) {
			log::add('tado', 'debug', $e->getMessage());
			log::add('tado', 'error', 'Connexion to Tado servers seems to be broken. Please try to re-login from plugin configuration page.');
			return;
		}
		$home_id = $this->getConfiguration('homeId');
		switch ($this->getConfiguration('eqLogicType')) {
			case 'home':
				$homeState = tado::getApiHandler($this->getConfiguration('user'))->getHomeState($home_id);
				$this->checkAndUpdateCmd('presence', ($homeState->presence == "HOME") ? true : false);
				if ($homeState->presence == "AWAY" && $this->getConfiguration('presenceModeAssist') == 'yes') {
					tado::getApiHandler($this->getConfiguration('user'))->updateHomePresence(json_encode(array('homePresence' => "HOME")), $home_id);
				} elseif ($homeState->presence == "HOME" && $this->getConfiguration('presenceModeAssist') == 'yes') {
					tado::getApiHandler($this->getConfiguration('user'))->updateHomePresence(json_encode(array('homePresence' => "AWAY")), $home_id);
				}
				break;
			case 'weather':
				$weather = tado::getApiHandler($this->getConfiguration('user'))->getHomeWeather($home_id);
				$this->checkAndUpdateCmd('solarIntensity', $weather->solarIntensity->percentage, date('Y-m-d H:i:s', strtotime($weather->solarIntensity->timestamp)));
				$this->checkAndUpdateCmd('temperature', $weather->outsideTemperature->celsius, date('Y-m-d H:i:s', strtotime($weather->outsideTemperature->timestamp)));
				$this->checkAndUpdateCmd('weatherState', $weather->weatherState->value, date('Y-m-d H:i:s', strtotime($weather->weatherState->timestamp)));
				break;
			case 'zone':
				$zoneState = tado::getApiHandler($this->getConfiguration('user'))->getZoneState($home_id, $this->getConfiguration('zoneId'));
				if (isset($zoneState->openWindowDetected) && $zoneState->openWindowDetected && $this->getConfiguration('openWindowDetectionAssist') == 'yes') {
					tado::getApiHandler($this->getConfiguration('user'))->activateOpenWindow($home_id, $this->getConfiguration('zoneId'));
				}
				$this->checkAndUpdateCmd('tadoMode', $zoneState->tadoMode);
				if (isset($zoneState->sensorDataPoints->insideTemperature->celsius)) {
					$this->checkAndUpdateCmd('temperature', $zoneState->sensorDataPoints->insideTemperature->celsius, date('Y-m-d H:i:s', strtotime($zoneState->sensorDataPoints->insideTemperature->timestamp)));
				}
				if (isset($zoneState->sensorDataPoints->humidity->percentage)) {
					$this->checkAndUpdateCmd('humidity', $zoneState->sensorDataPoints->humidity->percentage, date('Y-m-d H:i:s', strtotime($zoneState->sensorDataPoints->humidity->timestamp)));
				}
				$this->checkAndUpdateCmd('power', ($zoneState->setting->power == "ON"));
				if (is_object($zoneState->openWindow)) {
					$value = "OW";
				} elseif (is_object($zoneState->overlay)) {
					$value = $zoneState->overlay->termination->typeSkillBasedApp;
				} else {
					$value = "AUTO";
				}
				$this->checkAndUpdateCmd('overlayMode', $value);
				if (isset($zoneState->setting->mode)) {
					$this->checkAndUpdateCmd('acMode', $zoneState->setting->mode);
				}
				if (isset($zoneState->setting->fanLevel)) {
					$this->checkAndUpdateCmd('acFanLevel', $zoneState->setting->fanLevel);
				}
				if (isset($zoneState->setting->verticalSwing)) {
					$this->checkAndUpdateCmd('acVerticalSwing', $zoneState->setting->verticalSwing);
				}
				if (isset($zoneState->setting->temperature->celsius) && $zoneState->setting->temperature->celsius > 0) {
					$this->checkAndUpdateCmd('targetTemperature', $zoneState->setting->temperature->celsius);
				}
				if (isset($zoneState->activityDataPoints->heatingPower->percentage)) {
					$this->checkAndUpdateCmd('heatingPower', $zoneState->activityDataPoints->heatingPower->percentage);
				}
				$this->checkAndUpdateCmd('openWindow', (isset($zoneState->openWindowDetected) && $zoneState->openWindowDetected) || is_object($zoneState->openWindow));
				break;
			case 'mobileDevice':
				$mobileDevice = tado::getApiHandler($this->getConfiguration('user'))->getMobileDevice($home_id, $this->getConfiguration('mobileDeviceId'));
				if (isset($mobileDevice->location)) {
					$this->checkAndUpdateCmd('bearingFromHome', $mobileDevice->location->bearingFromHome->degrees);
					$this->checkAndUpdateCmd('atHome', $mobileDevice->location->atHome);
					$this->checkAndUpdateCmd('relativeDistanceFromHomeFence', $mobileDevice->location->relativeDistanceFromHomeFence);
				}
				break;
			case 'device':
				$device = tado::getApiHandler($this->getConfiguration('user'))->getDevice($this->getConfiguration('deviceId'));
				$this->checkAndUpdateCmd('connectionState', $device->connectionState->value, date('Y-m-d H:i:s', strtotime($device->connectionState->timestamp)));
				if (isset($device->batteryState)) {
					$this->batteryStatus(($device->batteryState == 'NORMAL') ? 100 : 20);
				}
				break;
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
		}
	}

	public function postSave() {
		if ($this->getConfiguration('applyDevice') != strtolower($this->getConfiguration('device'))) {
			$this->applyModuleConfiguration();
		}
	}

	public function applyModuleConfiguration() {
		$this->setConfiguration('applyDevice', strtolower($this->getConfiguration('device')));
		if ($this->getConfiguration('device') == '') {
			return true;
		}
		$device = self::devicesParameters(strtolower($this->getConfiguration('device')));
		if (!is_array($device) || !isset($device['commands'])) {
			return true;
		}
		$this->import($device);
	}

	public function getImage() {
		if (file_exists(__DIR__ . '/../config/devices/' .  strtolower($this->getConfiguration('device')) . '.png')) {
			return 'plugins/tado/core/config/devices/' .  strtolower($this->getConfiguration('device')) . '.png';
		}
		return false;
	}


	/*     * **********************Getteur Setteur*************************** */
}

class tadoCmd extends cmd {
	/*     * *************************Attributs****************************** */


	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

	public function formatValueWidget($_value) {
		if ($this->getLogicalId() == 'heatingPower') {
			if ($_value > 0) {
				return '<span class="icon_red">' . $_value . '<span>';
			}
			return $_value;
		}
		return $_value;
	}

	public function execute($_options = array()) {
		$eqLogic = $this->getEqLogic();
		if ($this->getLogicalId() == 'refresh') {
			$eqLogic->syncData();
			return;
		} elseif ($this->getLogicalId() == 'activateOpenWindow') {
			// Open window activation : Does not work when no open window is detected. Works when open window is actually detected
			tado::getApiHandler($eqLogic->getConfiguration('user'))->activateOpenWindow($eqLogic->getConfiguration('homeId'), $eqLogic->getConfiguration('zoneId'));
			$eqLogic->syncData();
			return;
		} elseif ($this->getLogicalId() == 'auto') {
			// Cancel Open Window mode
			tado::getApiHandler($eqLogic->getConfiguration('user'))->deleteZoneOverlay($eqLogic->getConfiguration('homeId'), $eqLogic->getConfiguration('zoneId'));
			if ($eqLogic->getConfiguration('device') != "HOT_WATER") {
				tado::getApiHandler($eqLogic->getConfiguration('user'))->deleteOpenWindow($eqLogic->getConfiguration('homeId'), $eqLogic->getConfiguration('zoneId'));
			}
			$eqLogic->syncData();
			return;
		} elseif ($this->getLogicalId() == 'away') {
			tado::getApiHandler($eqLogic->getConfiguration('user'))->updateHomePresenceLock(json_encode(array('homePresence' => "AWAY")), $eqLogic->getConfiguration('homeId'));
			$eqLogic->syncData();
			foreach ((eqLogic::byType('tado')) as $zone) {
				if ($zone->getConfiguration('eqLogicType') == 'zone') {
					$zone->syncData();
				}
			}
			return;
		} elseif ($this->getLogicalId() == 'home') {
			tado::getApiHandler($eqLogic->getConfiguration('user'))->updateHomePresenceLock(json_encode(array('homePresence' => "HOME")), $eqLogic->getConfiguration('homeId'));
			$eqLogic->syncData();
			foreach ((eqLogic::byType('tado')) as $zone) {
				if ($zone->getConfiguration('eqLogicType') == 'zone') {
					$zone->syncData();
				}
			}
			return;
		} elseif ($this->getLogicalId() == 'off') {
			$setting = array('type' => $eqLogic->getConfiguration('device'), 'power' => 'OFF');
		} elseif ($this->getLogicalId() == 'rawSet') {
			$setting = json_decode('{' . $_options['message'] . '}', true);
			$setting['type'] = $eqLogic->getConfiguration('device');
		} else {
			$setting = array(
				'type' => $eqLogic->getConfiguration('device'),
				'power' => 'ON',
				'temperature' => array(
					'celsius' => $eqLogic->getCmd('info', 'targetTemperature')->execCmd()
				)
			);
			if ($eqLogic->getConfiguration('device') == 'AIR_CONDITIONING') {
				$setting['verticalSwing'] = ($eqLogic->getCmd('info', 'acVerticalSwing')->execCmd()) ? 'ON' : 'OFF';
				$setting['mode'] = $eqLogic->getCmd('info', 'acMode')->execCmd();
				$setting['fanLevel'] = $eqLogic->getCmd('info', 'acFanLevel')->execCmd();
			}
			if ($eqLogic->getConfiguration('eqLogicType') == 'zone') {
				if ($this->getLogicalId() == 'thermostat') {
					$setting['temperature']['celsius'] = $_options['slider'];
				}
				if ($this->getLogicalId() == 'acModeSet') {
					$setting['mode'] = $_options['select'];
				}
				if ($this->getLogicalId() == 'acFanLevelSet') {
					$setting['fanLevel'] = $_options['select'];
				}
				if ($this->getLogicalId() == 'acVerticalSwingOn') {
					$setting['verticalSwing'] = 'ON';
				}
				if ($this->getLogicalId() == 'acVerticalSwingOff') {
					$setting['verticalSwing'] = 'OFF';
				}
			}
			if (isset($setting['mode'])) {
				if ($setting['mode'] == 'DRY') {
					unset($setting['fanLevel']);
				} elseif ($setting['mode'] == 'FAN') {
					unset($setting['temperature']);
				}
			}
		}
		$termination = array('typeSkillBasedApp' => 'NEXT_TIME_BLOCK');
		if ($eqLogic->getConfiguration('overlayTimeoutSelection') == 'TIMER' && is_numeric($eqLogic->getConfiguration('overlayTimeout'))) {
			$termination['typeSkillBasedApp'] = 'TIMER';
			$termination['durationInSeconds'] = $eqLogic->getConfiguration('overlayTimeout') * 60;
		} elseif ($eqLogic->getConfiguration('overlayTimeoutSelection') == 'NEXT_TIME_BLOCK') {
			$termination['typeSkillBasedApp'] = 'TADO_MODE';
		} elseif ($eqLogic->getConfiguration('overlayTimeoutSelection') == 'MANUAL') {
			$termination['typeSkillBasedApp'] = 'MANUAL';
		}
		$payload = array('setting' => $setting, 'termination' => $termination);
		tado::getApiHandler($eqLogic->getConfiguration('user'))->updateZoneOverlay(json_encode($payload), $eqLogic->getConfiguration('homeId'), $eqLogic->getConfiguration('zoneId'));
		$eqLogic->syncData();
	}

	/*     * **********************Getteur Setteur*************************** */
}
