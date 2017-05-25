<?php

    session_start();

    if (!file_exists('./config/config.php')) {
        include_once './install.php';
    } else {
        include_once './config/config.php';
        
        if (isset($_SESSION['id']) && $_SESSION['id'] != '') {
            include_once './v/header.php';
            
            if (isset($_GET['r'])) {
                
                switch ($_GET['r']) {
                    case 'admin':
                        include_once './v/admin.php';
                        break;
                    default :
                        include_once './v/index.php';
                        break;
                }
                
            }else{
                include_once './v/index.php';
            }

        } else {
            include_once './v/login.php';
        }
    }

    include_once './v/footer.php';