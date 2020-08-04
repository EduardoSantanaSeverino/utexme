$(document).ready(function () {

    // $('.botonPop').click(function () {

    //     var divRoot = document.getElementsByTagName("body")[0].getAttribute('data-root');
    //     var urlPath = '/obras/obrasJson';
    //     Redirect(divRoot + urlPath);

    // });

});

function isBlank(str) {
    return (!str || /^\s*$/.test(str));
}

function isEmpty(str) {
    return (!str || 0 === str.length);
}

function abrirPopUp(){
    var urlPath = '/obrasEtapas/create';
    cargarModal(urlPath);
}

function cargarModal(url) {

    var divRoot = ''; //document.getElementsByTagName("body")[0].getAttribute('data-root');
    var $modal = $('#myModalPopUp1');
    $.get(divRoot + url)
        .done(function (html) {
            $modal.find('.modal-body').html(html);
            var texto = $modal.find('.panel-heading').text();
            $modal.find('.modal-title').html(texto);
            $modal.find('.panel-heading').hide();
            $modal.find('.panel').removeClass("panel");
            $modal.find('.panel-body').removeClass("panel-body");
            $modal.find('.panel-default').removeClass("panel-default");
            $modal.find('.container').removeClass("container");
            $modal.find('.col-md-10.col-md-offset-1').removeClass("col-md-offset-1").removeClass('col-md-10');
            $modal.find('.col-sm-12')
                .addClass("modal-footer")
                .removeClass("form-group")
                .append('<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>');
            $modal.find('a.btn-default').hide();
            $modal.modal('show');
        });
}

function cargarModalHTML(html, titulo) {
    var $modal = $('#page-modal');

    if (!$modal.hasClass('hide')) {
        $modal.modal('hide');
    }

    $modal.find('.modal-body').html(html);
    $modal.find('.modal-title').html(titulo);
    $modal.modal('show');

}

function GotoUrl(nombreDelBoton) {

    $(nombreDelBoton).click(function () {

        var qt = 0;
        if (nombreDelBoton == "#BuscarCedula") { qt = 1; }
        if (nombreDelBoton == "#BuscarSolicitud") { qt = 2; }
        if (nombreDelBoton == "#BuscarReferencia") { qt = 3; }

        var div = document.getElementById(nombreDelBoton.replace('#', ''));
        var divRoot = document.getElementsByTagName("body")[0].getAttribute('data-root');
        var urlPath = 'solicitudes?q=' + $("#q").val();

        if (qt != 0) {
            urlPath += "&qt=" + qt;
        }

        Redirect(divRoot + urlPath);

    });
}

function Redirect(url) {
    var ua = navigator.userAgent.toLowerCase(),
        isIE = ua.indexOf('msie') !== -1,
        version = parseInt(ua.substr(4, 2), 10);

    // Internet Explorer 8 and lower
    if (isIE && version < 9) {
        var link = document.createElement('a');
        link.href = url;
        document.body.appendChild(link);
        link.click();
    }

        // All other browsers
    else { window.location.href = url; }
}
