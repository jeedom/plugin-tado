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

try {
	require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';
	include_file('core', 'authentification', 'php');

	if (!isConnect('admin')) {
		throw new Exception(__('401 - Accès non autorisé', __FILE__));
	}

	ajax::init();

	if (init('action') == 'getZones') {
		if (init('object_id') == '') {
			$_GET['object_id'] = $_SESSION['user']->getOptions('defaultDashboardObject');
		}
		$object = jeeObject::byId(init('object_id'));
		if (!is_object($object)) {
			$object = jeeObject::rootObject();
		}
		if (!is_object($object)) {
			throw new Exception(__('Aucun objet racine trouvé', __FILE__));
		}

		$zones = array();
		$eqLogics = $object->getEqLogic(true, false, 'tado');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'zone') {
				$zones[] = $eqLogic;
			}
		}
		$eqLogics = eqLogic::byType('tado');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('eqLogicType') == 'weather') {
				$weather = $eqLogic;
			}
		}
		if (count($zones) == 0) {
			$allObject = jeeObject::buildTree();
			foreach ($allObject as $object_sel) {
				$zones = array();
				$eqLogics = $object->getEqLogic(true, false, 'tado');
				foreach ($eqLogics as $eqLogic) {
					if ($eqLogic->getConfiguration('eqLogicType') == 'zone') {
						$zones[] = $eqLogic;
					}
				}
				if (count($zones) > 0) {
					$object = $object_sel;
					break;
				}
			}
		}
		$return = array('object' => utils::o2a($object));

		$date = array(
			'start' => init('dateStart'),
			'end' => init('dateEnd'),
		);

		if ($date['start'] == '') {
			$date['start'] = date('Y-m-d', strtotime('-1 months ' . date('Y-m-d')));
		}
		if ($date['end'] == '') {
			$date['end'] = date('Y-m-d', strtotime('+1 days ' . date('Y-m-d')));
		}
		$return['date'] = $date;
		foreach ($zones as $eqLogic) {
			$return['eqLogics'][] = array('eqLogic' => utils::o2a($eqLogic), 'weather' => utils::o2a($eqLogic->getWeather()), 'html' => $eqLogic->toHtml(init('version')), 'runtimeByDay' => array_values($eqLogic->runtimeByDay($date['start'], $date['end'])));
		}
		ajax::success($return);
	}

	if (init('action') == 'syncEqLogicWithTado') {
		tado::syncEqLogicWithTado();
		ajax::success();
	}

	if (init('action') == 'remove_account') {
		$user = init('user');
		$conf_tokens = config::byKey('tadoTokens', 'tado');
		unset($conf_tokens[$user]);
		config::save('tadoTokens', json_encode($conf_tokens), 'tado');
		$eqLogics = eqLogic::byType('tado');
		foreach ($eqLogics as $eqLogic) {
			if ($eqLogic->getConfiguration('user') == $user) {
				$eqLogic->setIsEnable(0);
				$eqLogic->save();
			}
		}
		ajax::success();
	}

	if (init('action') == 'authorize') {
		if (!class_exists('TadoApiHandler')) {
			require_once __DIR__ . '/../../3rdparty/TadoApiHandler.class.php';
		}
		if (init('user') != '' && init('password') != '') {
			$conf_tokens = config::byKey('tadoTokens', 'tado');
			$alreadyRegistered = false;
			foreach ($conf_tokens as $user => $conf_token) {
				if (init('user') == $user) {
					$alreadyRegistered = true;
				}
			}
			$TadoApiHandler = new TadoApiHandler(init('user'));
			if ($TadoApiHandler->authorize(init('password'))) {
				$eqLogics = tado::byUser(init('user'));
				foreach ($eqLogics as $eqLogic) {
					$eqLogic->setIsEnable(1);
					$eqLogic->save();
				}
				ajax::success(array('user' => init('user'), 'alreadyRegistered' => $alreadyRegistered));
			} else {
				ajax::error(__('Connexion échouée'));
			}
		} else {
			ajax::error(__('Utilisateur ou mot de passe manquant'));
		}
	}


	throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
	/*     * *********Catch exeption*************** */
} catch (Exception $e) {
	ajax::error(displayException($e), $e->getCode());
}
