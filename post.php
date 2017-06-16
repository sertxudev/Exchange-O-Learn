<?php

session_start();

include_once './config/config.php';

if (!isset($_POST['r'])) {
    $_POST['r'] = null;
}

// Rutas POST
switch ($_POST['r']) {

    case 'login':
        $user = new c_usuario();
        echo $user->login($_POST['username'], $_POST['password']);
        break;

    case 'crearAlumno':
        $dashboard = new c_dashboard();
        echo $dashboard->crearUsuario($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], 0);
        break;

    case 'editarUsuario':
        $usuario = new c_usuario();
        echo $usuario->obtenerPerfil($_POST['id']);
        break;

    case 'sendEditarUsuario':
        $usuario = new c_usuario();
        echo $usuario->actualizarPerfil($_POST['id'], $_POST['username'], $_POST['name'], $_POST['surname'], $_POST['birthday']);
        break;

    case 'borrarUsuario':
        $dashboard = new c_dashboard();
        echo $dashboard->borrarUsuario($_POST['id']);
        break;

    case 'crearProfesor':
        $dashboard = new c_dashboard();
        echo $dashboard->crearUsuario($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], 1);
        break;

    case 'borrarMensaje':
        $dashboard = new c_dashboard();
        echo $dashboard->borrarMensaje($_POST['id']);
        break;

    case 'borrarMensajes':
        $dashboard = new c_dashboard();
        echo $dashboard->borrarMensajes();
        break;

    case 'borrarArchivo':
        $folder = new c_carpeta();
        echo $folder->borrarArchivo($_POST['id'], $_SESSION['id']);
        break;
    
    case 'obtenerArchivo':
        $folder = new c_carpeta();
        echo $folder->obtenerArchivo($_POST['id'], $_SESSION['id']);
        break;
    
    case 'editarArchivo':
        $folder = new c_carpeta();
        echo $folder->editarArchivo($_POST['id'], $_POST['name'], $_POST['access'], $_SESSION['id']);
        break;
}

if (!isset($_GET['r'])) {
    $_GET['r'] = null;
}

// Rutas GET
switch ($_GET['r']) {

    case 'obtenerColor':
        echo '{"color": "' . $_SESSION['color'] . '", "background": "' . $_SESSION['background'] . '"}';
        break;

    case 'obtenerEventosFuturos':
        $evento = new c_evento();
        echo $evento->obtenerEventosFuturos();
        break;

    case 'obtenerEvento':
        $evento = new c_evento();
        echo $evento->obtenerEvento($_GET['id']);
        break;
    
    case 'actualizarPerfil':
        $user = new c_usuario();
        echo $user->actualizarPerfil($_SESSION['id'], $_GET['username'], $_GET['password'], $_GET['name'], $_GET['surname'], $_GET['birthday']);
        break;

    case 'obtenerMessages':
        $messages = new c_messages();
        echo $messages->obtenerMessages();
        break;

    case 'sendMessage':
        $messages = new c_messages();
        echo $messages->sendMessage($_GET['text'], $_SESSION['id']);
        break;

    case 'obtenerCarpetas':
        $folder = new c_carpeta();
        echo $folder->obtenerCarpetas($_SESSION['id']);
        break;

    case 'obtenerCarpeta':
        $folder = new c_carpeta();
        echo $folder->obtenerCarpeta($_GET['id'], $_SESSION['type']);
        break;

    case 'obtenerUsuario':
        $user = new c_usuario();
        echo $user->obtenerUsuario($_GET['id']);
        break;
    
    case 'obtenerPerfil':
        $user = new c_usuario();
        echo $user->obtenerPerfil($_SESSION['id']);
        break;

    case 'uploadFile':
        $finfo = new finfo(FILEINFO_MIME_TYPE);
//        echo $finfo->file($_FILES['file']['tmp_name']);
//        exit;
        $ext = array_search(
                $finfo->file($_FILES['file']['tmp_name']), array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'rar' => 'application/x-rar',
            'zip' => 'application/zip',
                ), true);

        $file_name = hash('md5', time());
        $file_url = './uploads/' . $file_name . '.' . $ext;

        if ($ext) {
            if (move_uploaded_file(
                            $_FILES['file']['tmp_name'], sprintf('./uploads/%s.%s', $file_name, $ext)
                    )) {

                $folder = new c_carpeta();
                $folder->subirArchivo($_POST['file_name'], $file_url, $ext, $_SESSION['id'], $_POST['file_access']);
                header("Location: ./");
            } else {
                echo 'Se ha producido un error al subir el archivo';
            }
        } else {
            echo 'Archivo no válido';
        }


        break;

    case 'obtenerCarpetaPersonal':
        $folder = new c_carpeta();
        echo $folder->obtenerCarpetaPersonal($_SESSION['id']);
        break;

    case 'obtenerMails':
        $email = new c_email();
        echo $email->obtenerEmailsRecibidos($_SESSION['id']);
        break;

    case 'obtenerAlumnos':
        $dashboard = new c_dashboard();
        echo $dashboard->obtenerAlumnos();
        break;

    case 'obtenerProfesores':
        $dashboard = new c_dashboard();
        echo $dashboard->obtenerProfesores();
        break;

    case 'obtenerMensajes':
        $dashboard = new c_dashboard();
        echo $dashboard->obtenerMensajes();
        break;

    case 'obtenerEventos':
        $dashboard = new c_dashboard();
        echo $dashboard->obtenerEventos();
        break;

    case 'cambiarColor':
        $user = new c_usuario();
        echo $user->cambiarColor($_GET['color'], $_GET['background'], $_SESSION['id']);
        break;

    case 'contarAlumnos':
        $count = new c_contador();
        echo $count->contarAlumnos();
        break;

    case 'contarProfesores':
        $count = new c_contador();
        echo $count->contarProfesores();
        break;

    case 'contarMensajes':
        $count = new c_contador();
        echo $count->contarMensajes();
        break;

    case 'contarEventos':
        $count = new c_contador();
        echo $count->contarEventos();
        break;

    case 'obtenerEmojis':
        $emojis = new c_emojis();
        echo $emojis->obtenerEmojis();
        break;

    case 'bloquearAplicacion':
        if($_SESSION['type'] > 0){
            if(_bloquear_){
                unlink(_RUTA_LOG_.'bloqueado');
            }else{
                touch(_RUTA_LOG_.'bloqueado');
            }
        }
        break;

    case 'logout':
        $user = new c_usuario();
        echo $user->logout();
        break;
        
    case 'foo':

        $emojis = new c_emojis();
        $emojis_array = json_decode($emojis->mostrarEmojis());

        foreach ($emojis_array as $c) {
            $utf32  = mb_convert_encoding($c, 'UTF-32', 'UTF-8' );
            $hex4 = bin2hex($utf32);
            $dec = hexdec($hex4);
            $array_key[] = "&#$dec;";
        }

        $array = array_combine($array_key, $emojis_array);
        $string = null;
        foreach ($array as $c => $v) {
            $string .= '"'.$c.'" => "'.$v.'",';
        }
        logger::guardar($string);
        break;
}