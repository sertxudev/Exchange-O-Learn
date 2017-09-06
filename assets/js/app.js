(function () {
    var app = angular.module('eol', []);

    app.controller('colorController', ['$http', function ($http) {
        var module = this;
        $http.get('./post.php?r=obtenerColor').then(function (response) {
            module.custom = response.data;
        });
    }]);

    app.controller('eventsController', ['$http', '$scope', function ($http, $scope) {
        var module = this;
        $http.get('./post.php?r=obtenerEventosFuturos').then(function (response) {
            module.events = response.data;
        });

        $scope.mostrarEvento = function (id) {
            $http.get('./post.php?r=obtenerEvento&id=' + id).then(function (response) {
                module.evento = response.data;
                $('#event_title').html(response.data.title + ' - ' + response.data.time);
                $('#event_description').html(response.data.description);
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
                    $('#chat-container').animate({ scrollTop: $('#chat-container').prop("scrollHeight") }, 1000);
                    int++;
                }
                if ($('#chat-container').scrollTop() + $('#chat-container').innerHeight() >= $('#chat-container')[0].scrollHeight - 200) {
                    $('#chat-container').animate({ scrollTop: $('#chat-container').prop("scrollHeight") }, 1000);
                }
            }
            , 2000);
    }]);

    app.controller('emojiController', ['$http', '$scope', function ($http, $scope) {
        var module = this;
        
        $http.get('./post.php?r=obtenerEmojis').then(function (response) {
            module.emojis = response.data;
        });

        $scope.sendEmoji = function (emoji) {
            $http.post('./post.php?r=sendMessage&text=' + emoji).then(function (response) {
                if (response.data == 1) {
                    $('#modalEmoji').modal('hide');
                }
            });
        };

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
                    { "data": "name" },
                    { "data": "type" },
                    { "data": "time" },
                    { "data": "access" }
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
            //                $http.get('./post.php?r=obtenerCarpeta&id=' + id).then(function (response) {
            //                    module.carpeta = response.data;
            //                    $('#carpeta_files').html(module.carpeta);
            $('#mostrarCarpeta').modal();
            //                });
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

        $scope.recargarMensajes = function () {
            $('#mensajesTable').DataTable().ajax.reload(null, false);
        };

        $scope.crearEventos = function () {
            $('#crearEventos').modal();
        };

    }]);

    app.controller('uploadPersonalFilesController', ['$http', '$scope', function ($http, $scope) {
        var module = this;

        $scope.borrarArchivo = function (id) {
            $http.get('./post.php?r=borrarArchivoPersonal&id=' + id).then(function (response) {
                module.files = response.data;
            });
        };
    }]);

    app.controller('configController', ['$http', '$scope', function ($http, $scope) {
        var module = this;

        $http.get('./post.php?r=obtenerPerfil').then(function (response) {
            module.perfil = response.data;
            $('#config_username').val(module.perfil.username);
            $('#config_birthday').val(module.perfil.birthday);
            $('#config_name').val(module.perfil.name);
            $('#config_surname').val(module.perfil.surname);
        });

        $scope.guardarColor = function () {
            $http.get('./post.php?r=cambiarColor&color=' + $('#colorTexto').val() + '&background=' + $('#colorFondo').val()).then(function (response) {
                if (response.data == 1) {
                    window.location = "./";
                }
            });
        };

        $scope.guardarPerfil = function () {
            $http.get('./post.php?r=actualizarPerfil&username=' + $('#config_username').val() + '&password=' + $('#config_password').val() + '&birthday=' + $('#config_birthday').val() + '&name=' + $('#config_name').val() + '&surname=' + $('#config_surname').val()).then(function (response) {
                if (response.data == 1) {
                    window.location = "./";
                }
            });
        };
    }]);

    app.controller('dashController', ['$http', '$scope', function ($http, $scope) {
        var module = this;

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

        $scope.bloquear_aplicacion = function () {
            $http.get('./post.php?r=bloquearAplicacion').then(function (response) {
            });
        };

        $scope.guardarPerfil = function () {
            $http.get('./post.php?r=actualizarPerfil&username=' + $('#config_username').val() + '&password=' + $('#config_password').val() + '&birthday=' + $('#config_birthday').val() + '&name=' + $('#config_name').val() + '&surname=' + $('#config_surname').val()).then(function (response) {
                if (response.data == 1) {
                    window.location = "./";
                }
            });
        };
    }]);

})();
function borrarArchivo(id) {
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
        .done(function (msg) {
            if (msg == 0) {
                $('#file_name').val('');
                $('#file_access').val('');
                $('#modalEditarArchivo').modal('hide');
                $('#personalFilesTable').DataTable().ajax.reload(null, false);
            }
        });
}

function crearAlumno() {
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
                $('#alumno_username').val('');
                $('#alumno_pass').val('');
                $('#alumno_name').val('');
                $('#alumno_surnames').val('');
                $('#crearAlumno').modal('hide');
                $('#alumnosTable').DataTable().ajax.reload(null, false);
            }
        });
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
            $('#usuario_editar_birthday').val(usuario.birthday);
            
             $('#modalEditarUsuario').html('');
            
            $('#editarUsuario').modal('show');
        });
}

function sendEditarUsuario() {

    if (!$('#usuario_editar_username').val()
        || !$('#usuario_editar_name').val()
        || !$('#usuario_editar_surnames').val()
        || !$('#usuario_editar_birthday').val()) {

        $('#modalEditarUsuario').html('<div class="alert alert-warning fade in alert-dismissable"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Todos los campos son obligatorios.</strong></div>');

    } else {

        $.ajax({
            method: "POST",
            url: "post.php",

            data: {
                r: 'sendEditarUsuario',
                id: $('#usuario_editar_id').val(),
                username: $('#usuario_editar_username').val(),
                name: $('#usuario_editar_name').val(),
                surname: $('#usuario_editar_surnames').val(),
                birthday: $('#usuario_editar_birthday').val()
            }
        })
            .done(function (response) {
                if (response == 1) {
                    $('#usuario_editar_id').val('');
                    $('#usuario_editar_username').val('');
                    $('#usuario_editar_name').val('');
                    $('#usuario_editar_surnames').val('');
                    $('#usuario_editar_birthday').val('');
                    $('#editarUsuario').modal('hide');
                    $('#alumnosTable').DataTable().ajax.reload(null, false);
                    $('#profesorTable').DataTable().ajax.reload(null, false);
                }
            });
    }
}

function borrarUsuario(id) {
    $('#borrarUsuarioConfirmar').modal();
    $('#idBorrarUsuario').val(id);
}

function borrarUsuarioConfirmar(id){
    $('#borrarUsuarioConfirmar').modal('hide');
    
    id = $('#idBorrarUsuario').val();
    
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

function borrarMensaje(id) {
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

function showYoutubeVideo(id) {

    $('#youtubeVideoEmbed').html('<iframe src="http://www.youtube.com/embed/' + id + '"frameborder="0" allowfullscreen="" style="width: 100%!important;height: 520px!important;"/>');
    $('#modalYoutubeVideo').modal('show');
}

$(document).ready(function () {

    $('#modalYoutubeVideo').on('hidden.bs.modal', function () {
        $('#youtubeVideoEmbed').html('');
    });

    $("#config_birthday").datepicker({
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
    
    $("#usuario_editar_birthday").datepicker({
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
        "ajax": "./post.php?r=obtenerMails",
        "columns": [
            { "data": "eliminar" },
            { "data": "important" },
            { "data": "from" },
            { "data": "subject" },
            { "data": "date" }
        ],
        "order": [[4, "desc"]],
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
        "bLengthChange": false
    });

    $('#personalFilesTable').DataTable({
        "ajax": "./post.php?r=obtenerCarpetaPersonal",
        "columns": [
            { "data": "name" },
            { "data": "type" },
            { "data": "time" },
            { "data": "access" },
            { "data": "actions" }
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
            { "data": "name" },
            { "data": "surname" },
            { "data": "username" },
            { "data": "birthday" },
            { "data": "acciones" }
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
            { "data": "name" },
            { "data": "surname" },
            { "data": "username" },
            { "data": "birthday" },
            { "data": "acciones" }
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
            { "data": "id" },
            { "data": "time" },
            { "data": "name" },
            { "data": "surname" },
            { "data": "text" },
            { "data": "acciones" }
        ],
        "order": [[0, "desc"]],
        "columnDefs": [{
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
            { "data": "title" },
            { "data": "description" },
            { "data": "time" },
            { "data": "acciones" }
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