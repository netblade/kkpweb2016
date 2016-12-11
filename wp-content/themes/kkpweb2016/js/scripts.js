/* Frontpage */
$(function () {
    $('.event_header').hover(
        function (e) {
            $('.event_dialog').hide();
            $('.event_dialog', this).show();
        },
        function (e) {
            $('.event_dialog').hide();
        }
    );
});
/* / Frontpage*/