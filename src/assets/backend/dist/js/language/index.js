;(function($, Setrun){
    var Component = {};

    Component.handlers = {
        'defaultHandler' : {
            el : '.switcher_default',
            ev : 'change'
        },
        'statusHandler' : {
            el : '.switcher_status',
            ev : 'change'
        }
    };

    Component.autoload = true;

    Component.defaultHandler = function (e) {
        var $el    = $(e.target),
            id     = $el.data('id'),
            url    = $el.data('url'),
            state  = $el.is(':checked') ? 1 : 0;

        if (state === 0) {
            setTimeout(function () { $el.prop('checked', true ); }, 250);
        } else {
            this.default(id, url, $el);
        }
    };

    Component.statusHandler = function (e) {
        var $el    = $(e.target),
            id     = $el.data('id'),
            url    = $el.data('url'),
            status  = $el.is(':checked') ? 1 : 0;

            this.status(status, id, url, $el);
    };

    Component.status = function (status, id, url, $el) {
        var options = {};
        options.onSuccess = function (res) {
            Setrun.helpers().pjaxReload();
        };
        options.onError = function (res) {
            setTimeout(function () { $el.prop('checked', +status === 0 ? true : false ); }, 250)
            Setrun.helpers().notyErrors(res);
        };
        Setrun.fn.request({status:status}, options, url);
    };

    Component.default = function (id, url, $el) {
        var options = {};
        options.onSuccess = function (res) {
            Setrun.helpers().pjaxReload();
        };
        options.onError = function (res) {
            setTimeout(function () { $el.prop('checked', false ); }, 250)
            Setrun.helpers().notyErrors(res);
        };
        Setrun.fn.request({}, options, url);
    };

    Setrun.component('setrun/sys/backend/language/index', Component);
})(jQuery, Setrun);