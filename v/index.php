<body class="hold-transition skin-purple sidebar-mini" style="height: 100vh" ng-app="eol">
    <div class="wrapper" ng-controller="TabController as tab">
        <header class="main-header">
            <a class="logo">
                <span class="logo-mini"><b>E</b>O<b>L</b></span>
                <span class="logo-lg"><b>Exchange</b> O' <b>Learn</b></span>
            </a>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">

                    <li ng-class="{ active:tab.isSet(1) }">
                        <a ng-click="tab.setTab(1)"><i class="fa fa-home"></i> <span>Inicio</span></a>
                    </li>

                    <li ng-class="{ active:tab.isSet(2) }" style="display: inline-block;" ng-style="{ width: tab.isSet(2) ? '81%' : '100%' }">
                        <a ng-click="tab.setTab(2)"><i class="fa fa-folder-open"></i> <span>Carpeta Personal</span></a>
                    </li>
                    <li ng-class="{ active:hover }" ng-show="tab.isSet(2)" style="display: inline-block; float: right; position: absolute;">
                        <a style="float:right;" ng-click="uploadPersonalFiles()"><i class="fa fa-upload"></i></a>
                    </li>

                    <li ng-class="{ active:tab.isSet(3) }">
                        <a ng-click="tab.setTab(3)"><i class="fa fa-gear"></i> <span>Configuración</span></a>
                    </li>
                    <?php
                    if ($_SESSION['type'] >= 2) {
                        echo '<li class="treeview" ng-class="{ active:tab.isSet(4) || tab.isSet(5) || tab.isSet(6) || tab.isSet(7) }">
                        <a ng-click="tab.setTab(4)">
                            <i class="fa fa-dashboard"></i> <span>Panel de Control</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a ng-click="tab.setTab(5)"><i class="fa fa-lock"></i> Administración</a>
                            </li>
                            <li>
                                <a ng-click="tab.setTab(6)"><i class="fa fa-book"></i> Profesores</a>
                            </li>
                            <li>
                                <a ng-click="tab.setTab(7)"><i class="fa fa-pencil"></i> Alumnos</a>
                            </li>
                        </ul>
                    </li>';
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
                <div class="container-fluid" ng-show="tab.isSet(1)">
                    <div class="row header-container" id="header-container" ng-controller="colorController as color" style="background-color: {{color.custom.background}}; color: {{color.custom.color}};">
                        <div class="col-md-4 col-sm-4 col-xs-4 header">
                            <i class="fa fa-th-list"></i>
                            <h2 class="text-nowrap text-center hidden-xs">  Agenda</h2>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 header">
                            <i class="fa fa-comments"></i>
                            <h2 class="text-nowrap text-center hidden-xs title">  Chat</h2>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-4 header">
                            <i class="fa fa-file-text"></i>
                            <h2 class="text-nowrap text-center hidden-xs title">  Archivos</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 module" ng-controller="eventsController as module">
                            <div class="row evento" ng-repeat="event in module.events" ng-click="mostrarEvento(event.id)">
                                <div class="col-lg-3 col-md-3 date">
                                    <h2 class="day"> {{event.time| date:'dd'}} </h2><span>{{event.time| date:'MMMM'}} {{event.time| date:'yyyy'}}</span></div>
                                <div class="col-lg-9 col-md-9 body">
                                    <h3 class="title">{{event.title}}</h3>
                                    <p class="text">{{event.description}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 module overflow-hidden" ng-controller="chatController as module">
                            <div class="row chat">
                                <div class="col-md-12">
                                    <div class="row chat-window material">
                                        <div class="panel">
                                            <div class="panel-body msg-container-base" id="chat-container">
                                                <div class="row msg-container" id="message_{{message.id}}" ng-repeat="message in module.messages">
                                                    <div class="col-md-12 col-xs-12">
                                                        <div class="chat-msg">
                                                            <div class="chat-msg-author">
                                                                <strong>{{message.name}} {{message.surname}}</strong>&nbsp;
                                                                <span class="date">{{message.time * 1000| date: 'hh:mm a dd/MM/yyyy'}}</span>
                                                            </div>
                                                            <p>{{message.text}}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel-footer chat-bottom-bar">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="submit_text" class="form-control input-sm chat-input" placeholder="Enviar un mensaje" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 module" ng-controller="filesController as module">
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
                <div class="container-fluid" ng-show="tab.isSet(3)" style="padding-top: 15px;" ng-controller="configController as module">
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
                                <div class="col-md-3">
                                    <h4>Usuario</h4>
                                    <input id="config_username" type="text" class="form-control" value="" />
                                </div>
                                <div class="col-md-3">
                                    <h4>Contraseña</h4>
                                    <input id="config_password" type="password" class="form-control" value="" />
                                </div>
                                <div class="col-md-3">
                                    <h4>Cumpleaños</h4>
                                    <input id="config_birthday" type="text" class="form-control" value="" readonly/>
                                </div>
                                <div class="col-md-4">
                                    <h4>Nombre</h4>
                                    <input id="config_name" type="text" class="form-control" value="" />
                                </div>
                                <div class="col-md-4">
                                    <h4>Apellidos</h4>
                                    <input id="config_surname" type="text" class="form-control" value="" />
                                </div>
                                <div class="col-md-2" style="height: 73px;">
                                    <button type="button" class="btn btn-primary" ng-click="guardarPerfil()" style="margin-top: 39px">Guardar Perfil</button>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="container-fluid" ng-show="tab.isSet(4)" style="padding-top: 15px;">
                    <section class="content-header">
                        <h1>
                            Dashboard
                            <small>Control de Panel</small>
                        </h1>
                    </section>
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>44</h3>

                                <p>Alumnos</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-pencil"></i>
                            </div>
                            <a href="#" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>6</h3>

                                <p>Profesores</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-book"></i>
                            </div>
                            <a href="#" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h3>244</h3>

                                <p>Mensajes</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-comments"></i>
                            </div>
                            <a href="#" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-purple">
                            <div class="inner">
                                <h3>14</h3>

                                <p>Eventos</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <a href="#" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    
                    <div class="warning-border col-lg-5">
                        <h3>Bloquear Aplicación</h3>
                        <button>Bloquear</button>
                    </div>
                    
                </div>
            </section>
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
        <div class="modal-dialog">
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
                                <input type="text" class="form-control" name="file_name" placeholder="Nombre">
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
                            <label for="file_name" class="col-sm-2 control-label">Archivo:</label>
                            <div class="col-sm-10">
                                <input type="file" class="" name="file" />
                            </div>
                        </div>

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
                        <input type="hidden" class="form-control" id="file_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button onclick="postEditarArchivo()" class="btn btn-primary">Actualizar</button>
                </div>
            </div>

        </div>
    </div>

    <a type="button" href="./docs/" class="btn-floating"><img src="./assets/img/anonimouse.png" height="75px"></a>