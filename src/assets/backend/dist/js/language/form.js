;(function($, Setrun){
    var Component = {};

    Component.autoload = true;

    Component.handlers = {

    };

    Component.init = function () {
        $('#language-icon').chosen('destroy');
        $('#language-icon').chosenImage({
            placeholder_text_single:   ' ',
            placeholder_text_multiple: ' ',
        });
    };

    Setrun.component('setrun/sys/backend/language/form', Component);
})(jQuery, Setrun);