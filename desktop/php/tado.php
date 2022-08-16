<?php
if (!isConnect('admin')) {
	throw new Exception('{{401 - Accès non autorisé}}');
}
$plugin = plugin::byId('tado');
sendVarToJS('eqType', $plugin->getId());
$eqLogics = eqLogic::byType($plugin->getId());
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
		if (count($eqLogics) == 0) {
			echo '<br><div class="text-center" style="font-size:1.2em;font-weight:bold;">{{Aucun équipement Tado trouvé, cliquer sur "Synchroniser" pour commencer}}</div>';
		} else {
			echo '<div class="input-group" style="margin:5px;">';
			echo '<input class="form-control roundedLeft" placeholder="{{Rechercher}}" id="in_searchEqlogic">';
			echo '<div class="input-group-btn">';
			echo '<a id="bt_resetSearch" class="btn" style="width:30px"><i class="fas fa-times"></i></a>';
			echo '<a class="btn roundedRight hidden" id="bt_pluginDisplayAsTable" data-coreSupport="1" data-state="0"><i class="fas fa-grip-lines"></i></a>';
			echo '</div>';
			echo '</div>';
			echo '<div class="eqLogicThumbnailContainer">';
			foreach ($eqLogics as $eqLogic) {
				$opacity = ($eqLogic->getIsEnable()) ? '' : 'disableCard';
				echo '<div class="eqLogicDisplayCard cursor ' . $opacity . '" data-eqLogic_id="' . $eqLogic->getId() . '">';
				if ($eqLogic->getImage() !== false) {
					echo '<img src="' . $eqLogic->getImage() . '"/>';
				} else {
					echo '<img src="' . $plugin->getPathImgIcon() . '"/>';
				}
				echo '<br>';
				echo '<span class="name">' . $eqLogic->getHumanName(true, true) . '</span>';
				echo '<span class="hiddenAsCard displayTableRight hidden">';
				echo ($eqLogic->getIsVisible() == 1) ? '<i class="fas fa-eye" title="{{Equipement visible}}"></i>' : '<i class="fas fa-eye-slash" title="{{Equipement non visible}}"></i>';
				echo '</span>';
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
				<div class="row">
					<div class="col-sm-6">
						<form class="form-horizontal">
							<fieldset>
								<legend><i class="fas fa-home"></i> {{Général}}</legend>
								<div id="generalConfig">
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
								<div class="eqLogicType home">
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
								<div class="eqLogicType zone">
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
					<div class="col-sm-6">
						<form class="form-horizontal">
							<fieldset>
								<legend><i class="fas fa-info-circle"></i> {{Informations}}</legend>
								<div class="form-group">
									<label class="col-sm-3"></label>
									<div class="col-sm-7 text-center">
										<img name="icon_visu" src="<?= $plugin->getPathImgIcon(); ?>" style="max-width:160px;" id="img_device" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Equipement}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="eqLogicType"></span>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label">{{Type}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="device"></span>
									</div>
								</div>
								<div class="form-group eqLogicType device zone weather">
									<label class="col-sm-3 control-label">{{Home ID}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="homeId"></span>
									</div>
								</div>
								<div class="form-group eqLogicType device">
									<label class="col-sm-3 control-label">{{ID}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="deviceId"></span>
									</div>
								</div>
								<div class="form-group eqLogicType zone">
									<label class="col-sm-3 control-label">{{Zone ID}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="zoneId"></span>
									</div>
								</div>
								<div class="form-group eqLogicType device">
									<label class="col-sm-3 control-label">{{Firmware}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="currentFwVersion"></span>
									</div>
								</div>
								<div class="form-group eqLogicType mobileDevice">
									<label class="col-sm-3 control-label">{{Platforme}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="deviceMetadata" data-l3key="platform"></span>
									</div>
								</div>
								<div class="form-group eqLogicType mobileDevice">
									<label class="col-sm-3 control-label">{{OS version}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="deviceMetadata" data-l3key="osVersion"></span>
									</div>
								</div>
								<div class="form-group eqLogicType mobileDevice">
									<label class="col-sm-3 control-label">{{Modèle}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="deviceMetadata" data-l3key="model"></span>
									</div>
								</div>
								<div class="form-group eqLogicType zone">
									<label class="col-sm-3 control-label">{{Détection fenetre ouverte}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="openWindowDetection" data-l3key="supported"></span>
									</div>
								</div>
								<div class="form-group eqLogicType zone">
									<label class="col-sm-3 control-label">{{Timeout fenetre ouverte}}</label>
									<div class="col-sm-6">
										<span class="eqLogicAttr label label-info" style="font-size:1em;" data-l1key="configuration" data-l2key="openWindowTimeout"></span>
									</div>
								</div>
							</fieldset>
						</form>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="commandtab">
				<table id="table_cmd" class="table table-bordered table-condensed">
					<thead>
						<tr>
							<th>{{Id}}</th>
							<th>{{Nom}}</th>
							<th>{{Type}}</th>
							<th>{{Logical ID}}</th>
							<th>{{Options}}</th>
							<th>{{Paramètres}}</th>
							<th>{{Etat}}</th>
							<th>{{Action}}</th>
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
