(function () {
    var app = angular.module('eol', []);
    app.controller('eventsController', ['$http', function ($http) {
            var module = this;
            $http.get('./post.php?r=obtenerEventosFuturos').then(function (response) {
                module.events = response.data;
            });
        }]);

    app.controller('chatController', ['$http', function ($http) {
            var module = this;

            setInterval(
                    function () {
                        $http.get('./post.php?r=obtenerMessages').then(function (response) {
                            module.messages = response.data;
                            $('#chat-container').animate({ scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
                        });

                        $('#chat-container').on('scroll', function () {
                            if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight - 1 ) {
                                $('#chat-container').animate({ scrollTop: $('#chat-container').prop("scrollHeight")}, 1000);
                            }
                        });
                    }
            , 1500);

            $('#submit_button').on('click', function () {
                $http.get('./post.php?r=sendMessage&text=' + $('#submit_text').val()).then(function (response) {
                    if (response.data == 1) {
                        $('#submit_text').val('');
                    }
                });
            });

        }]);
})();