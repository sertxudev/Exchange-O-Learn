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
    }

    if (!isset($_GET['r'])) {
        $_GET['r'] = null;
    }

    // Rutas GET
    switch ($_GET['r']) {

        case 'obtenerColor':
            logger::guardar('{"color": "'.$_SESSION['color'].'", "background": "'.$_SESSION['background'].'"}');
            echo '{"color": "'.$_SESSION['color'].'", "background": "'.$_SESSION['background'].'"}';
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
            echo $folder->obtenerCarpeta($_GET['id'], $_SESSION['']);
            break;
        
        case 'obtenerUsuario':
            $user = new c_usuario();
            echo $user->obtenerUsuario($_GET['id']);
            break;
        
        case 'logout':
            $user = new c_usuario();
            echo $user->logout();
            break;
    }