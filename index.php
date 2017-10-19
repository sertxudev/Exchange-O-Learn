<?php

    session_start();

    if (!file_exists('./config/config.php')) {
        include_once './install.php';
    } else {
        include_once './config/config.php';
        
        if(_bloquear_){
            if(isset($_SESSION['type']) && ($_SESSION['type'] == 0)){
            	include_once './v/header.php';
                include_once './v/bloqueada.php';
			    include_once './v/footer.php';
                exit;
            }
        }

        if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
            include_once './v/header.php';
            include_once './v/index.php';

        } else {
            include_once './v/login.php';
        }
    }

    if(isset($_SESSION['error'])){
        echo '<script>setTimeout(function(){ alert("' . $_SESSION['error'] . '"); }, 1000);</script>';
        unset($_SESSION['error']);
    }
    include_once './v/footer.php';
