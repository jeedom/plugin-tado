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
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName($home->name);
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home_id . "_HOME");
					$eqLogic->setConfiguration('eqType', "home");
					$eqLogic->setConfiguration('homeId', $home_id);
					$eqLogic->save();
				}
				$eqLogic->setEqLogicConfig();
				$eqLogic->syncData();

				$eqLogic = eqLogic::byLogicalId($home_id . "_WEATHER", 'tado');
				if (!is_object($eqLogic)) {
					$eqLogic = new tado();
					$eqLogic->setIsVisible(1);
					$eqLogic->setIsEnable(1);
					$eqLogic->setConfiguration('user', $user);
					$eqLogic->setName("Météo - $home->name");
					$eqLogic->setEqType_name('tado');
					$eqLogic->setCategory('heating', 1);
					$eqLogic->setLogicalId($home_id . "_WEATHER");
					$eqLogic->setConfiguration('eqType', "weather");
					$eqLogic->setConfiguration('homeId', $home_id);
					$eqLogic->save();
				}
				$eqLogic->setEqLogicConfig();
				$eqLogic->syncData();

				$zones = tado::getApiHandler($user)->listZones($home_id);
				foreach ($zones as $zone) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_Z" . $zone->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setIsEnable(1);
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
					$deviceList = array();
					foreach ($zone->devices as $device) {
						$deviceList[] = array('deviceType' => $device->deviceType, 'shortSerialNo' => $device->shortSerialNo);
					}
					$eqLogic->syncOpenWindowState($zone);
					$eqLogic->setConfiguration('devices', $deviceList);
					$eqLogic->setConfiguration('capabilities', tado::getApiHandler($user)->getZoneCapabilities($home_id, $zone->id));
					$eqLogic->setEqLogicConfig();
					$eqLogic->syncData();
				}

				$devices = tado::getApiHandler($user)->listDevices($home_id);
				foreach ($devices as $device) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_" . $device->shortSerialNo, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(0);
						$eqLogic->setIsEnable(1);
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
					$eqLogic->setConfiguration('battery_type', self::getGConfig($device->deviceType . '::bat_type'));
					$eqLogic->setConfiguration('currentFwVersion', $device->currentFwVersion);
					$eqLogic->setConfiguration('characteristics', $device->characteristics);
					$eqLogic->setEqLogicConfig();
					$eqLogic->syncData();
				}

				$mobileDevices = tado::getApiHandler($user)->listMobileDevices($home_id);
				foreach ($mobileDevices as $mobileDevice) {
					$eqLogic = eqLogic::byLogicalId($home_id . "_MB" . $mobileDevice->id, 'tado');
					if (!is_object($eqLogic)) {
						$eqLogic = new tado();
						$eqLogic->setIsVisible(1);
						$eqLogic->setIsEnable(1);
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
					$eqLogic->setConfiguration('deviceMetadata', $mobileDevice->deviceMetadata);
					$eqLogic->setEqLogicConfig();
					$eqLogic->syncData();
				}
			}
		}
	}

	public static function byUser($_tado_user = '', $_onlyEnable = false) {
		$return = array();
		foreach ((eqLogic::byType('tado', $_onlyEnable)) as $eqLogic) {
			if ($eqLogic->getConfiguration('user') == $_tado_user) {
				$return[] = $eqLogic;
			}
		}
		return $return;
	}

	public static function cron5() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'zone') {
				$eqLogic->syncData();
			}
			if ($eqLogic->getConfiguration('eqLogicType') == 'mobileDevice' || $eqLogic->getConfiguration('eqLogicType') == 'home') {
				$eqLogic->syncData();
			}
		}
	}

	public static function cron15() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'weather' || $eqLogic->getConfiguration('eqLogicType') == 'device') {
				$eqLogic->syncData();
			}
		}
	}

	/*     * *********************Méthodes d'instance************************* */
	public function getHome() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'home' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$home = $eqLogic;
			}
		}
		return $home;
	}

	public function getZones() {
		$zones = array();
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'zone' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$zones[] = $eqLogic;
			}
		}
		return $zones;
	}

	public function getMobileDevices() {
		$mobileDevices = array();
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'mobileDevice' && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$mobileDevices[] = $eqLogic;
			}
		}
		return $mobileDevices;
	}

	public function getDevices() {
		$devices = array();
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
			if (($eqLogic->getConfiguration('eqLogicType') == 'device') && $this->getConfiguration('homeId') == $eqLogic->getConfiguration('homeId')) {
				$devices[] = $eqLogic;
			}
		}
		return $devices;
	}

	public function getWeather() {
		foreach ((eqLogic::byType('tado')) as $eqLogic) {
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
				break;
			case 'weather':
				$weather = tado::getApiHandler($this->getConfiguration('user'))->getHomeWeather($home_id);
				$this->checkAndUpdateCmd('solarIntensity', $weather->solarIntensity->percentage, date('Y-m-d H:i:s', strtotime($weather->solarIntensity->timestamp)));
				$this->checkAndUpdateCmd('temperature', $weather->outsideTemperature->celsius, date('Y-m-d H:i:s', strtotime($weather->outsideTemperature->timestamp)));
				$this->checkAndUpdateCmd('weatherState', $weather->weatherState->value, date('Y-m-d H:i:s', strtotime($weather->weatherState->timestamp)));
				break;
			case 'zone':
				$zoneState = tado::getApiHandler($this->getConfiguration('user'))->getZoneState($home_id, $this->getConfiguration('zoneId'));
				$zoneDetails = tado::getApiHandler($this->getConfiguration('user'))->getZoneDetails($home_id, $this->getConfiguration('zoneId'));
				$this->syncOpenWindowState($zoneDetails);
				log::add('tado', 'info', __METHOD__ . ' - zoneState : ' . json_encode($zoneState));
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
				$this->checkAndUpdateCmd('atHome', $mobileDevice->location->atHome);
				$this->checkAndUpdateCmd('bearingFromHome', $mobileDevice->location->bearingFromHome->degrees);
				$this->checkAndUpdateCmd('relativeDistanceFromHomeFence', $mobileDevice->location->relativeDistanceFromHomeFence);
				break;
			case ('device'):
				$device = tado::getApiHandler($this->getConfiguration('user'))->getDevice($this->getConfiguration('deviceId'));
				$this->checkAndUpdateCmd('connectionState', $device->connectionState->value, date('Y-m-d H:i:s', strtotime($device->connectionState->timestamp)));
				if (isset($device->batteryState)) {
					$this->batteryStatus(($device->batteryState == 'NORMAL') ? 100 : 20);
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

	public function setEqLogicConfig() {
		$this->setConfiguration('eqLogicType', tado::getGConfig($this->getConfiguration('eqType') . '::eqLogicType'));
		foreach ((tado::getGConfig($this->getConfiguration('eqType') . '::cmd')) as $command) {
			$cmdConfig = tado::getGConfig('commands::' . $command);
			$cmd = $this->getCmd(null, $command);
			if (!is_object($cmd)) {
				$cmd = new tadoCmd();
				$cmd->setEqLogic_id($this->getId());
			} else {
				$cmdConfig['name'] = $cmd->getName();
			}
			utils::a2o($cmd, $cmdConfig);
			if (isset($cmdConfig['value'])) {
				$value = $this->getCmd(null, $cmdConfig['value']);
				if (is_object($value)) {
					$cmd->setValue($value->getId());
				}
			}
			$cmd->save();
		}
		$this->save();
	}

	public function postSave() {
		if ($this->getIsEnable() == 1 && $this->getConfiguration('eqLogicType') == 'zone') {
			$eqLogic = eqLogic::byId($this->id);
			$capabilities = $eqLogic->getConfiguration('capabilities');
			if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
				$coolCmdState = $eqLogic->getCmd(null, 'coolCmdState');
				$cool = $eqLogic->getCmd(null, 'cool');
				if (is_object($coolCmdState) && is_object($cool)) {
					$capabilities = ($coolCmdState->execCmd() == 1) ? $capabilities['COOL'] : $capabilities['HEAT'];
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
		}
	}
	/*     * **********************Getteur Setteur*************************** */
}

class tadoCmd extends cmd {
	/*     * *************************Attributs****************************** */


	/*     * ***********************Methode static*************************** */


	/*     * *********************Methode d'instance************************* */

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
			if ($eqLogic->getConfiguration('eqType') != "HOT_WATER") {
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
			$setting = array('type' => $eqLogic->getConfiguration('eqType'), 'power' => 'OFF');
		} elseif ($this->getLogicalId() == 'rawSet') {
			$setting = json_decode('{' . $_options['message'] . '}', true);
			$setting['type'] = $eqLogic->getConfiguration('eqType');
		} else {
			$setting = array(
				'type' => $eqLogic->getConfiguration('eqType'),
				'power' => 'ON',
				'temperature' => array(
					'celsius' => $eqLogic->getCmd('info', 'targetTemperature')->execCmd()
				)
			);
			if ($eqLogic->getConfiguration('eqType') == 'AIR_CONDITIONING') {
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
			if ($setting['mode'] == 'DRY') {
				unset($setting['fanLevel']);
			} elseif ($setting['mode'] == 'FAN') {
				unset($setting['temperature']);
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
		log::add('tado', 'debug', 'Payload : ' . json_encode($payload));
		tado::getApiHandler($eqLogic->getConfiguration('user'))->updateZoneOverlay(json_encode($payload), $eqLogic->getConfiguration('homeId'), $eqLogic->getConfiguration('zoneId'));
		$eqLogic->syncData();
	}

	/*     * **********************Getteur Setteur*************************** */
}
