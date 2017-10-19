<?php
if (!empty($_POST)) {

    try {
        $conexion = new PDO($_POST['type'] . ":dbname=" . $_POST['database'] . ";host=" . $_POST['address'], $_POST['db_username'], $_POST['db_password']);
        $conexion->query("SET NAMES 'utf8'");

        if (isset($_POST['usr_username']) && !empty($_POST['usr_username']) && isset($_POST['usr_password']) && !empty($_POST['usr_password'])) {

            $type           = $_POST['type'];
            $database       = $_POST['database'];
            $address        = $_POST['address'];
            $db_username    = $_POST['db_username'];
            $db_password    = $_POST['db_password'];
            
            $user_username  = $_POST['usr_username'];
            $user_password  = $_POST['usr_password'];
            $user_pass_hash = hash('sha512', $user_password);
            $user_name      = $_POST['usr_name'];
            $user_surname   = $_POST['usr_surname'];

            // TODO

            // Crear las tablas
            $conexion->query("CREATE TABLE `events` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,`title` varchar(30) COLLATE utf8_unicode_ci NOT NULL,`description` tinytext COLLATE utf8_unicode_ci NOT NULL,`time` date NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            $conexion->query("CREATE TABLE `files` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,`name` tinytext COLLATE utf8_unicode_ci NOT NULL,`owner` int(11) UNSIGNED NOT NULL,`url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,`type` varchar(8) COLLATE utf8_unicode_ci NOT NULL,`time` date NOT NULL,`access` int(11) NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            $conexion->query("CREATE TABLE `mails` (`id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,`id_to` int(11) UNSIGNED NOT NULL,`id_from` int(11) UNSIGNED NOT NULL,`subject` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,`text` text COLLATE utf8mb4_unicode_ci NOT NULL,`date` datetime NOT NULL,`isread` tinyint(1) NOT NULL DEFAULT '0',`important` tinyint(1) NOT NULL DEFAULT '0',PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $conexion->query("CREATE TABLE `messages` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,`text` text COLLATE utf8mb4_unicode_ci NOT NULL,`author` int(11) UNSIGNED NOT NULL,`time` datetime NOT NULL,PRIMARY KEY (`id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
            $conexion->query("CREATE TABLE `users` (`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,`username` varchar(50) COLLATE utf8_unicode_ci NOT NULL,`password` varchar(128) COLLATE utf8_unicode_ci NOT NULL,`name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,`surname` varchar(150) COLLATE utf8_unicode_ci NOT NULL,`color` varchar(22) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#333',`background` varchar(22) COLLATE utf8_unicode_ci NOT NULL DEFAULT '#32fea8',`type` int(1) UNSIGNED NOT NULL,`status` int(1) NOT NULL DEFAULT '0',PRIMARY KEY (`id`),UNIQUE KEY `username` (`username`)) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;");
            
            // Insertar usuario
            $conexion->query("INSERT INTO `users` (`username`, `password`, `name`, `surname`, `type`) VALUES('$user_username', '$user_pass_hash', '$user_name', '$user_surname', 2)");
            
            $str = <<<EOF
<?php
    date_default_timezone_set('Europe/Madrid');
    setlocale(LC_TIME, 'es_ES.UTF-8');

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

/* Bloquear */
if(file_exists(_RUTA_LOG_."bloqueado")){
    define("_bloquear_", true);
}else{
    define("_bloquear_", false);
}

/* BBDD */
    define("_HOST_", "$address");
    define("_BBDD_", "$database");
    define("_USER_", "$db_username");
    define("_PASS_", "$db_password");
    define("_TIPO_", "$type");
                    
/* Root User */
    define("_USER_USERNAME_", "$user_username");
    define("_USER_PASSWORD_", "$user_password");
    define("_USER_NAME_", "$user_name");
    define("_USER_SURNAME_", "$user_surname");
                    
/* Autoloader */
    spl_autoload_register(function (\$clase) {
        if(strstr(\$clase, 'c_')) {
            include 'c/' . \$clase . '.php';
        } else {
            include 'm/' . \$clase . '.php';
        }
    });

EOF;

            file_put_contents('./config/config.php', $str);
            echo 1;
        }else{
            echo 0;
        }
    } catch (PDOException $e) {
        echo 'Falló la conexión: ' . $e->getMessage();
    }
    exit();
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
        <script src="./assets/js/jquery.min.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="jumbotron" style="margin-top: 35px">
                <h1 style="font-size:3.5em">Instalador de Exchange O' Learn</h1>
                <p>Para poder instalar esta aplicación es necesario tener conexión a internet</p>
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
                        <h5><b>Nota:</b> Este usuario no es visible para los demás usuarios, por lo que su uso está destinado únicamente para la creación de profesores.</h5>
                    </div>
                    <div class="form-group">
                        <label for="usr_name" class="col-sm-4 control-label">Nombre: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="usr_name" placeholder="Nombre" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr_surname" class="col-sm-4 control-label">Apellidos: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="usr_surname" placeholder="Apellidos" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="usr_username" class="col-sm-4 control-label">Usuario: </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="usr_username" placeholder="Usuario" disabled>
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
                                console.log(msg);
                                if (msg == 0) {
                                    $('#address').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#database').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#type').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#db_username').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#db_password').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');
                                    $('#continuar').attr('disabled', true).parent().parent().addClass('has-success').removeClass('has-error');

                                    $('#usr_name').attr('disabled', false).focus();
                                    $('#usr_surname').attr('disabled', false);
                                    $('#usr_username').attr('disabled', false);
                                    $('#usr_password').attr('disabled', false);
                                    $('#usr_password2').attr('disabled', false);
                                    $('#instalar').attr('disabled', false);
                                } else {
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
                    if ($('#usr_password').val() == $('#usr_password2').val()) {

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
                                usr_password: $('#usr_password').val(),
                                usr_name: $('#usr_name').val(),
                                usr_surname: $('#usr_surname').val()
                            }
                        })
                                .done(function (msg) {
                                    console.log(msg);
                                    if(msg == 1){
                                        location.reload();
                                    }
                                });
                        alert("Se reiniciará la página para que pueda iniciar sesión.");
                    }else{
                        alert("Las contraseñas no coinciden.");
                    }
                });

            });
        </script>