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
                    $('#mostrarEvento').modal();
                });
            };
        }]);

    app.controller('chatController', ['$http', function ($http) {
            var module = this;
            var int = 0;

            setInterval(
                    function () {
                        $http.get('./post.php?r=obtenerMessages').then(function (response) {
                            module.messages = response.data;
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
                        if ($('#chat-container').scrollTop() + $('#chat-container').innerHeight() >= $('#chat-container')[0].scrollHeight - 500) {
                            $('#chat-container').animate({scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
                        }
                    }
            , 2000);
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
                        {"data": "access"}
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
                console.log('logout');
                $http.get('./post.php?r=logout').then(function () {
                    window.location = "./";
                });
            };

            $scope.uploadPersonalFiles = function () {
                $('#uploadPersonalFiles').modal();
            };

        }]);

    app.controller('uploadPersonalFilesController', ['$http', '$scope', function ($http, $scope) {
            var module = this;

            $scope.borrarArchivo = function (id) {
                console.log(id);
                $http.get('./post.php?r=borrarArchivoPersonal&id=' + id).then(function (response) {
                    module.files = response.data;
                    console.log(response);
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
                console.log(msg);
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

$(document).ready(function () {

    $("#config_birthday").datepicker({dateFormat: 'yy-mm-dd'});

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
    function mostrarCarpeta(id) {

    }

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