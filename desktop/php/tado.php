<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('tado');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
$homes = array();
$zones = array();
$mobileDevices = array();
$smartThermostats = array();
$smartAircons = array();
$smartValves = array();
$temperatureSensors = array();
$weathers = array();
$devices = array();
foreach ($eqLogics as $eqLogic) {
	if ($eqLogic->getConfiguration('eqLogicType') == 'home') {
		$homes[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'zone') {
		$zones[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'mobileDevice') {
		$mobileDevices[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'smartThermostat') {
		$smartThermostats[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'smartAircon') {
		$smartAircons[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'smartValve') {
		$smartValves[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'temperatureSensor') {
		$temperatureSensors[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'device') {
		$devices[] = $eqLogic;
	} elseif ($eqLogic->getConfiguration('eqLogicType') == 'weather') {
		$weathers[] = $eqLogic;
	}
}
?>

<div class="row row-overflow">
	<div class="col-xs-12 eqLogicThumbnailDisplay">
		<legend><i class="fas fa-cog"></i> {{Gestion}}</legend>
		<div class="eqLogicThumbnailContainer">
			<div class="cursor eqLogicAction logoSecondary" data-action="gotoPluginConf">
				<i class="fas fa-wrench"></i>
				<br>
				<span>{{Configuration}}</span>
			</div>
			<div class="cursor logoSecondary" id="bt_syncEqLogicWithTado">
				<i class="fas fa-sync-alt"></i>
				<br />
				<span>{{Synchroniser}}</span>
			</div>
		</div>
		<?php
		if (!empty($homes)) {
			echo '<legend><i class="fas fa-table"></i> {{Homes}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($homes as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<br>';
				echo '<i class="fas fa-home"></i>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($zones)) {
			echo '<legend><i class="fas fa-table"></i> {{Zones}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($zones as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($mobileDevices)) {
			echo '<legend><i class="fas fa-table"></i> {{Equipements mobiles}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($mobileDevices as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($smartThermostats)) {
			echo '<legend><i class="fas fa-table"></i> {{Thermostats intelligent}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($smartThermostats as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($smartAircons)) {
			echo '<legend><i class="fas fa-table"></i> {{Climatisations intelligentes}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($smartAircons as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($smartValves)) {
			echo '<legend><i class="fas fa-table"></i> {{Vannes intelligentes}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($smartValves as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($temperatureSensors)) {
			echo '<legend><i class="fas fa-table"></i> {{Capteurs de température}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($temperatureSensors as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($devices)) {
			echo '<legend><i class="fas fa-table"></i> {{Equipements}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($devices as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		if (!empty($weathers)) {
			echo '<legend><i class="fas fa-table"></i> {{Météo}}</legend>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($weathers as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '</div>';
			}
			echo '</div>';
		}
		?>
	</div>

	<div class="col-xs-12 eqLogic" style="display: none;">
		<div class="input-group pull-right" style="display:inline-flex">
			<span class="input-group-btn">
				<a class="btn btn-default btn-sm eqLogicAction roundedLeft" data-action="configure"><i class="fa fa-cogs"></i> {{Configuration avancée}}</a><a class="btn btn-default btn-sm eqLogicAction" data-action="copy"><i class="fas fa-copy"></i> {{Dupliquer}}</a><a class="btn btn-sm btn-success eqLogicAction" data-action="save"><i class="fas fa-check-circle"></i> {{Sauvegarder}}</a><a class="btn btn-danger btn-sm eqLogicAction roundedRight" data-action="remove"><i class="fas fa-minus-circle"></i> {{Supprimer}}</a>
			</span>
		</div>
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation"><a href="#" class="eqLogicAction" aria-controls="home" role="tab" data-toggle="tab" data-action="returnToThumbnailDisplay"><i class="fa fa-arrow-circle-left"></i></a></li>
			<li role="presentation" class="active"><a href="#eqlogictab" aria-controls="home" role="tab" data-toggle="tab"><i class="fas fa-tachometer-alt"></i> {{Equipement}}</a></li>
			<li role="presentation"><a href="#commandtab" aria-controls="profile" role="tab" data-toggle="tab"><i class="fa fa-list-alt"></i> {{Commandes}}</a></li>
		</ul>
		<div class="tab-content" style="height:calc(100% - 50px);overflow:auto;overflow-x: hidden;">
			<div role="tabpanel" class="tab-pane active" id="eqlogictab">
				<br />
				<form class="form-horizontal">
					<fieldset>
						<div id="generalConfig">
							<legend><i class="fas fa-tachometer-alt"></i> {{Général}}</legend>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Nom de l'équipement}}</label>
								<div class="col-sm-3">
									<input type="text" class="eqLogicAttr form-control" data-l1key="id" style="display : none;" />
									<input type="text" class="eqLogicAttr form-control" data-l1key="name" placeholder="{{Nom de l'équipement template}}" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Objet parent}}</label>
								<div class="col-sm-3">
									<select id="sel_object" class="eqLogicAttr form-control" data-l1key="object_id">
										<option value="">{{Aucun}}</option>
										<?php
										foreach (jeeObject::all() as $object) {
											echo '<option value="' . $object->getId() . '">' . $object->getName() . '</option>';
										}
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">{{Catégorie}}</label>
								<div class="col-sm-9">
									<?php
									foreach (jeedom::getConfiguration('eqLogic:category') as $key => $value) {
										echo '<label class="checkbox-inline">';
										echo '<input type="checkbox" class="eqLogicAttr" data-l1key="category" data-l2key="' . $key . '" />' . $value['name'];
										echo '</label>';
									}
									?>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label"></label>
								<div class="col-sm-9">
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isEnable" checked />{{Activer}}</label>
									<label class="checkbox-inline"><input type="checkbox" class="eqLogicAttr" data-l1key="isVisible" checked />{{Visible}}</label>
								</div>
							</div>
						</div>
						<div id="homeConfig">
							<div id="presenceConfig">
								<legend><i class="fas fa-running"></i> {{Présence}}</legend>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Auto assist présence}}</label>
									<div class="col-sm-3">
										<select id="sel_openWindowDetectionAssist" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="presenceModeAssist">
											<option value="no">{{Désactivé}}</option>
											<option value="yes">{{Activé}}</option>
										</select>
									</div>
								</div>
							</div>
						</div>
						<div id="zoneConfig">
							<div id="overlayTimeoutConfig">
								<legend><i class="fas fa-clock"></i> {{Timeout}}</legend>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Changement de consigne à partir de Jeedom}}</label>
									<div class="col-sm-3">
										<select id="sel_overlayTimeoutSelection" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="overlayTimeoutSelection">
											<option value="NEXT_TIME_BLOCK">{{Jusqu'au prochain changement automatique}}</option>
											<option value="TIMER">{{Minuterie}}</option>
											<option value="MANUAL">{{Jusqu'à l'arrêt par l'utilisateur}}</option>
										</select>
									</div>
									<div class="col-sm-3" id="in_overlayTimeout">
										<input type="text" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="overlayTimeout" placeholder="{{Timeout (minutes)}}" />
									</div>
								</div>
							</div>
							<div id="openWindowConfig">
								<legend><i class="fas fa-door-open"></i> {{Fenêtres}}</legend>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Auto assist fenêtres ouvertes}}</label>
									<div class="col-sm-3">
										<select id="sel_openWindowDetectionAssist" class="eqLogicAttr form-control" data-l1key="configuration" data-l2key="openWindowDetectionAssist">
											<option value="no">{{Désactivé}}</option>
											<option value="yes">{{Activé}}</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th style="width: 150px;"> ID</th>
							<th style="width: 230px;">{{Nom}}</th>
							<th>{{Paramètres}}</th>
							<th style="width: 300px;">{{Options}}</th>
							<th style="width: 150px;">{{Action}}</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php include_file('desktop', 'tado', 'js', 'tado'); ?>
<?php include_file('core', 'plugin.template', 'js'); ?>