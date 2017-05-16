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
            echo $messages->sendMessage($_GET['text'], $_SESSION['id']);
            break;
        
        case 'obtenerCarpetas':
            $folders = new c_carpeta();
            echo $folders->obtenerCarpetas($_SESSION['id']);
            break;
    }