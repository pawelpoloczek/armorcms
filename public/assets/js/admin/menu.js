$(document).ready(function () {
    if ($('.menu-toggle').length) {
        $('.menu-toggle').click(function () {
            if ($(this).children('ul').length) {
                $(this).children('ul').slideToggle();
            }
        });
    }
});