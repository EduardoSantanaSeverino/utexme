$(document).ready(function () {
	var nombreDeTabla = '#PreguntasTableContainer';
	//Prepare jTable
	$(nombreDeTabla).jtable({
		title: tituloTabla,
		jqueryuiTheme: true,
		paging: true,
		sorting: false,
		pageSizeChangeArea: false,
		columnSelectable: false,
		columnResizable: false,
		gotoPageArea: false,
		openChildAsAccordion: true,
        toolbar: {
            items: [{
                icon: '/js/jtable/themes/jqueryui/excel16.png',
                text: 'Importar Excel',
                click: function () {
                    var urlPath = '/examenes/' + ExamenId + '/importexcel';
                    cargarModal(urlPath);
                }
            }]
        },
		actions: {
			listAction: '/api/preguntas/getData/list?_token=' + tokenValList + '&ExamenId=' + ExamenId,
			createAction: function (postData) {
				var formData = getVars(postData);

				if($('#input-image').val() !== ""){
					formData.append("Imagen", $('#input-image').get(0).files[0]);
				}

				return $.Deferred(function ($dfd) {
					$.ajax({
						url: '/api/preguntas/getData/create?_token=' + tokenValCreate + '&ExamenId=' + ExamenId,
						type: 'POST',
						dataType: 'json',
						data: formData,
						processData: false, // Don't process the files
						contentType: false, // Set content type to false as jQuery will tell the server its a query string request
						success: function (data) {
							$dfd.resolve(data);
							// $(nombreDeTabla).jtable('load');
						},
						error: function () {
							$dfd.reject();
						}
					});
				});
			},
			updateAction: function (postData) {
				var formData = getVars(postData);

				if($('#input-image').val() !== ""){
					formData.append("Imagen", $('#input-image').get(0).files[0]);
				}

				return $.Deferred(function ($dfd) {
					$.ajax({
						url: '/api/preguntas/getData/update?_token=' + tokenValUpdate + '&ExamenId=' + ExamenId,
						type: 'POST',
						dataType: 'json',
						data: formData,
						processData: false, // Don't process the files
						contentType: false, // Set content type to false as jQuery will tell the server its a query string request
						success: function (data) {
							$dfd.resolve(data);
							// $(nombreDeTabla).jtable('load');
						},
						error: function () {
							$dfd.reject();
						}
					});
				});
			},
			deleteAction: '/api/preguntas/getData/delete?_token=' + tokenValDelete + '&ExamenId=' + ExamenId
		},
		fields: {
			id: {
				key: true,
				create: false,
				edit: false,
				list: false
			},
			Opciones: {
				title: '',
				listClass: 'anchoChil',
				width: '1%',
				sorting: false,
				edit: false,
				create: false,
				display: function (preguntaData) {
					//Create an image that will be used to open child table
					var $img = $('<img src="/js/jtable/themes/jqueryui/list_metro.png" title="Opciones" />');
					//Open child table when user clicks the image
					$img.click(function () {

						var estaAbierto = $(nombreDeTabla).jtable('isChildRowOpen', $img.closest('tr'));

						if (estaAbierto) {
							$(nombreDeTabla).jtable('closeChildTable', $img.closest('tr'));
						} else {
							$(nombreDeTabla).jtable('openChildTable',
											    $img.closest('tr'),
											    {
								selecting: true, //Enable selecting
								multiselect: false, //Allow multiple selecting
								selectingCheckboxes: false, //Show checkboxes on first column
								selectOnRowClick: true, //Enable this to only select using checkboxes
								tableId: 'opcionTable',
								title: 'Opciones registradas para pregunta',
								actions: {
									listAction: '/api/opciones/getData/list?_token=' + tokenValList + '&PreguntaId=' + preguntaData.record.id,
									createAction: function (postData) {
										var formData = getVars(postData);

										if($('#input-image-opcion').val() !== ""){
											formData.append("Imagen", $('#input-image-opcion').get(0).files[0]);
										}

										return $.Deferred(function ($dfd) {
											$.ajax({
												url: '/api/opciones/getData/create?_token=' + tokenValCreate + '&PreguntaId=' + preguntaData.record.id + '&ExamenId=' + ExamenId,
												type: 'POST',
												dataType: 'json',
												data: formData,
												processData: false, // Don't process the files
												contentType: false, // Set content type to false as jQuery will tell the server its a query string request
												success: function (data) {
													$dfd.resolve(data);
													// $('#table-container').jtable('load');
												},
												error: function () {
													$dfd.reject();
												}
											});
										});
									},
									updateAction: function (postData) {
										var formData = getVars(postData);

										if($('#input-image-opcion').val() !== ""){
											formData.append("Imagen", $('#input-image-opcion').get(0).files[0]);
										}

										return $.Deferred(function ($dfd) {
											$.ajax({
												url: '/api/opciones/getData/update?_token=' + tokenValUpdate + '&ExamenId=' + ExamenId,
												type: 'POST',
												dataType: 'json',
												data: formData,
												processData: false, // Don't process the files
												contentType: false, // Set content type to false as jQuery will tell the server its a query string request
												success: function (data) {
													$dfd.resolve(data);
													// $('#table-container').jtable('load');
												},
												error: function () {
													$dfd.reject();
												}
											});
										});
									},
									deleteAction: '/api/opciones/getData/delete?_token=' + tokenValDelete
								},
								fields: {
									id: {
										key: true,
										create: false,
										edit: false,
										list: false
									},
									Codigo: {
										title: 'Codigo',
										width: '1%'
									},
									Nombre: {
										title: 'Nombre',
										width: '25%'
									},
									Descripcion: {
										title: 'Descripcion',
										width: '25%'
									},
									ImagenEdit: {
										title: 'Tiene Imagen',
										type: 'checkbox',
										values: { '0': 'No', '1': 'Si' },
										defaultValue: '1',
										width: '1%',
										list: false,
										create: false,
										edit: true
									},
									Imagen: {
										title: 'Imagen',
										type: 'file',
										list: true,
										create: false,
										edit: true,
										input: function(data){
											return '<img src="' + data.record.Imagen +  '" width="200" height="200" title="' + data.record.Descripcion +  '">';
										},
										width: '1%',
										display: function (data) {
											return (isBlank(data.record.Imagen) ? 'No' : 'Si');
										}
									},
									ImagenCreate: {
										title: 'Select File',
										list: false,
										create: true,
										edit: true,
										input: function(data) {
											return '<input type ="file" id="input-image-opcion" name="Imagen" accept="image/*" />';
										}
									},
									Activo: {
										title: 'Activo',
										type: 'checkbox',
										values: { '0': 'No', '1': 'Si' },
										defaultValue: '1',
										width: '1%'
									},
									Correcto: {
										title: 'Correcto',
										type: 'checkbox',
										values: { '0': 'No', '1': 'Si' },
										defaultValue: '0',
										width: '1%'
									}
								}
							}, function (data) { //opened handler
								data.childTable.jtable('load');
							});
						}

					});
					//Return image to show on the pregunta row
					return $img;
				}
			},
			Codigo: {
				title: 'Codigo',
				width: '1%'
			},
			Nombre: {
				title: 'Nombre',
				width: '25%'
			},
			Descripcion: {
				title: 'Descripcion',
				width: '25%'
			},
			ImagenEdit: {
				title: 'Tiene Imagen',
				type: 'checkbox',
				values: { '0': 'No', '1': 'Si' },
				defaultValue: '1',
				width: '1%',
				list: false,
				create: false,
				edit: true
			},
			Imagen: {
				title: 'Imagen',
				type: 'file',
				list: true,
				create: false,
				edit: true,
				input: function(data){
					return '<img src="' + data.record.Imagen +  '" width="200" height="200" title="' + data.record.Descripcion +  '">';
				},
				display: function (data) {
					return (isBlank(data.record.Imagen) ? 'No' : 'Si');
				},
				width: '1%'
			},
			ImagenCreate: {
				title: 'Select File',
				list: false,
				create: true,
				edit: true,
				input: function(data) {
					return '<input type ="file" id="input-image" name="Imagen" accept="image/*" />';
				}
			},
			Activo: {
				title: 'Activo',
				type: 'checkbox',
				values: { '0': 'No', '1': 'Si' },
				defaultValue: '1',
				width: '1%'
			}
		}
	});

	$(nombreDeTabla).jtable('load');

	// Read a page's GET URL variables and return them as an associative array.
	function getVars(url)
	{
		var formData = new FormData();
		var split;
		$.each(url.split("&"), function(key, value) {
			split = value.split("=");
			formData.append(split[0], decodeURIComponent(split[1].replace(/\+/g, " ")));
		});

		return formData;
	}

	// Variable to store your files
	var files;

	$( document ).delegate('#input-image','change', prepareUpload);

	// Grab the files and set them to our variable
	function prepareUpload(event)
	{
		files = event.target.files;
	}

	$(document).on('change', '#Edit-ImagenEdit', function() {
		if($(this).is(':checked') == true){
			$(".jtable-custom-input").prev().show();;
			$(".jtable-custom-input").show();
		}
		else{
			$(".jtable-custom-input").prev().hide();;
			$(".jtable-custom-input").hide();
		}
	});

});

function isBlank(str) {
	return (!str || /^\s*$/.test(str));
}


