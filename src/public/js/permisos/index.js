var nombreDeTabla = '#PermisosTableContainer';

$(document).ready(function () {

	$(nombreDeTabla).jtable({
		title: '',
        jqueryuiTheme: true,
        pageSize: 20,
		paging: true,
		sorting: false,
		pageSizeChangeArea: false,
		columnSelectable: false,
		columnResizable: false,
		gotoPageArea: false,
		defaultDateFormat: 'dd-mm-yy', 
		openChildAsAccordion: true,
		addRecordButton: $(".boton-index-nuevo"),
		actions: {
			listAction: '/api/permisos/getData/list?_token=' + tokenValList,
			createAction: '/api/permisos/getData/create?_token=' + tokenValCreate,
			updateAction: '/api/permisos/getData/update?_token=' + tokenValUpdate,
			deleteAction: '/api/permisos/getData/delete?_token=' + tokenValDelete
		},
		fields: {
			id: {
				key: true,
				create: false,
				edit: false,
				list: false
			},
			UsuarioId: {
				title: 'Usuario',
				width: '15%',
				options: '/api/permisos/getOption/users?_token=' + tokenValList
			},
			ExamenId: {
				title: 'Examen',
				width: '15%',
				options: '/api/permisos/getOption/exams?_token=' + tokenValList
			},
			FechaDesde: {
				title: 'Desde',
				width: '5%',
				type: 'date'
			},
			FechaHasta: {
				title: 'Hasta',
				width: '5%',
				type: 'date'
			},
			Activo: {
				title: 'Activo',
				type: 'checkbox',
				create: false,
				values: { '0': 'No', '1': 'Si' },
				defaultValue: '1',
				width: '1%'
			},
            Cantidad: {
                title: 'Cantidad',
                width: '1%',
                defaultValue: '1',
            },
			Editar: {
				title: 'Editar',
				type: 'checkbox',
				values: { '0': 'No', '1': 'Si' },
				defaultValue: '0',
				width: '1%'
			},
			Notificar: {
				create: true,
				edit: true,
				list: false,
				title: 'Notificar',
				type: 'checkbox',
				values: { '0': 'No', '1': 'Si' },
				defaultValue: '0',
				width: '1%'
			}
		}
	});

	$(nombreDeTabla).jtable('load');

    initComboBox();
});

function initComboBox() {
    $("#txtUsuario").on('change', function change() {
        $(nombreDeTabla).jtable('load', {
            ExamenId: $("#txtExamen").val(),
            UsuarioId: $("#txtUsuario").val()
        });
    });
    $("#txtExamen").on('change', function change() {
        $(nombreDeTabla).jtable('load', {
            ExamenId: $("#txtExamen").val(),
            UsuarioId: $("#txtUsuario").val()
        });
    });
}
function isBlank(str) {
	return (!str || /^\s*$/.test(str));
}


