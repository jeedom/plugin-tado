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
			foreach ($conf_tokens as $user) {
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

	if (init('action') == 'gettado') {
		$return = array();
		$return['eqLogics'] = array();
		foreach (tado::byType('tado') as $tado) {
			if ($tado->getConfiguration('eqLogicType') != 'zone' || $tado->getConfiguration('device') == 'HOT_WATER') {
				continue;
			}
			$return['eqLogics'][] = $tado->toHtml(init('version'));
		}
		ajax::success($return);
	}


	throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
	/*     * *********Catch exeption*************** */
} catch (Exception $e) {
	ajax::error(displayException($e), $e->getCode());
}
