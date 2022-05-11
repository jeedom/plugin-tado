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

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';


include_file('core', 'authentification', 'php');
if (!isConnect()) {
	include_file('desktop', '404', 'php');
	die();
}
?>

<form class="form-horizontal">
	<fieldset>
		<div class="form-group">
			<label class="col-lg-4 control-label">{{ID utilisateur (e-mail)}}</label>
			<div class="col-lg-2">
				<input id="TadoUser" class="form-control" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 control-label">{{Mot de passe}}</label>
			<div class="col-lg-2">
				<input id="TadoPassword" class="form-control" type="password" />
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg-4 control-label">{{Connecter le compte}}</label>
			<div class="col-lg-2">
				<a class="btn btn-success" id="bt_authorize"><i class="fas fa-lock"></i> {{Login}}</a>
			</div>
		</div>

		<div id="div_accounts">
			<?php
			$conf_tokens = config::byKey('tadoTokens', 'tado');
			foreach ($conf_tokens as $user => $conf_token) {
				echo '<div class="account">';
				echo '<div class="form-group">';
				echo '<label class="col-lg-4 control-label">{{Compte connecté}}</label>';
				echo '<div class="col-lg-3">';
				echo '<span class="span_account_name">' . $user . '</span>';
				echo '<i class="fa fa-minus-circle pull-right bt_remove_account" data-action="remove"></i>';
				echo '</div>';
				echo '</div>';
				echo '</div>';
			}
			?>
		</div>
		<div id="div_sendConfigToDEV">
		</div>
	</fieldset>
</form>

<?php

if (file_exists(dirname(__FILE__) . '/../../../dev/tadoDev.php')) {
	require_once dirname(__FILE__) . '/../../../dev/tadoDev.php';
}
?>

<script>
	$("body").off('click', '.bt_remove_account').on('click', '.bt_remove_account', function() {
		var divToSuppress = $(this).parent().parent().parent();
		var user = divToSuppress.find('.span_account_name').text();
		if (confirm('{{Vous etes sur le point de supprimer le compte }}' + user + '\n{{Les équipements correspondants seront désactivés sans être supprimés.}}\n{{Voulez vous continuer?}}')) {
			$.ajax({
				type: "POST",
				url: "plugins/tado/core/ajax/tado.ajax.php",
				data: {
					action: "remove_account",
					user: user
				},
				dataType: 'json',
				error: function(request, status, error) {
					handleAjaxError(request, status, error);
				},
				success: function(data) {
					if (data.state != 'ok') {
						$('#div_alert').showAlert({
							message: data.result,
							level: 'danger'
						});
						return;
					}
					divToSuppress.remove();
					$('#div_alert').showAlert({
						message: '{{Suppression réussie}}',
						level: 'success'
					});
				}
			});
		}
	});
	$('#bt_authorize').on('click', function() {
		//savePluginConfig();
		$.ajax({
			type: "POST",
			url: "plugins/tado/core/ajax/tado.ajax.php",
			data: {
				action: "authorize",
				user: $('#TadoUser').value(),
				password: $('#TadoPassword').value(),
			},
			dataType: 'json',
			error: function(request, status, error) {
				handleAjaxError(request, status, error);
			},
			success: function(data) {
				if (data.state != 'ok') {
					$('#div_alert').showAlert({
						message: data.result,
						level: 'danger'
					});
					return;
				}
				if (!data.result.alreadyRegistered) {
					addAccount(data.result.user);
				}
				$('#div_alert').showAlert({
					message: '{{Authorisation réussie}}',
					level: 'success'
				});
			}
		});
	});

	function addAccount(user) {
		var div = '<div class="account">';
		div += '<div class="form-group">';
		div += '<label class="col-lg-4 control-label">{{Compte connecté}}</label>';
		div += '<div class="col-lg-3">';
		div += '<span class="span_account_name">' + user + '</span>';
		div += '<i class="fa fa-minus-circle pull-right bt_remove_account" data-action="remove"></i>';
		div += '</div>';
		div += '</div>';
		div += '</div>';
		$('#div_accounts').append(div);
	}
</script>