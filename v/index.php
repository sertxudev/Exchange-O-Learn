<body class="hold-transition skin-purple sidebar-mini" style="height: 100vh" ng-app="eol">
    <div class="wrapper" ng-controller="TabController as tab">
        <header class="main-header">
            <a class="logo">
                <span class="logo-mini"><b>E</b>O<b>L</b></span>
                <span class="logo-lg"><b>Exchange</b> O' <b>Learn</b></span>
            </a>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar" style="-webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;">
                <ul class="sidebar-menu">
                    <li ng-class="{ active:tab.isSet(1) }" onclick="scrolldown()">
                        <a ng-click="tab.setTab(1)"><i class="fa fa-home"></i> <span>Inicio</span></a>
                    </li>

                    <li ng-class="{ active:tab.isSet(2) }" style="display: inline-block;" ng-style="{ width: tab.isSet(2) ? '81%' : '100%' }">
                        <a ng-click="tab.setTab(2)"><i class="fa fa-folder-open"></i> <span>Carpeta Personal</span></a>
                    </li>
                    <li ng-class="{ active:hover }" ng-show="tab.isSet(2)" style="display: inline-block; float: right; position: absolute;">
                        <a style="float:right;" ng-click="uploadPersonalFiles()"><i class="fa fa-upload"></i></a>
                    </li>

                    <li></li>

                    <li ng-class="{ active:tab.isSet(3) }" onclick="recargarMails()">
                        <a ng-click="tab.setTab(3)"><i class="fa fa-envelope"></i> <span>Correo Electrónico <span class="pull-right badge" id="unreadMails_badge" style="position: absolute;right: 10px;"></span></span></a>
                    </li>

                    <li></li>

                    <li ng-class="{ active:tab.isSet(4) }">
                        <a ng-click="tab.setTab(4)"><i class="fa fa-gear"></i> <span>Configuración</span></a>
                    </li>
                    <?php
                    if ($_SESSION['type'] >= 1) {
                        ?>
                        <li class="treeview" ng-class="{ active:tab.isSet(5) || tab.isSet(6) || tab.isSet(7) || tab.isSet(8) || tab.isSet(9) }">
                            <a ng-click="tab.setTab(5)" id="panel_control">
                                <i class="fa fa-dashboard"></i> <span>Panel de Control</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li ng-class="{ active:tab.isSet(6) }" onClick="recargarAlumnos()" style="display: inline-block;" ng-style="{ width: tab.isSet(6) ? '81%' : '100%' }">
                                    <a ng-click="tab.setTab(6)"><i class="fa fa-pencil"></i> Alumnos</a>
                                </li>
                                <li ng-class="{ active:hover }" ng-show="tab.isSet(6)" style="display: inline-block; float: right; position: absolute;">
                                    <a style="float:right;" ng-click="crearAlumno()"><i class="fa fa-plus"></i></a>
                                </li>

                                <br>

                                <li ng-class="{ active:tab.isSet(7) }" onClick="recargarProfesores()" style="display: inline-block;" ng-style="{ width: tab.isSet(7) ? '81%' : '100%' }">
                                    <a ng-click="tab.setTab(7)"><i class="fa fa-book"></i> Profesores</a>
                                </li>
                                <li ng-class="{ active:hover }" ng-show="tab.isSet(7)" style="display: inline-block; float: right; position: absolute;">
                                    <a style="float:right;" ng-click="crearProfesor()"><i class="fa fa-plus"></i></a>
                                </li>

                                <br>

                                <li ng-class="{ active:tab.isSet(8) }" style="display: inline-block;">
                                    <a ng-click="tab.setTab(8)" onClick="recargarMensajes()"><i class="fa fa-comments"></i> Mensajes</a>
                                </li>

                                <br>

                                <li ng-class="{ active:tab.isSet(9) }" style="display: inline-block;" ng-style="{ width: tab.isSet(9) ? '81%' : '100%' }">
                                    <a ng-click="tab.setTab(9)" onclick="recargarEventos()"><i class="fa fa-calendar"></i> Eventos</a>
                                </li>
                                <li ng-class="{ active:hover }" ng-show="tab.isSet(9)" style="display: inline-block; float: right; position: absolute;">
                                    <a style="float:right;" ng-click="crearEventos()"><i class="fa fa-plus"></i></a>
                                </li>


                            </ul>
                        </li>
                        <?php
                    }
                    ?>
                    <li>
                        <a ng-click="logout()"><i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span></a>
                    </li>

                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid" ng-show="tab.isSet(1)" ng-controller="mobileController as mobile">
                    <div class="row header-container" id="header-container" ng-controller="colorController as color" style="background-color: {{color.custom.background}}; color: {{color.custom.color}};">
                        <div class="hidden-lg hidden-md">
                            <div class="col-md-4 col-sm-4 col-xs-4 header" ng-click="mobile.setTab(1)">
                                <i class="fa fa-th-list"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center hidden-xs title">Agenda</h2>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 header" ng-click="mobile.setTab(2)">
                                <i class="fa fa-comments"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center hidden-xs title">Chat</h2>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 header" ng-click="mobile.setTab(3)">
                                <i class="fa fa-file-text"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center hidden-xs title">Archivos</h2>
                            </div>
                        </div>
                        <div class="hidden-sm hidden-xs">
                            <div class="col-md-4 col-sm-4 col-xs-4 header">
                                <i class="fa fa-th-list"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center title">Agenda</h2>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 header">
                                <i class="fa fa-comments"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center title">Chat</h2>
                            </div>
                            <div class="col-md-4 col-sm-4 col-xs-4 header">
                                <i class="fa fa-file-text"></i>
                                &nbsp;
                                <h2 class="text-nowrap text-center title">Archivos</h2>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 module" ng-controller="eventsController as module" ng-class="{ 'hidden-sm hidden-xs':mobile.isSet(2) || mobile.isSet(3) }" style="overflow-y: auto;">
                            <div class="row evento" ng-repeat="event in module.events" ng-click="mostrarEvento(event.id)">
                                <div class="col-lg-3 col-md-3 date">
                                    <h2 class="day"> {{event.time| date:'dd'}} </h2><span>{{event.time| date:'MMMM'}} {{event.time| date:'yyyy'}}</span></div>
                                <div class="col-lg-9 col-md-9 body">
                                    <h3 class="title">{{event.title}}</h3>
                                    <p class="text">{{event.description}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 module module-chat overflow-hidden" ng-controller="chatController as module" ng-class="{ 'hidden-sm hidden-xs':mobile.isSet(1) || mobile.isSet(3) }">
                            <div class="row chat">
                                <div class="col-md-12">
                                    <div class="row chat-window material">
                                        <div class="panel">
                                            <div class="panel-body msg-container-base" id="chat-container" ng-bind-html="messages">
                                            </div>
                                            <div class="panel-footer chat-bottom-bar">                                                
                                                <div class="input-group input-group-md">
                                                    <input type="text" class="form-control" id="submit_text" class="form-control input-md chat-input col-md-10" placeholder="Enviar un mensaje">
                                                    <span class="input-group-btn" style="height: calc(70px - 30px);">
                                                        <button type="button" class="btn btn-default" ng-click="openEmojiModal()" style="height: 100%;"><i class="em em_grinning_face"></i></button>
                                                    </span>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 module" ng-controller="filesController as module" ng-class="{ 'hidden-sm hidden-xs':mobile.isSet(1) || mobile.isSet(2) }" style="overflow-y: auto;">
                            <div class="row archivos">

                                <div class="col-lg-2 col-md-3 col-sm-2 col-xs-3 archivo" ng-repeat="carpetas in module.carpetas" ng-click="mostrarCarpeta(carpetas.id)">
                                    <img class="img-responsive" src="./assets/img/folder.png">
                                    <span>{{carpetas.name}} {{carpetas.surname}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" ng-show="tab.isSet(2)" style="padding-top: 15px;">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <table class="table table-bordered bordered table-striped datatable" id="personalFilesTable" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Tipo</th>
                                        <th>Creación</th>
                                        <th>Acceso</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="panelBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="container-fluid" ng-controller="mailsController as carpeta" ng-show="tab.isSet(3)" style="padding-top: 15px;">
                    <section class="content-header">
                        <h1>
                            Correo Electrónico
                            <small>Manda mensajes privados a cualquier usuario de la aplicación</small>
                        </h1>
                    </section>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-3">
                                <a class="btn btn-primary btn-block margin-bottom" onclick="openCrearMail()">Nuevo Correo</a>
                                <br>
                                <div class="box box-solid">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Carpetas</h3>

                                        <div class="box-tools">
                                            <button type="button" class="btn btn-box-tool" data-toggle="collapse" data-target="#carpetas"><i class="fa fa-minus"></i></button>
                                        </div>
                                    </div>
                                    <div class="box-body no-padding collapse in" id="carpetas">
                                        <ul class="nav nav-stacked" style="font-weight: bold;">
                                            <li ng-class="{ active:carpeta.isSet(1) }">
                                                <a ng-click="carpeta.setTab(1)" onclick="recargarMails()"><i class="fa fa-inbox" style="margin-right: 5px;"></i> Bandeja de Entrada <span class="label label-primary pull-right" id="unreadMails_label"></span></a>
                                            </li>
                                            <li ng-class="{ active:carpeta.isSet(2) }">
                                                <a ng-click="carpeta.setTab(2)" onclick="recargarMails()"><i class="fa fa-envelope-o" style="margin-right: 5px;"></i> Enviados</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" ng-show="carpeta.isSet(1)">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Bandeja de Entrada</h3>

                                    </div>
                                    <div class="box-body no-padding">
                                        <div class="table-responsive mailbox-messages" style="width: 100%;">

                                            <table class="table table-bordered bordered table-striped datatable" id="personalMail" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Important</th>
                                                        <th>Enviado por</th>
                                                        <th>Asunto</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9" ng-show="carpeta.isSet(2)">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Enviados</h3>

                                    </div>
                                    <div class="box-body no-padding">
                                        <div class="table-responsive mailbox-messages" style="width: 100%;">

                                            <table class="table table-bordered bordered table-striped datatable" id="personalMailEnviados" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Important</th>
                                                        <th>Enviado a</th>
                                                        <th>Asunto</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="container-fluid" ng-show="tab.isSet(4)" style="padding-top: 15px;" ng-controller="configController as module">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h4>Color Texto</h4>
                                    <input id="colorTexto" type="text" class="form-control" value="<?php echo $_SESSION['color'] ?>" style="background-color: <?php echo $_SESSION['background'] ?>; color: <?php echo $_SESSION['color'] ?>;" />
                                </div>
                                <div class="col-md-4">
                                    <h4>Color Fondo</h4>
                                    <input id="colorFondo" type="text" class="form-control" value="<?php echo $_SESSION['background'] ?>" style="background-color: <?php echo $_SESSION['background'] ?>; color: <?php echo $_SESSION['color'] ?>;" />
                                </div>
                                <div class="col-md-2" style="height: 73px;">
                                    <button type="button" class="btn btn-primary" ng-click="guardarColor()" style="margin-top: 39px">Guardar Colores</button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12" id="config_alert"></div>
                                <div class="col-md-2">
                                    <h4>Usuario</h4>
                                    <input id="config_username" type="text" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <h4>Contraseña</h4>
                                    <input id="config_password" type="password" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <h4>Nombre</h4>
                                    <input id="config_name" type="text" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <h4>Apellidos</h4>
                                    <input id="config_surname" type="text" class="form-control"/>
                                </div>
                                <div class="col-md-2" style="height: 73px;">
                                    <button type="button" class="btn btn-primary" ng-click="guardarPerfil()" style="margin-top: 39px">Guardar Perfil</button>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>

                <?php if ($_SESSION['type'] > 0) { ?>
                    <div class="container-fluid" ng-show="tab.isSet(5)" style="padding-top: 15px;" ng-controller="dashController as module">
                        <section class="content-header">
                            <h1>
                                Dashboard
                                <small>Panel de Control</small>
                            </h1>
                        </section>
                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>{{module.cantidadAlumnos}}</h3>

                                    <p>Alumnos</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pencil"></i>
                                </div>
                                <a ng-click="tab.setTab(6)" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-red">
                                <div class="inner">
                                    <h3>{{module.cantidadProfesores}}</h3>

                                    <p>Profesores</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-book"></i>
                                </div>
                                <a ng-click="tab.setTab(7)" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3>{{module.cantidadMensajes}}</h3>

                                    <p>Mensajes</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-comments"></i>
                                </div>
                                <a ng-click="tab.setTab(8)" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="col-lg-3 col-xs-6">
                            <!-- small box -->
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3>{{module.cantidadEventos}}</h3>

                                    <p>Eventos</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <a ng-click="tab.setTab(9)" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class="w3-panel w3-topbar w3-bottombar w3-border-yellow w3-pale-yellow col-lg-3 col-xs-6 pull-left">
                            <h3>Bloquear Aplicación</h3>
                            <button ng-click="bloquear_aplicacion()" class="pull-left btn btn-warning">Bloquear</button>
                            <button ng-click="desbloquear_aplicacion()" class="pull-right btn btn-success">Desbloquear</button>
                        </div>

                    <?php if ($_SESSION['type'] > 1) { ?>
                        <div class="w3-panel w3-topbar w3-bottombar w3-border-red w3-pale-red col-lg-3 col-xs-6 pull-right">
                            <h3>Resetear Aplicación</h3>
                            <button onclick="resetear()" class="btn btn-danger" style="width:100%">Resetear</button>
                        </div>
                    <?php } ?>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['type'] > 0) { ?>
                    <div class="container-fluid" ng-show="tab.isSet(6)" style="padding-top: 15px;">
                        <section class="content-header">
                            <h1>
                                Alumnos
                                <small>Panel de Control</small>
                            </h1>
                        </section>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered bordered table-striped datatable" id="alumnosTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="panelBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['type'] > 0) { ?>                
                    <div class="container-fluid" ng-show="tab.isSet(7)" style="padding-top: 15px;">
                        <section class="content-header">
                            <h1>
                                Profesores
                                <small>Panel de Control</small>
                            </h1>
                        </section>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered bordered table-striped datatable" id="profesorTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Usuario</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="panelBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['type'] > 0) { ?>
                    <div class="container-fluid" ng-show="tab.isSet(8)" style="padding-top: 15px;">
                        <section class="content-header">
                            <h1>
                                Mensajes
                                <small>Panel de Control</small>
                            </h1>
                        </section>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered bordered table-striped datatable" id="mensajesTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Fecha de envío</th>
                                            <th>Nombre</th>
                                            <th>Apellidos</th>
                                            <th>Mensaje</th>
                                            <th><button type="button" onClick="borrarMensajes()" class="btn btn-danger">Eliminar Todos</button></th>
                                        </tr>
                                    </thead>
                                    <tbody id="panelBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($_SESSION['type'] > 0) { ?>
                    <div class="container-fluid" ng-show="tab.isSet(9)" style="padding-top: 15px;">
                        <section class="content-header">
                            <h1>
                                Eventos
                                <small>Panel de Control</small>
                            </h1>
                        </section>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <table class="table table-bordered bordered table-striped datatable" id="eventosTable" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Título</th>
                                            <th>Descripción</th>
                                            <th>Fecha del evento</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="panelBody">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </section>
        </div>
    </div>



    <div class="modal fade" id="viewMailModal" role="dialog">
        <div class="modal-dialog modal-lg" style="position: absolute;top: 45%;left: 50%;transform: translate(-50%, -50%) !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="mail_subject"></h4>
                    <br>
                    <h5 class="modal-title">
                        <span id="mail_from" class="pull-left"></span>
                        <br>
                        <span id="mail_to" class="pull-left"></span>
                        <span id="mail_date" class="pull-right"></span>
                    </h5>
                </div>
                <div class="modal-body" id="mail_text">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mostrarEvento" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="event_title">{{module.evento.title}} - {{module.evento.date| date:"dd 'de' MMMM 'del' yyyy"}}</h4>
                </div>
                <div class="modal-body" id="event_description"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mostrarCarpeta" role="dialog" ng-controller="filesController as modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="carpeta_name">{{module.usuario.name}} {{module.usuario.surname}}</h4>
                </div>
                <div class="modal-body" id="carpeta_files">
                    <table class="table table-bordered bordered table-striped datatable" id="filesFolder" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Creación</th>
                                <th>Acceso</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="panelBody">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadPersonalFiles" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="./post.php?r=uploadFile" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Subir Archivos</h4>
                    </div>
                    <div class="modal-body">

                        <div class="form-group">
                            <label for="file_name" class="col-sm-2 control-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="file_name" placeholder="Nombre" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Acceso:</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="file_access">
                                    <option value="0">Público</option>
                                    <option value="1">Protegido</option>
                                    <option value="2">Privado</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file_name" class="col-sm-2 control-label">Archivo: </label>
                            <div class="col-sm-10">
                                <input type="file" class="" name="file"/>
                            </div>                            
                        </div>

                        <span>Formatos admitidos: <b>jpg, png, gif, pdf, rar, zip, doc, docx, xlsx, xls, ods, odt, mp3, mp4</b></span>
                        <br>
                        <span>Tamaño POST máximo (post_max_size): <b><?php echo ini_get('post_max_size'); ?></b></span>
                        <br>
                        <span>Tamaño subida máximo (upload_max_filesize): <b><?php echo ini_get('upload_max_filesize'); ?></b></span>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Subir</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEditarArchivo" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Archivo</h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="file_name" class="col-sm-2 control-label">Nombre:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="file_name" id="file_name" placeholder="Nombre">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Acceso:</label>
                            <div class="col-sm-10">
                                <select class="form-control" id="file_access" name="file_access">
                                    <option value="0">Público</option>
                                    <option value="1">Protegido</option>
                                    <option value="2">Privado</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="hidden" class="form-control" id="file_id">
                        </div>                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="postEditarArchivo()" class="btn btn-primary">Actualizar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearAlumno" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir Alumno</h4>
                </div>
                <div class="modal-body">
                    <div id="modalEditarUsuario"></div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="alumno_username">Usuario:</label>
                            <input type="text" class="form-control" id="alumno_username" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="alumno_pass">Contraseña:</label>
                            <input type="password" class="form-control" id="alumno_pass" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <label for="alumno_name">Nombre:</label>
                            <input type="text" class="form-control" id="alumno_name" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="alumno_surnames">Apellidos:</label>
                            <input type="text" class="form-control" id="alumno_surnames" placeholder="Apellidos">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="crearAlumno()">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editarUsuario" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Usuario</h4>
                </div>
                <div class="modal-body">
                    <div id="modalEditarUsuario"></div>
                    <div class="box-body">
                        <input type="hidden" class="form-control" id="usuario_editar_id">
                        <div class="form-group">
                            <label for="usuario_editar_username">Usuario:</label>
                            <input type="text" class="form-control" id="usuario_editar_username" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="usuario_editar_name">Nombre:</label>
                            <input type="text" class="form-control" id="usuario_editar_name" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="usuario_editar_surnames">Apellidos:</label>
                            <input type="text" class="form-control" id="usuario_editar_surnames" placeholder="Apellidos">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="sendEditarUsuario()">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearProfesor" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir Profesor</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="profesor_username">Usuario:</label>
                            <input type="text" class="form-control" id="profesor_username" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="profesor_pass">Contraseña:</label>
                            <input type="password" class="form-control" id="profesor_pass" placeholder="Contraseña">
                        </div>
                        <div class="form-group">
                            <label for="profesor_name">Nombre:</label>
                            <input type="text" class="form-control" id="profesor_name" placeholder="Nombre">
                        </div>
                        <div class="form-group">
                            <label for="profesor_surnames">Apellidos:</label>
                            <input type="text" class="form-control" id="profesor_surnames" placeholder="Apellidos">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="crearProfesor()">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearEventos" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir Evento</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="profesor_username">Nombre:</label>
                            <input type="text" class="form-control" id="evento_nombre" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="profesor_pass">Descripción:</label>
                            <textarea class="form-control" style="resize: vertical;" id="evento_descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="profesor_name">Fecha:</label>
                            <input type="text" class="form-control" id="evento_fecha" placeholder="Fecha" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="crearEvento()">Crear</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditarEvento" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Editar Evento</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" class="form-control" id="evento_editar_id">
                        <div class="form-group">
                            <label for="profesor_username">Nombre:</label>
                            <input type="text" class="form-control" id="evento_editar_nombre" placeholder="Usuario">
                        </div>
                        <div class="form-group">
                            <label for="profesor_pass">Descripción:</label>
                            <textarea class="form-control" style="resize: vertical;" id="evento_editar_descripcion"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="profesor_name">Fecha:</label>
                            <input type="text" class="form-control" id="evento_editar_fecha" placeholder="Fecha" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="sendEditarEvento()">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="crearMail" role="dialog">
        <div class="modal-dialog modal-lg" style="position: absolute;top: 45%;left: 50%;transform: translate(-50%, -50%) !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Borrador</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="newMail_to">Para:</label>
                            <select id="newMail_to" class="form-control">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="newMail_subject">Asunto:</label>
                            <input type="text" class="form-control" id="newMail_subject" placeholder="Asunto">
                        </div>
                        <div class="form-group">
                            <label for="newMail_text">Texto:</label>
                            <textarea class="form-control" style="resize: vertical;" id="newMail_text"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" onclick="enviarCrearMail()">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalYoutubeVideo" role="dialog">
        <div class="modal-dialog modal-lg" style="position: absolute;top: 45%;left: 50%;transform: translate(-50%, -50%) !important;">
            <div class="modal-content">
                <div class="modal-body" style="font-size: 0;padding:0" id="youtubeVideoEmbed"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEmoji" role="dialog" ng-controller="emojiController as modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" ng-bind-html="emojis"></div>
            </div>
        </div>
    </div>

    <a type="button" href="./docs/" target="_blank" class="btn-floating hidden-sm hidden-xs"><img src="./assets/img/anonimouse.png" height="75px"></a>
