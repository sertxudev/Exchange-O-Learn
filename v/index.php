<body class="hold-transition skin-purple sidebar-mini" style="height: 100vh" ng-app="eol">
    <div class="wrapper">
        <header class="main-header">
            <a href="index2.html" class="logo">
                <span class="logo-mini"><b>E</b>O<b>L</b></span>
                <span class="logo-lg"><b>Exchange</b> O' <b>Learn</b></span>
            </a>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <ul class="sidebar-menu">
                    <li class="active"><a href="#"><i class="fa fa-home"></i> <span>Inicio</span></a></li>
                    <li><a href="#"><i class="fa fa-folder-open"></i> <span>Carpeta Personal</span></a></li>
                    <li><a href="#"><i class="fa fa-gear"></i> <span>Configuración</span></a></li>
                </ul>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row header-container" id="header-container">
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
                                                                <span class="date">{{message.time| date: 'hh:mm a dd/MM/yyyy'}}</span>
                                                            </div>
                                                            <p>{{message.text}}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="panel-footer chat-bottom-bar">
                                                <div class="input-group col-md-12">
                                                    <input type="text" id="submit_text" class="form-control input-sm chat-input" placeholder="Enviar un mensaje" />
<!--                                                        <span class="input-group-btn">
                                                        <button id="submit_button" class="btn btn-sm chat-submit-button">Enviar</button> 
                                                    </span>-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 module" ng-controller="filesController as module">
                            <!--                            <div class="row carpetas">
                                                            <div class="col-xs-6 carpeta not-active" ng-click="tabPersonal()">
                                                                <h4>Carpeta Personal </h4>
                                                            </div>
                                                            <div class="col-xs-6 carpeta" ng-click="tabPublic()">
                                                                <h4>Público </h4>
                                                            </div>
                                                        </div>-->
                            <div class="row archivos">
                                <div class="col-lg-2 col-md-3 col-sm-2 col-xs-3 archivo" ng-repeat="carpetas in module.carpetas" ng-click="mostrarCarpeta(carpetas.id)">
                                    <img class="img-responsive" src="./assets/img/folder.png">
                                    <span>{{carpetas.name}} {{carpetas.surname}}</span>
                                </div>
                            </div>
                            <!--                            <div class="row">
                                                            <div class="col-md-12 upload" ng-click="uploadFile()">
                                                                <h2><i class="fa fa-upload" aria-hidden="true"></i></h2>
                                                            </div>
                                                        </div>-->
                        </div>
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

    <div class="modal fade" id="mostrarCarpeta" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" id="carpeta_name">{{module.usuario.name}} {{module.usuario.surname}}</h4>
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