
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

$('#bt_syncEqLogicWithTado').off('click').on('click', function () {
  syncEqLogicWithTado();
});
$("#table_cmd").sortable({axis: "y", cursor: "move", items: ".cmd", placeholder: "ui-state-highlight", tolerance: "intersect", forcePlaceholderSize: true});

function syncEqLogicWithTado() {
  $.ajax({
    type: "POST",
    url: "plugins/tado/core/ajax/tado.ajax.php",
    data: {
      action: "syncEqLogicWithTado",
    },
    dataType: 'json',
    error: function (request, status, error) {
      handleAjaxError(request, status, error);
    },
    success: function (data) {
      if (data.state != 'ok') {
        $('#div_alert').showAlert({message: data.result, level: 'danger'});
        return;
      }
      window.location.reload();
    }
  });
}

$(".eqLogic").off('click','.listCmdInfo').on('click','.listCmdInfo', function () {
  var el = $(this).closest('.form-group').find('.eqLogicAttr');
  jeedom.cmd.getSelectModal({cmd: {type: 'info'}}, function (result) {
    if (el.attr('data-concat') == 1) {
      el.atCaret('insert', result.human);
    } else {
      el.value(result.human);
    }
  });
});

/*
 * Fonction pour le traitement de l'affichage selon le type d'équipement
 */
$( ".eqLogicAttr[data-l1key=id]" ).change(function() {
	if ( $( ".eqLogicAttr[data-l1key=id]" ).value() != "" ) {
		jeedom.eqLogic.byId({
		  	id: $( ".eqLogicAttr[data-l1key=id]" ).value(),
		  	noCache: true,
		  	error: function (error) {
				$('#div_alert').showAlert({message: error.message, level: 'danger'});
		  	},
		  	success: function (_eqLogic ) {
				//console.log(_eqLogic);
				if ( _eqLogic.configuration.eqLogicType == 'home' ) {
					$( "#homeConfig" ).show();
				} else {
					$( "#homeConfig" ).hide();
				}
				if ( _eqLogic.configuration.eqLogicType == 'zone' ) {
					$( "#zoneConfig" ).show();
					if ( _eqLogic.configuration.openWindowDetection.supported ) {
						$( "#openWindowConfig" ).show();
					} else {
						$( "#openWindowConfig" ).hide();
					}
				} else {
					$( "#zoneConfig" ).hide();
				}				
		  	}
		})
	}
});

$('#sel_overlayTimeoutSelection').change(function(){
  var text = $("#sel_overlayTimeoutSelection").val();
  if (text == 'TIMER') {
    $('#in_overlayTimeout').show();
  } else {
    $('#in_overlayTimeout').hide();
  }
});
/*
 * Fonction pour l'ajout de commande, appellé automatiquement par plugin.template
 */
function addCmdToTable(_cmd) {
    if (!isset(_cmd)) {
        var _cmd = {configuration: {}};
    }
    if (!isset(_cmd.configuration)) {
        _cmd.configuration = {};
    }
	if (init(_cmd.type) == 'info') {
		var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
		tr += '<td>';
		tr += '<span class="cmdAttr" data-l1key="id"></span>';
		tr += '</td>';
		tr += '<td>';
		tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
		tr += '</td>';
		tr += '<td>';
		tr += '</td>';
    	tr += '<td>';
		if (_cmd.subType == 'numeric') {
    		tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="minValue" placeholder="{{Min}}" title="{{Min}}" style="width:30%;display:inline-block;">';
    		tr += '<input class="tooltips cmdAttr form-control input-sm" data-l1key="configuration" data-l2key="maxValue" placeholder="{{Max}}" title="{{Max}}" style="width:30%;display:inline-block;">';
    		tr += '<input class="cmdAttr form-control input-sm" data-l1key="unite" placeholder="Unité" title="{{Unité}}" style="width:30%;display:inline-block;margin-right:5px;">';
		}
    		tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" checked/>{{Afficher}}</label></span> ';
    		tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isHistorized" checked/>{{Historiser}}</label></span> ';
		if (_cmd.subType == 'binary') {
    		tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr" data-l1key="display" data-l2key="invertBinary"/>{{Inverser}}</label></span> ';
 		}
    	tr += '</td>';
		tr += '<td>';
		if (is_numeric(_cmd.id)) {
			tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
			tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
		}
		tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
		tr += '</td>';
		tr += '</tr>';
		$('#table_cmd tbody').append(tr);
		$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
		if (isset(_cmd.type)) {
			$('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
		}
		jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
    }
    if (init(_cmd.type) == 'action') {
		var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
		tr += '<td>';
		tr += '<span class="cmdAttr" data-l1key="id"></span>';
		tr += '</td>';
		tr += '<td>';
    	tr += '<div class="row">';
		tr += '<div class="col-sm-6">';
		tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icône</a>';
		tr += '<span class="cmdAttr" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
		tr += '</div>';
		tr += '<div class="col-sm-6">';
		tr += '<input class="cmdAttr form-control input-sm" data-l1key="name">';
		tr += '</div>';
    	tr += '</div>';
		tr += '</td>';
		tr += '<td>';
		tr += '</td>';
		tr += '<td>';
		tr += '<span><label class="checkbox-inline"><input type="checkbox" class="cmdAttr checkbox-inline" data-l1key="isVisible" />{{Afficher}}</label><br/></span>';
		tr += '</td>';
		tr += '<td>';
		if (is_numeric(_cmd.id)) {
			tr += '<a class="btn btn-default btn-xs cmdAction" data-action="configure"><i class="fa fa-cogs"></i></a> ';
			tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
		}
		tr += '<i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i>';
		tr += '</td>';
		tr += '</tr>';
		$('#table_cmd tbody').append(tr);
		$('#table_cmd tbody tr:last').setValues(_cmd, '.cmdAttr');
		if (isset(_cmd.type)) {
			$('#table_cmd tbody tr:last .cmdAttr[data-l1key=type]').value(init(_cmd.type));
		}
		jeedom.cmd.changeType($('#table_cmd tbody tr:last'), init(_cmd.subType));
    }
}
