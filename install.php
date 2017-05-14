<?php
if (!empty($_POST)) {

    try {
        $conexion = new PDO($_POST['type'] . ":dbname=" . $_POST['database'] . ";host=" . $_POST['address'], $_POST['db_username'], $_POST['db_password']);
        $conexion->query("SET NAMES 'utf8'");
        

        if(isset($_POST['usr_username']) 
                && $_POST['usr_username'] != ''
                && isset($_POST['usr_password']) 
                && $_POST['usr_password'] != '')
        {
        
            $type        = $_POST['type'];
            $database    = $_POST['database'];
            $address     = $_POST['address'];
            $db_username = $_POST['db_username'];
            $db_password = $_POST['db_password'];
            
            // TODO
            // Crear las tablas
            // Insertar usuario
            
            
            
$str = <<<EOF
<?php

/* Logger */
    define("_RUTA_LOG_", "logs/");

/* Depurar */
if(file_exists(_RUTA_LOG_."depurando")){
    define("_depurar_", true);
    if(_depurar_){
        error_reporting(E_ALL);
        ini_set("display_errors", 1);
    }
}else{
    define("_depurar_", false);
}

/* BBDD */
    define("_HOST_", "$address");
    define("_BBDD_", "$database");
    define("_USER_", "$db_username");
    define("_PASS_", "$db_password");
    define("_TIPO_", "$type");

/* Autoloader */
    spl_autoload_register(function (\$clase) {
        if(strstr(\$clase, 'c_')) {
            include 'c/' . \$clase . '.php';
        } else {
            include 'm/' . \$clase . '.php';
        }
    });
EOF;

$return = file_put_contents('./config/config.php', $str);

            // Iniciar sesion
            
        }
        
    } catch (PDOException $e) {
        $return = 'Falló la conexión: ' . $e->getMessage();
    }
    
    if(!isset($return)){
        $return = 1;
    }
    
    echo $return;
    
    exit;
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exchange O' Learn</title>
        <link rel="stylesheet" href="./assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="./assets/fonts/font-awesome.min.css">
        <link rel="stylesheet" href="./assets/css/styles.css">
        <link rel="stylesheet" href="./assets/css/chat.css">
        <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron" style="margin-top: 35px">
                <h1 style="font-size:3.5em">Instalador de Exchange O' Learn</h1>
                <p>...</p>
                <!--<p><a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a></p>-->

            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3 form-horizontal">
                    <div style="margin-bottom: 25px;">
                        <h3>Configuración de la Base de Datos</h3>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-sm-4 control-label">Host DDBB: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="address" placeholder="localhost">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="database" class="col-sm-4 control-label">Base de Datos: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="database" placeholder="eol">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="type" class="col-sm-4 control-label">Tipo de DDBB: </label>
                        <div class="col-sm-8">
                            <select id="type" class="form-control">
                                <option value="mysql">MySQL</option>
                                <option value="posgresql">PosgreSQL</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="db_username" class="col-sm-4 control-label">Usuario: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="db_username" placeholder="Username">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="db_password" class="col-sm-4 control-label">Contraseña: </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="db_password" placeholder="Contraseña">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="continuar" class="btn btn-default">Continuar</button>
                        </div>
                    </div>
                    <hr>
                    <div style="margin-bottom: 25px;">
                        <h3>Configuración del usuario root</h3>
                    </div>
                    <div class="form-group">
                        <label for="usr_username" class="col-sm-4 control-label">Usuario: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="usr_username" placeholder="Username" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr_password" class="col-sm-4 control-label">Contraseña: </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="usr_password" placeholder="Contraseña" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr_password2" class="col-sm-4 control-label">Verificar Contraseña: </label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" id="usr_password2" placeholder="Contraseña" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button id="instalar" class="btn btn-default" disabled>Instalar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function () {

                $('#continuar').on('click', function () {
                    // console.log('Auch...');
                    $.ajax({
                        method: "POST",
                        url: "install.php",

                        data: {
                            address: $('#address').val(),
                            database: $('#database').val(),
                            type: $('#type').val(),
                            db_username: $('#db_username').val(),
                            db_password: $('#db_password').val()

                        }
                    })
                            .done(function (msg) {
                                if (msg == 1) {
                                    $('#address').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#database').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#type').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#db_username').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#db_password').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#continuar').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    
                                    $('#usr_username').attr('disabled', false).focus();
                                    $('#usr_password').attr('disabled', false);
                                    $('#usr_password2').attr('disabled', false);
                                    $('#instalar').attr('disabled', false);
                                }else{
                                    $('#address').parent().parent().addClass('has-error');
                                    $('#database').parent().parent().addClass('has-error');
                                    $('#type').parent().parent().addClass('has-error');
                                    $('#db_username').parent().parent().addClass('has-error');
                                    $('#db_password').parent().parent().addClass('has-error');
                                    $('#continuar').parent().parent().addClass('has-error');
                                }
                            });
                });

                $('#instalar').on('click', function () {
                    // console.log('Auch...');
                    $.ajax({
                        method: "POST",
                        url: "install.php",

                        data: {
                            address: $('#address').val(),
                            database: $('#database').val(),
                            type: $('#type').val(),
                            db_username: $('#db_username').val(),
                            db_password: $('#db_password').val(),
                            usr_username: $('#usr_username').val(),
                            usr_password: $('#usr_password').val()

                        }
                    })
                            .done(function (msg) {
                                alert("Data Saved: " + msg);
                            });
                });

            });
        </script>