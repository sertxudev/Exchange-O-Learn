<?php

session_start();

include_once './config/config.php';

if (!isset($_POST['r'])) {
    $_POST['r'] = null;
}

// Rutas POST
switch ($_POST['r']) {

    case 'bloqueado':
        if(_bloquear_ == false){
            echo 0;
        }
        break;

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
        echo $usuario->actualizarPerfil($_POST['id'], $_POST['username'], $_POST['name'], $_POST['surname']);
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

    case 'sendEmoji':
        $messages = new c_messages();
        echo $messages->sendMessage($_POST['emoji'], $_SESSION['id']);
        break;

    case 'estadoUsuario':
        $usuario = new c_usuario();
        echo $usuario->estadoUsuario($_POST['id'], $_POST['estado'], $_SESSION['id']);
        break;
    
    case 'contarEmailsRecibidos':
        $email = new c_email();
        echo $email->contarEmailsRecibidos($_SESSION['id']);
        break;
    
    case 'obtenerEmail':
        $email = new c_email();
        echo $email->obtenerEmail($_POST['id'], $_POST['flag'], $_SESSION['id']);
        break;
    
    case 'enviarCrearMail':
        $email = new c_email();
        echo $email->enviarEmail($_SESSION['id'], $_POST['to'], $_SESSION['type'], $_POST['subject'], $_POST['text']);
        break;
    
    case 'obtenerPosiblesDestinatarios':
        $email = new c_email();
        echo $email->obtenerPosiblesDestinatarios();
        break;
    
    case 'crearEvento':
        $email = new c_evento();
        echo $email->crearEvento($_POST['nombre'], $_POST['descripcion'], $_POST['fecha']);
        break;
    
    case 'borrarEvento':
        $email = new c_evento();
        echo $email->borrarEvento($_POST['id']);
        break;
    
    case 'resetear':
        $dashboard = new c_dashboard();
        echo $dashboard->resetear();
        $user = new c_usuario();
        $user->logout();
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
        echo $user->actualizarPerfil($_SESSION['id'], $_GET['username'], $_GET['name'], $_GET['surname'], $_GET['password']);
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
    
    case 'obtenerEmailsRecibidos':
        $email = new c_email();
        echo $email->obtenerEmailsRecibidos($_SESSION['id']);
        break;
    
    case 'obtenerEmailsEnviados':
        $email = new c_email();
        echo $email->obtenerEmailsEnviados($_SESSION['id']);
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
        //var_dump($_FILES);
        //echo $finfo->file($_FILES['file']['tmp_name']);
        //exit;
        $ext = array_search(
                $finfo->file($_FILES['file']['tmp_name']), array(
            'jpg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'pdf' => 'application/pdf',
            'rar' => 'application/x-rar',
            'zip' => 'application/zip',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'doc' => 'application/msword',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'xls' => 'application/vnd.ms-excel',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'mp3' => 'audio/mp3',
            'mp4' => 'video/mp4',
                ), true);

        if(!file_exists('./uploads')){
            mkdir('./uploads');
        }
        $file_name = hash('md5', time());
        $file_url = './uploads/' . $file_name . '.' . $ext;

        if ($ext) {
            if (move_uploaded_file(
                            $_FILES['file']['tmp_name'], sprintf('./uploads/%s.%s', $file_name, $ext)
                    )) {

                $folder = new c_carpeta();
                $folder->subirArchivo($_POST['file_name'], $file_url, $ext, $_SESSION['id'], $_POST['file_access']);
                $_SESSION['error'] = 'Archivo subido correctamente';
                header("Location: ./");
            } else {
                $_SESSION['error'] = 'Se ha producido un error al subir el archivo';
                header('Location: ./');
            }
        } else {
            $_SESSION['error'] = 'El archivo no se ha podido subir';
            header('Location: ./');
        }


        break;

    case 'obtenerCarpetaPersonal':
        $folder = new c_carpeta();
        echo $folder->obtenerCarpetaPersonal($_SESSION['id']);
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
            touch(_RUTA_LOG_.'bloqueado');
        }
        break;

    case 'desbloquearAplicacion':
        if($_SESSION['type'] > 0){
            unlink(_RUTA_LOG_.'bloqueado');
        }
        break;

    case 'logout':
        $user = new c_usuario();
        echo $user->logout();
        break;
}
