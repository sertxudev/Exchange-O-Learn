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

    case 'crear-usuario':
        if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
            $user = new c_usuario();
            echo $user->crearUsuario($_POST['username'], $_POST['password'], $_POST['name'], $_POST['surname'], $_POST['birthday'], $_POST['type']);
        }
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

    case 'obtenerMessages':
        $messages = new c_messages();
        echo $messages->obtenerMessages();
        break;

    case 'sendMessage':
        $messages = new c_messages();
//            
//            $_POST = (array) json_decode( file_get_contents("php://input") );
//
//            echo $messages->sendMessage($_POST['text'], $_SESSION['id']);
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

    case 'cambiarColor':
        $user = new c_usuario();
        echo $user->cambiarColor($_GET['color'], $_GET['background'], $_SESSION['id']);
        break;

    case 'logout':
        $user = new c_usuario();
        echo $user->logout();
        break;
}