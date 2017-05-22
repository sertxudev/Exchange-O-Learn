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
                if (e.keyCode === 13) {  //checks whether the pressed key is "Enter"
                    if ($('#submit_text').val()) {
//                        datos = {
//                            text: $('#submit_text').val()
//                        };
//                        $http.post('./post.php?r=sendMessage', datos).then(function (response) {
//                            if (response.data == 1) {
//                                $('#submit_text').val('');
//                            }
//                        });
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

                $http.get('./post.php?r=obtenerCarpeta&id=' + id).then(function (response) {
                    module.carpeta = response.data;
                    $('#carpeta_files').html(module.carpeta);
                    $('#mostrarCarpeta').modal();
                });
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
        }]);

})();

function bcolor(color) {
    $('#header-container').css("backgroundColor", color);
}

