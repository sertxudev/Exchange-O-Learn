<body ng-app="eol">
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
                                    <div style="display:inherit">
                                        <div class="input-group">
                                            <input type="text" id="submit_text" class="form-control input-sm chat-input" placeholder="Enviar un mensaje" />
                                            <span class="input-group-btn">
                                                <button id="submit_button" class="btn btn-sm chat-submit-button">Enviar</button> 
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 module" ng-controller="filesController as module">
                <div class="row carpetas">
                    <div class="col-xs-6 carpeta not-active" ng-click="tabPersonal()">
                        <h4>Carpeta Personal </h4></div>
                    <div class="col-xs-6 carpeta" ng-click="tabPublic()">
                        <h4>Público </h4></div>
                </div>
                <div class="row archivos">
                    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-3 archivo" ng-repeat="carpeta in module.carpetas" ng-click="mostrarCarpeta(carpeta.id)">
<!--                        <div class="options">
                            <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                        </div>-->
                        <img class="img-responsive" src="./assets/img/folder.png">
                        <span>{{carpeta.name}} {{carpeta.surname}}</span>
                    </div>
<!--                    <div class="col-lg-2 col-md-3 col-sm-2 col-xs-3 archivo">
                        <img class="img-responsive" src="./assets/img/blank.png">
                        <span>defalt.exe </span>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAñadirAlumno" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Añadir Alumno</h4>
                </div>
                <div class="modal-body">

                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">Usuario:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="username" placeholder="Usuario">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" class="col-sm-2 control-label">Contraseña:</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" id="password" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="name" placeholder="Nombre">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="surname" class="col-sm-2 control-label">Apellidos:</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="surname" placeholder="Apellidos">
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" data-dismiss="modal">Añadir</button>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="mostrarCarpeta" role="dialog">
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