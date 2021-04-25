/*
 notifyMe jQuery Plugin v1.0.0
 Copyright (c)2014 Sergey Serafimovich
 Licensed under The MIT License.
*/
(function(e) {
    e.fn.notifyMe = function(t) {
        var r = e(this);
        var i = e(this).find("input[name=email]");
        var s = e(this).attr("action");
        var o = e(this).find(".note");
        e(this).on("submit", function(t) {
            t.preventDefault();
            var h = i.val();
            var p = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            if (p.test(h)) {
                $(".message").removeClass("error bad-email success-full");
                $(".message").hide().html('').fadeIn();
                o.show();
                e.ajax({
                    type: "POST",
                    url: s,
                    data: {
                        email: h
                    },
                    dataType: "json",
                    error: function(e) {
                        o.hide();
                        if (e.status == 404) {
                            $(".message").hide().html('<p class="notify-valid"><i class="icon ion-close-round"></i> Сервис не доступен в данный момент. Пожалуйста, проверьте подключение к Интернету или повторите попытку позже.</p>').slideDown();
                        } else {
                            $(".message").hide().html('<p class="notify-valid"><i class="icon ion-close-round"></i> Оой, что-то пошло не так,пожалуйста, попытайтесь позже.</p>').fadeIn();
                        }
                    }
                }).done(function(e) {
                    o.hide();
                    if (e.status == "success") {
                        $(".message").removeClass("bad-email").addClass("success-full");
                        $(".message").hide().html('<p class="notify-valid"><i class="icon ion-checkmark-round"></i> Поздравляем, у Вас получилось, ждите от нас вестей!.</p>').fadeIn();
                    } else {
                        if (e.type == "ValidationError") {
                            $(".message").hide().html('<p class="notify-valid"><i class="icon ion-close-round"></i> Введите свой настоящий email адрес.</p>').fadeIn();
                        } else {
                            $(".message").hide().html('<p class="notify-valid"><i class="icon ion-close-round"></i> Оой, что-то пошло не так,пожалуйста, попытайтесь позже.</p>').fadeIn();
                        }
                    }
                })
            } else {
                $(".message").addClass("bad-email").removeClass("success-full");
                $(".message").hide().html('<p class="notify-valid"><i class="icon ion-close-round"></i>Хватит баловаться!</p>').fadeIn();
                o.hide();
            }

            // Reset and hide all messages on .keyup()
            $("#notifyMe input").keyup(function() {
                $(".message").fadeOut();
            });
        })
    }

    

})(jQuery)