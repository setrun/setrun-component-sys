;(function($, Setrun){
    var Component = {};

    Component.init = function () {
        $('#languageform-icon').chosen('destroy');
        $('#languageform-icon').chosenImage({
            placeholder_text_single:   ' ',
            placeholder_text_multiple: ' ',
        });
    };

    Setrun.component('backend-language-form', Component);
})(jQuery, Setrun);