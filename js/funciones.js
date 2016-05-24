$(document).ready(function () {
    $('#bt-ventadiaria').on('click', function () {
        var bodega = $('#cb-bodega').val();
        var desde = $('#bd-desde').val();
        var hasta = $('#bd-hasta').val();
        $('#agrega-registros').html('<div align="center"><img src="../img/cargando2.gif" width="100" /><div>');
        var url = '../controlador/VentaDiaria.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: '&bodega=' + bodega + '&desde=' + desde + '&hasta=' + hasta,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });
    
    $('#urlbase').on('select ', function () {
        var nombre = $('#nombre').val();
        var url = $('#url').val();
        $('#agrega-registros').html('<div align="center"><img src="../img/cargando2.gif" width="100" /><div>');
        var url = 'index.php';
        $.ajax({
            type: 'GET',
            url: url,
            data: 'nombre=' + nombre + '&url=' + url,
            success: function (datos) {
                $('#agrega-registros').html(datos);
            }
        });
        return false;
    });

    $("#login-form").validate({
        rules:
                {
                    password: {
                        required: true,
                    },
                    user_email: {
                        required: true,
                        email: true
                    },
                },
        messages:
                {
                    password: {
                        required: "Ingrese Contraseña"
                    },
                    user_email: "Ingrese Su Usuario",
                },
        submitHandler: submitForm
    });

    function submitForm()
    {
        var data = $("#login-form").serialize();

        $.ajax({
            type: 'POST',
            url: 'controlador/Login.php',
            data: data,
            beforeSend: function ()
            {
                $("#error").fadeOut();
                $("#btn-login").html('<span class="glyphicon glyphicon-transfer"></span> &nbsp; Procesando ...');
            },
            success: function (response)
            {
                if (response == "ok") {
                    $("#btn-login").html('<img src="img/btn-ajax-loader.gif" /> &nbsp; Igresando ...');
                    setTimeout('window.location.href = "vista/index.php"; ', 100);
                } else {

                    $("#error").fadeIn(500, function () {
                        $("#error").html('<div class="alert alert-danger">NO PASO<span class="glyphicon glyphicon-info-sign"></span> &nbsp; ' + response + ' !</div>');
                        $("#btn-login").html('<span class="glyphicon glyphicon-log-in"></span> &nbsp; Ingresar');
                    });
                }
            }
        });
        return false;
    }
   
});


