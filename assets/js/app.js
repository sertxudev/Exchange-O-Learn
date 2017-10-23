(function () {
    var app = angular.module('eol', []);

    app.controller('colorController', ['$http', function ($http) {
            var module = this;
            $http.get('./post.php?r=obtenerColor').then(function (response) {
                module.custom = response.data;
            });
        }]);

    app.controller('mobileController', ['$http', '$scope', function ($http, $scope) {
            this.mobile = 1;
            this.setTab = function (num) {
                this.mobile = num;
            };
            this.isSet = function (num) {
                return this.mobile == num;
            };
        }]);

    app.controller('eventsController', ['$http', '$scope', function ($http, $scope) {
            var module = this;
            $http.get('./post.php?r=obtenerEventosFuturos').then(function (response) {
                module.events = response.data;
            });

            $scope.mostrarEvento = function (id) {
                $http.get('./post.php?r=obtenerEvento&id=' + id).then(function (response) {
                    module.evento = response.data[0];
                    $('#event_title').html(response.data[0].title + ' - ' + response.data[0].time);
                    $('#event_description').html(response.data[0].description);
                    $('#mostrarEvento').modal();
                });
            };
        }]);

    app.controller('chatController', ['$http', '$scope', '$sce', function ($http, $scope, $sce) {
            var module = this;
            var int = 0;

            $scope.openEmojiModal = function () {
                $('#modalEmoji').modal();
            };

            setInterval(
                    function () {
                        $http.get('./post.php?r=obtenerMessages').then(function (response) {
                            if (response.data == 'Access Denied') {
                                location.reload();
                            }
                            $scope.messages = $sce.trustAsHtml(response.data);
                        });
                    }
            , 1500);

            var submit = document.getElementById("submit_text");
            submit.addEventListener("keydown", function (e) {
                if (e.keyCode === 13) {
                    if ($('#submit_text').val()) {
                        $http.post('./post.php?r=sendMessage&text=' + $('#submit_text').val()).then(function (response) {
                            if (response.data == 1) {
                                $('#submit_text').val('');
                            }
                        });
                    }
                }
            });

            setInterval(
                    function () {
                        if (int < 1) {
                            $('#chat-container').animate({scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
                            int++;
                        }
                        if ($('#chat-container').scrollTop() + $('#chat-container').innerHeight() >= $('#chat-container')[0].scrollHeight - 450) {
                            $('#chat-container').animate({scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
                        }
                    }
            , 2000);
        }]);

    app.controller('emojiController', ['$http', '$scope', '$sce', function ($http, $scope, $sce) {
            var module = this;

            $http.get('./post.php?r=obtenerEmojis').then(function (response) {
                $scope.emojis = $sce.trustAsHtml(response.data);
            });

        }]);

    app.controller('filesController', ['$http', '$scope', function ($http, $scope) {
            var module = this;
            $http.get('./post.php?r=obtenerCarpetas').then(function (response) {
                module.carpetas = response.data;
            });
            $scope.mostrarCarpeta = function (id) {
                $http.get('./post.php?r=obtenerUsuario&id=' + id).then(function (response) {
                    module.usuario = response.data;
                    $('#carpeta_name').html('Carpeta de ' + module.usuario.name + ' ' + module.usuario.surname);
                });

                $('#filesFolder').DataTable({
                    "ajax": "./post.php?r=obtenerCarpeta&id=" + id,
                    "columns": [
                        {"data": "name"},
                        {"data": "type"},
                        {"data": "time"},
                        {"data": "access"},
                        {"data": "acciones"}
                    ],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron archivos",
                        "sEmptyTable": "No existe ningún archivo",
                        "sInfo": "Mostrando del archivo _START_ al _END_ de un total de _TOTAL_",
                        "sInfoEmpty": "No hay archivos",
                        "sInfoFiltered": "(filtrados _MAX_ archivos)",
                        "sInfoPostFix": "",
                        "sSearch": "Buscar:",
                        "sUrl": "",
                        "sInfoThousands": ",",
                        "sLoadingRecords": "Cargando...",
                        "oPaginate": {
                            "sFirst": "Primero",
                            "sLast": "Último",
                            "sNext": "Siguiente",
                            "sPrevious": "Anterior"
                        },
                        "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                        }
                    },
                    "bLengthChange": false,
                    destroy: true
                });
                $('#mostrarCarpeta').modal();
            };
        }]);

    app.controller('mailsController', ['$http', '$scope', function ($http, $scope) {
            this.tab = 1;
            this.setTab = function (num) {
                this.tab = num;
            };
            this.isSet = function (num) {
                return this.tab == num;
            };
        }]);

    app.controller('TabController', ['$scope', '$http', function ($scope, $http) {
            this.tab = 1;
            this.setTab = function (num) {
                this.tab = num;
            };
            this.isSet = function (num) {
                return this.tab == num;
            };

            $scope.logout = function () {
                $http.get('./post.php?r=logout').then(function () {
                    window.location = "./";
                });
            };

            $scope.uploadPersonalFiles = function () {
                $('#uploadPersonalFiles').modal();
            };

            $scope.crearAlumno = function () {
                $('#crearAlumno').modal();
            };

            $scope.crearProfesor = function () {
                $('#crearProfesor').modal();
            };

            $scope.crearEventos = function () {
                $('#crearEventos').modal();
            };

        }]);

    app.controller('uploadPersonalFilesController', ['$http', '$scope', function ($http, $scope) {
            var module = this;

        }]);

    app.controller('configController', ['$http', '$scope', function ($http, $scope) {
            var module = this;

            $http.get('./post.php?r=obtenerPerfil').then(function (response) {
                module.perfil = response.data;
                $('#config_username').val(module.perfil.username);
                $('#config_name').val(module.perfil.name);
                $('#config_surname').val(module.perfil.surname);
            });

            $scope.guardarColor = function () {

                var r = confirm("¿Desea guardar los cambios?");
                if (r == true) {
                    $http.get('./post.php?r=cambiarColor&color=' + $('#colorTexto').val() + '&background=' + $('#colorFondo').val()).then(function (response) {
                        if (response.data == 1) {
                            window.location = "./";
                        }
                    });
                }
            };

            $scope.guardarPerfil = function () {

                if ($('#config_username').val() && $('#config_name').val() && $('#config_surname').val()) {
                    $http.get('./post.php?r=actualizarPerfil&username=' + $('#config_username').val() + '&password=' + $('#config_password').val() + '&name=' + $('#config_name').val() + '&surname=' + $('#config_surname').val()).then(function (response) {
                        if (response.data == 1) {
                            window.location = "./";
                        }
                    });
                } else {
                    alert("Todos los campos son obligatorios, excepto la contraseña. Si no se establece una contraseña continuará la actual.");
                }
            };
        }]);

    app.controller('dashController', ['$http', '$scope', function ($http, $scope) {
            var module = this;

            $('#panel_control').on('click', function () {

                $http.get('./post.php?r=contarAlumnos').then(function (response) {
                    module.cantidadAlumnos = response.data.cantidad;
                });

                $http.get('./post.php?r=contarProfesores').then(function (response) {
                    module.cantidadProfesores = response.data.cantidad;
                });

                $http.get('./post.php?r=contarMensajes').then(function (response) {
                    module.cantidadMensajes = response.data.cantidad;
                });

                $http.get('./post.php?r=contarEventos').then(function (response) {
                    module.cantidadEventos = response.data.cantidad;
                });
            });

            $scope.bloquear_aplicacion = function () {
                var r = confirm("¿Seguro que desea bloquear la aplicación?");
                if (r == true) {
                    $http.get('./post.php?r=bloquearAplicacion');
                }
            };

            $scope.desbloquear_aplicacion = function () {
                var r = confirm("¿Seguro que desea desbloquear la aplicación?");
                if (r == true) {
                    $http.get('./post.php?r=desbloquearAplicacion');
                }
            };

        }]);

})();

function resetear() {
    var r = confirm("¿Seguro que desea reiniciar la aplicación?");
    if (r == true) {
        var r = confirm("Esta acción borrará todos los datos de la aplicación. ¿Continuamos?");
        if (r == true) {
            var r = confirm("Los datós NO se podrán recuperar. ¿Está seguro de lo que hace?");
            if (r == true) {
                alert("Se van a vaciar todas las tablas, para volver a configurar la aplicación solo podrá iniciar sesión con el usuario root que se creó al instalar la aplicación.");
                $.ajax({
                    method: "POST",
                    url: "post.php",

                    data: {
                        r: 'resetear'
                    }
                })
                        .done(function (msg) {
                            if (msg == 1) {
                                location.reload();
                            }
                        });
            }
        }
    }
}

function scrolldown() {
    $('#chat-container').animate({scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
}

function recargarMails() {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'contarEmailsRecibidos'
        }
    })
            .done(function (msg) {
                if (msg != 0) {
                    $('#unreadMails_badge').text(msg);
                } else {
                    $('#unreadMails_badge').text('');
                }
                $('#unreadMails_label').text(msg);
                $('#personalMail').DataTable().ajax.reload(null, false);
                $('#personalMailEnviados').DataTable().ajax.reload(null, false);
            });
}

function viewMail(id, flag) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'obtenerEmail',
            id: id,
            flag: flag
        }
    })
            .done(function (msg) {
                var data = JSON.parse(msg);
                if (data.important != 0) {
                    $('#mail_subject').html('<i class="fa fa-star text-yellow"></i>&nbsp;&nbsp;' + data.subject);
                } else {
                    $('#mail_subject').html('<i class="fa fa-star-o text-yellow"></i>&nbsp;&nbsp;' + data.subject);
                }
                $('#mail_from').text('De: ' + data.name_from + ' ' + data.surname_from);
                $('#mail_to').text('Para: ' + data.name_to + ' ' + data.surname_to);
                $('#mail_date').text(data.date);
                $('#mail_text').html(data.text);
                $('#viewMailModal').modal();
                recargarMails();
            });
}

function enviarCrearMail() {
    if ($('#newMail_to').val() && $('#newMail_subject').val() && CKEDITOR.instances['newMail_text'].getData()) {
        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'enviarCrearMail',
                to: $('#newMail_to').val(),
                subject: $('#newMail_subject').val(),
                text: CKEDITOR.instances['newMail_text'].getData()
            }
        })
                .done(function (response) {
                    if (response == 1) {
                        $('#newMail_to').val('');
                        $('#newMail_subject').val('');
                        CKEDITOR.instances['newMail_text'].setData('');
                        $('#crearMail').modal('hide');
                        recargarMails();
                    }
                });
    } else {
        alert("Todos los campos son obligatorios");
    }
}

function crearEvento() {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'crearEvento',
            nombre: $('#evento_nombre').val(),
            descripcion: $('#evento_descripcion').val(),
            fecha: $('#evento_fecha').val()
        }
    })
            .done(function (response) {
                if (response == 1) {
                    $('#crearEventos').modal('hide');
                    $('#evento_nombre').val('');
                    $('#evento_descripcion').val('');
                    $('#evento_fecha').val('');
                    recargarEventos();
                }
            });
}

function editarEvento(id) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'obtenerEvento',
            id: id
        }
    })
            .done(function (response) {
                if(response){
                    var data = JSON.parse(response);
                    $('#evento_editar_id').val(data.id);
                    $('#evento_editar_nombre').val(data.title);
                    $('#evento_editar_descripcion').val(data.description);
                    $('#evento_editar_fecha').val(data.time);
                   $('#modalEditarEvento').modal();
               }
            });
}

function sendEditarEvento() {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'editarEvento',
            id: $('#evento_editar_id').val(),
            nombre: $('#evento_editar_nombre').val(),
            descripcion: $('#evento_editar_descripcion').val(),
            fecha: $('#evento_editar_fecha').val()
        }
    })
            .done(function (response) {
                if(response == 1){
                    $('#evento_editar_id').val('');
                    $('#evento_editar_nombre').val('');
                    $('#evento_editar_descripcion').val('');
                    $('#evento_editar_fecha').val('');
                    recargarEventos();
                    $('#modalEditarEvento').modal('hide');
               }
            });
}

function borrarEvento(id) {
    var r = confirm("¿Seguro que desea borrar el evento? Esta acción no se puede deshacer");
    if (r == true) {
        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'borrarEvento',
                id: id
            }
        })
                .done(function (response) {
                    if (response == 1) {
                        recargarEventos();
                    }
                });
    }

}

function openCrearMail() {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'obtenerPosiblesDestinatarios'
        }
    })
            .done(function (response) {
                if (response) {
                    $('#newMail_to').html(response);
                    $('#crearMail').modal();
                }
            });
}

function bloquearUsuario(id) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'estadoUsuario',
            estado: 1,
            id: id
        }
    })
            .done(function (msg) {
                if (msg == 1) {
                    recargarAlumnos();
                    recargarProfesores();
                }
            });
}

function desbloquearUsuario(id) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'estadoUsuario',
            estado: 0,
            id: id
        }
    })
            .done(function (msg) {
                if (msg == 1) {
                    recargarAlumnos();
                    recargarProfesores();
                }
            });
}

function sendEmoji(emoji) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'sendEmoji',
            emoji: emoji
        }
    })
            .done(function (msg) {
                if (msg == 1) {
                    $('#modalEmoji').modal('hide');
                }
            });
}
;

function borrarArchivo(id) {
    var r = confirm("¿Seguro que desea borrar el archivo? Esta acción no se puede deshacer");
    if (r == true) {
        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'borrarArchivo',
                id: id
            }
        })
                .done(function (msg) {
                    if (msg == 0) {
                        $('#modalEditarArchivo').modal('hide');
                        $('#personalFilesTable').DataTable().ajax.reload(null, false);
                    }
                    if (msg == 1) {
                        $('#personalFilesTable').DataTable().ajax.reload(null, false);
                    }
                });
    }
}

function recargarAlumnos() {
    $('#alumnosTable').DataTable().ajax.reload(null, false);
}

function recargarProfesores() {
    $('#profesorTable').DataTable().ajax.reload(null, false);
}

function recargarMensajes() {
    $('#mensajesTable').DataTable().ajax.reload(null, false);
}

function recargarEventos() {
    $('#eventosTable').DataTable().ajax.reload(null, false);
}

function editarArchivo(id) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'obtenerArchivo',
            id: id
        }
    })
            .done(function (msg) {
                var data = JSON.parse(msg);

                $('#file_id').val(data.id);
                $('#file_name').val(data.name);
                $('#file_access').val(data.access);
                $('#modalEditarArchivo').modal();
            });
}

function postEditarArchivo() {
    var r = confirm("¿Desea guardar los cambios?");
    if (r == true) {
        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'editarArchivo',
                id: $('#file_id').val(),
                name: $('#file_name').val(),
                access: $('#file_access').val()
            }
        })
                .done(function () {
                    $('#file_name').val('');
                    $('#file_access').val('');
                    $('#modalEditarArchivo').modal('hide');
                    $('#personalFilesTable').DataTable().ajax.reload(null, false);
                });
    }
}

function crearAlumno() {

    if (!$('#alumno_username').val()
            || !$('#alumno_pass').val()
            || !$('#alumno_name').val()
            || !$('#alumno_surnames').val()) {

        $('#modalCrearUsuario').html('<div class="alert alert-warning fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Todos los campos son obligatorios.</strong></div>');

    } else {

        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'crearAlumno',
                username: $('#alumno_username').val(),
                password: $('#alumno_pass').val(),
                name: $('#alumno_name').val(),
                surname: $('#alumno_surnames').val()
            }
        })
                .done(function (response) {
                    if (response == 1) {
                        $('#crearAlumno').modal('hide');
                        $('#alumno_username').val('');
                        $('#alumno_pass').val('');
                        $('#alumno_name').val('');
                        $('#alumno_surnames').val('');
                        $('#modalCrearUsuario').html();
                        $('#alumnosTable').DataTable().ajax.reload(null, false);
                    }
                });
    }
}

function editarUsuario(id) {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'editarUsuario',
            id: id
        }
    })
            .done(function (response) {
                var usuario = JSON.parse(response);
                $('#usuario_editar_id').val(usuario.id);
                $('#usuario_editar_username').val(usuario.username);
                $('#usuario_editar_pass').val('');
                $('#usuario_editar_name').val(usuario.name);
                $('#usuario_editar_surnames').val(usuario.surname);

                $('#modalEditarUsuario').html('');

                $('#editarUsuario').modal('show');
            });
}

function sendEditarUsuario() {
    if ($('#usuario_editar_username').val() && $('#usuario_editar_name').val() && $('#usuario_editar_surnames').val()) {
        var r = confirm("¿Desea guardar los cambios?");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "post.php",

                data: {
                    r: 'sendEditarUsuario',
                    id: $('#usuario_editar_id').val(),
                    username: $('#usuario_editar_username').val(),
                    name: $('#usuario_editar_name').val(),
                    surname: $('#usuario_editar_surnames').val()
                }
            })
                    .done(function (response) {
                        if (response == 1) {
                            $('#usuario_editar_id').val('');
                            $('#usuario_editar_username').val('');
                            $('#usuario_editar_name').val('');
                            $('#usuario_editar_surnames').val('');
                            $('#editarUsuario').modal('hide');
                            $('#alumnosTable').DataTable().ajax.reload(null, false);
                            $('#profesorTable').DataTable().ajax.reload(null, false);
                        }
                    });
        }
    } else {
        alert("Todos los campos son obligatorios");
    }
}

function borrarUsuario(id) {
    var r = confirm("¿Seguro que desea borrar el usuario? Esta acción no se puede deshacer");
    if (r == true) {
        var r = confirm("Todo lo referente al usuario quedará inaccesible, pese a crear otro usuario idéntico ¿Continuar?");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "post.php",

                data: {
                    r: 'borrarUsuario',
                    id: id
                }
            })
                    .done(function (response) {
                        if (response == 1) {
                            $('#alumnosTable').DataTable().ajax.reload(null, false);
                            $('#profesorTable').DataTable().ajax.reload(null, false);
                        }
                    });
        }
    }
}

function crearProfesor() {
    $.ajax({
        method: "POST",
        url: "post.php",

        data: {
            r: 'crearProfesor',
            username: $('#profesor_username').val(),
            password: $('#profesor_pass').val(),
            name: $('#profesor_name').val(),
            surname: $('#profesor_surnames').val()
        }
    })
            .done(function (response) {
                if (response == 1) {
                    $('#profesor_username').val('');
                    $('#profesor_pass').val('');
                    $('#profesor_name').val('');
                    $('#profesor_surnames').val('');
                    $('#crearProfesor').modal('hide');
                    $('#profesorTable').DataTable().ajax.reload(null, false);
                }
            });
}

function borrarMensajes() {
    var r = confirm("¿Seguro que desea borrar los mensajes? Esta acción no se puede deshacer");
    if (r == true) {
        var r = confirm("Para realizar esta acción se vaciará por completo la tabla, esto elimina TODOS los mensajes");
        if (r == true) {
            $.ajax({
                method: "POST",
                url: "post.php",

                data: {
                    r: 'borrarMensajes'
                }
            })
                    .done(function (response) {
                        if (response == 0) {
                            $('#mensajesTable').DataTable().ajax.reload(null, false);
                        }
                    });
        }
    }
}

function borrarMensaje(id) {
    var r = confirm("¿Seguro que desea borrar el mensaje? Esta acción no se puede deshacer");
    if (r == true) {
        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'borrarMensaje',
                id: id
            }
        })
                .done(function (response) {
                    if (response == 1) {
                        $('#mensajesTable').DataTable().ajax.reload(null, false);
                    }
                });
    }
}

function showYoutubeVideo(id) {

    $('#youtubeVideoEmbed').html('<iframe src="//www.youtube.com/embed/' + id + '"frameborder="0" allowfullscreen="" style="width: 100%!important;height: 520px!important;"/>');
    $('#modalYoutubeVideo').modal('show');
}

$(document).ready(function () {

    CKEDITOR.replace('newMail_text');

    recargarMails();

    $('#modalYoutubeVideo').on('hidden.bs.modal', function () {
        $('#youtubeVideoEmbed').html('');
    });

    $("#evento_fecha").datepicker({
        dateFormat: 'yy-mm-dd',
        yearRange: "-100:+0",
        changeMonth: true,
        changeYear: true,

        prevText: 'Ant.',
        nextText: 'Sig.',
        currentText: 'Hoy',
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        firstDay: 1
    });

    $("#evento_editar_fecha").datepicker({
        dateFormat: 'yy-mm-dd',
        yearRange: "-100:+0",
        changeMonth: true,
        changeYear: true,

        prevText: 'Ant.',
        nextText: 'Sig.',
        currentText: 'Hoy',
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        firstDay: 1
    });
    
    $('#personalMail').DataTable({
        "ajax": "./post.php?r=obtenerEmailsRecibidos",
        "columns": [
            {"data": "important"},
            {"data": "from"},
            {"data": "subject"},
            {"data": "date"}
        ],
        "order": [[3, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ correos",
            "sZeroRecords": "No se encontraron correos",
            "sEmptyTable": "No existe ningún correo",
            "sInfo": "Mostrando del correo _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay correos",
            "sInfoFiltered": "(filtrados _MAX_ correos)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": true
    });

    $('#personalMailEnviados').DataTable({
        "ajax": "./post.php?r=obtenerEmailsEnviados",
        "columns": [
            {"data": "important"},
            {"data": "to"},
            {"data": "subject"},
            {"data": "date"}
        ],
        "order": [[3, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ correos",
            "sZeroRecords": "No se encontraron correos",
            "sEmptyTable": "No existe ningún correo",
            "sInfo": "Mostrando del correo _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay correos",
            "sInfoFiltered": "(filtrados _MAX_ correos)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": true
    });

    $('#personalFilesTable').DataTable({
        "ajax": "./post.php?r=obtenerCarpetaPersonal",
        "columns": [
            {"data": "name"},
            {"data": "type"},
            {"data": "time"},
            {"data": "access"},
            {"data": "actions"}
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron archivos",
            "sEmptyTable": "No existe ningún archivo",
            "sInfo": "Mostrando del archivo _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay archivos",
            "sInfoFiltered": "(filtrados _MAX_ archivos)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": false
    });

    $('#alumnosTable').DataTable({
        "ajax": "./post.php?r=obtenerAlumnos",
        "columns": [
            {"data": "name"},
            {"data": "surname"},
            {"data": "username"},
            {"data": "status"},
            {"data": "acciones"}
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ alumnos",
            "sZeroRecords": "No se encontraron alumnos",
            "sEmptyTable": "No existe ningún alumno",
            "sInfo": "Mostrando del alumno _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay alumnos",
            "sInfoFiltered": "(filtrados _MAX_ alumnos)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": false
    });

    $('#profesorTable').DataTable({
        "ajax": "./post.php?r=obtenerProfesores",
        "columns": [
            {"data": "name"},
            {"data": "surname"},
            {"data": "username"},
            {"data": "status"},
            {"data": "acciones"}
        ],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ profesores",
            "sZeroRecords": "No se encontraron profesores",
            "sEmptyTable": "No existe ningún profesor",
            "sInfo": "Mostrando del profesor _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay profesores",
            "sInfoFiltered": "(filtrados _MAX_ profesores)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": false
    });

    $('#mensajesTable').DataTable({
        "ajax": "./post.php?r=obtenerMensajes",
        "columns": [
            {"data": "id"},
            {"data": "time"},
            {"data": "name"},
            {"data": "surname"},
            {"data": "text"},
            {"data": "acciones"}
        ],
        "order": [[0, "desc"]],
        "columnDefs": [{
                "targets": 1,
                "orderable": false
            },{
                "targets": 5,
                "orderable": false
            }],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ mensajes",
            "sZeroRecords": "No se encontraron mensajes",
            "sEmptyTable": "No existe ningún mensaje",
            "sInfo": "Mostrando del mensaje _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay mensajes",
            "sInfoFiltered": "(filtrados _MAX_ mensajes)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": false
    });

    $('#eventosTable').DataTable({
        "ajax": "./post.php?r=obtenerEventos",
        "columns": [
            {"data": "title"},
            {"data": "description"},
            {"data": "time"},
            {"data": "acciones"}
        ],
        "order": [[2, "desc"]],
        "columnDefs": [{
                "targets": 3,
                "orderable": false
            }],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ eventos",
            "sZeroRecords": "No se encontraron eventos",
            "sEmptyTable": "No existe ningún evento",
            "sInfo": "Mostrando del evento _START_ al _END_ de un total de _TOTAL_",
            "sInfoEmpty": "No hay eventos",
            "sInfoFiltered": "(filtrados _MAX_ eventos)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "bLengthChange": false
    });

    $('#colorTexto').colorpicker({
        customClass: 'colorpicker-2x',
        sliders: {
            saturation: {
                maxLeft: 200,
                maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        },
        format: 'rgba'
    })
            .on('changeColor', function (e) {
                $('#colorTexto').css('color', e.color.toString('rgba'));
                $('#colorFondo').css('color', e.color.toString('rgba'));
            });


    $('#colorFondo').colorpicker({
        customClass: 'colorpicker-2x',
        sliders: {
            saturation: {
                maxLeft: 200,
                maxTop: 200
            },
            hue: {
                maxTop: 200
            },
            alpha: {
                maxTop: 200
            }
        },
        format: 'rgba'
    })
            .on('changeColor', function (e) {
                $('#colorTexto').css('backgroundColor', e.color.toString('rgba'));
                $('#colorFondo').css('backgroundColor', e.color.toString('rgba'));
            });
});
