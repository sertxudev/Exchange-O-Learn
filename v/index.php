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
                    <li ng-class="{ active:tab.isSet(1) }"><a ng-click="tab.setTab(1)"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                    <li ng-class="{ active:tab.isSet(2) }"><a ng-click="tab.setTab(2)"><i class="fa fa-folder-open"></i> <span>Carpeta Personal</span></a></li>
                    <li ng-class="{ active:tab.isSet(3) }"><a ng-click="tab.setTab(3)"><i class="fa fa-gear"></i> <span>Configuración</span></a></li>
                    <li><a ng-click="logout()"><i class="fa fa-sign-out"></i> <span>Cerrar Sesión</span></a></li>
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
                                    <h2 class="day"> {{event.time| date:'dd'}} </h2><span>{{event.time | date:'MMMM'}} {{event.time | date:'yyyy'}}</span></div>
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
                                                                <span class="date">{{message.time * 1000 | date: 'hh:mm a dd/MM/yyyy'}}</span>
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
                            <table class="table table-bordered bordered table-striped datatable" ui-jq="dataTable" ng-controller="personalFilesController as module">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Creación</th>
                                        <th>Acceso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="file in module.files">
                                        <td>{{file.name}}</td>
                                        <td>{{file.time*1000 | date: 'hh:mm a dd/MM/yyyy'}}</td>
                                        <td>{{file.access}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h2></h2>
                    <form action="./post.php?r=uploadFile" method="post" enctype="multipart/form-data">
                        <input type="file" name="file" />
                        <button type="submit">Subir!</button>
                    </form>
                    <!--                    <form action="./post.php?r=uploadFile" class="dropzone" id="uploadFiles">
                                            <input type="file" name="file" />
                                        </form>
                                        <table datatable class="table" id="personalFiles" ng-controller="personalFilesController as module">
                                            <thead>
                                                <tr>
                                                    <th>Nombre</th>
                                                    <th>Creación</th>
                                                    <th>Acceso</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr ng-repeat="file in module.files">
                                                    <td>{{file.name}}</td>
                                                    <td>{{file.time}}</td>
                                                    <td>{{file.access}}</td>
                                                </tr>
                                            </tbody>
                                        </table>-->
                </div>
                <div class="container-fluid" ng-show="tab.isSet(3)">
                    <h2>Tab 3</h2>
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
                    <h4 class="modal-title" id="carpeta_name">{{hello}}{{module.usuario.name}} {{module.usuario.surname}}</h4>
                </div>
                <div class="modal-body" id="carpeta_files">
                    <ul>
                        <li ng-repeat="carpeta in module.carpeta">
                            {{carpeta.file_name}}
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>