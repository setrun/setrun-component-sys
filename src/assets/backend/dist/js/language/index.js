;(function($, Setrun){
    var Component = {};

    Component.handlers = {
        'defaultHandler' : {
            el : '.switcher_default',
            ev : 'change'
        }
    };

    Component.autoload = true;

    Component.init = function () {

    };

    Component.defaultHandler = function (e) {
        var $el    = $(e.target),
            id     = $el.data('id'),
            state  = $el.is(':checked') ? 1 : 0,
            status = $("tr[data-key='" + id +"'] select option:selected").val();

        if (state === 0) {
            setTimeout(function () { $el.prop( "checked", true ); }, 300);
        } else {
            if (+status === 0) {
                setTimeout(function () { $el.prop( "checked", false ); }, 300);
            } else {
                this.setDefault(state, id, $el);
            }
        }
    };

    Component.setDefault = function (state, id, $el) {
        var options = {};
        options.onSuccess = function (res) {
            Setrun.helper().pjaxReload();
        };
        options.onError = function (res) {
            if (typeof $el  !== 'undefined') {
                if (state === 1) {
                    setTimeout(function () { $el.prop( "checked", false );}, 200);
                }
            }
        };
        Setrun.fn.request({id:id}, options, '');
    };

    Setrun.component('setrun/sys/backend/language/index', Component);

})(jQuery, Setrun);