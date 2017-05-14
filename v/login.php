<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exchange O' Learn</title>
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/AdminLTE.css">
        <script src="./assets/js/jquery.min.js"></script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <b>Iniciar Sesión</b>
            </div>
            <div class="login-box-body">
                <div id="alerts" class='hidden'>
                    <div class="alert alert-danger alert-dismissable">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Datos erróneos, inténtelo de nuevo
                    </div>
                </div>
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" id="username" placeholder="Usuario">
                    <span class="fa fa-user form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" id="password" placeholder="Contraseña">
                    <span class="fa fa-lock form-control-feedback"></span>
                </div>
                <div class="row">
                    <div class="col-xs-4" style="float: right">
                        <button id='login' class="btn btn-primary btn-block btn-flat">Acceder</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('#login').on('click', function () {
                $.ajax({
                    method: "POST",
                    url: "post.php",

                    data: {
                        r: 'login',
                        username: $('#username').val(),
                        password: $('#password').val()
                    }
                })
                        .done(function (msg) {
                            if (msg == 1) {
                                window.location = "./";
                            } else {
                                $('#alerts').removeClass('hidden');
                            }
                        });
            });
        </script>
