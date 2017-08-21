;(function(win, $, doc){
    "use strict";

    var Setrun = {};

    Setrun.$doc       = $(doc); // Document
    Setrun.fn         = {};     // List of functions
    Setrun.plug       = {};     // List of plugins
    Setrun.components = {};     // List of actions
    Setrun.setup      = {};     // List of configuration
    Setrun.domready   = false;  // Dom not ready

    /**
     *
     * @param name
     * @returns {*}
     */
    Setrun.plugin = function (name) {
        if (typeof this.plug[name] !== 'undefined' && this.plug[name] !== null) {
            return this.plug[name];
        }
        throw new Exception('Plugin [' + name + '] is not found');
    };

    /**
     *
     * @param name
     * @returns {*}
     */
    Setrun.setPlugin = function (name, data) {
        if (typeof this.plug[name] === 'undefined' || this.plug[name] === null) {
            return this.plug[name] = data;
        }
        throw new Exception('Plugin [' + name + '] is already exists');
    };

    /**
     *
     * @param name
     * @returns {*}
     */
    Setrun.removePlugin = function (name) {
        if (typeof this.plug[name] !== 'undefined') {
            return this.plug[name] = null;
        }
    };

    /**
     * Data request (ajax)
     * @type {object}
     */
    Setrun.setup.request = {
        async    : true,
        type     : 'POST',
        dataType : 'json',
        url      : '',
        formData : false
    };

    /**
     * Helper to init extensions
     * @type {object}
     */
    Setrun.setup.component = {
        defaults         : {},
        handlers         : {},
        init             : function() {},
        boot             : function() {},
        autoload         : false,
        registerHandlers : function() {
            var that = this;
            $.map(that.handlers, function(value, key) {
                if (typeof that[key] === 'function') {
                    that.registerHandler(key, value);
                }
            });
        },
        registerHandler : function(name, obj) {
            var that = this,
                arr = [];
            arr = obj.length === undefined ? [obj] : obj;
            $.each(arr, function(key, value) {
                if (typeof value.el === 'undefined') {
                    $(document).on(value.ev, $.proxy(that[name], that));
                } else {
                    $(document).on(value.ev, value.el, $.proxy(that[name], that));
                }
            })
        },
        option : function() {
            if (arguments.length == 1) {
                return this.options[arguments[0]] || undefined;
            } else if (arguments.length == 2) {
                this.options[arguments[0]] = arguments[1];
            }
        }
    };

    /**
     * Register a new component in the Setrun
     * @param {object} body  Body of action
     * @param {string} name  Name of action
     * @return {function}
     */
    Setrun.component = function(name, body) {
        var that = this,
            fn   = function(element, options) {
                var $this    = this;
                this.element = element ? $(element) : null;
                this.options = $.extend(true, {}, this.defaults, options);

                if (this.element) {
                    this.element.data(name, this);
                }

                this.init();
                this.registerHandlers();

                that.$doc.trigger($.Event('init.Setrun.component'), [name, this]);

                return this;
            };

        $.extend(true, fn.prototype, Setrun.setup.component, body);

        that.components[name] = fn;

        this[name] = function() {

            var element, options;

            if (arguments.length) {

                switch (arguments.length) {
                    case 1:

                        if (typeof arguments[0] === 'string' || arguments[0].nodeType || arguments[0] instanceof jQuery) {
                            element = $(arguments[0]);
                        } else {
                            options = arguments[0];
                        }

                        break;
                    case 2:

                        element = $(arguments[0]);
                        options = arguments[1];
                        break;
                }
            }

            if (element && element.data(name)) {
                return element.data(name);
            }

            return (new Setrun.components[name](element, options));
        };

        if (Setrun.domready) {
            Setrun.component.boot(name);
        }
        return fn;
    };

    Setrun.component.boot = function(name) {

        if (Setrun.components[name].prototype && Setrun.components[name].prototype.boot && !Setrun.components[name].booted) {
            Setrun.components[name].prototype.boot.apply(Setrun, []);
            if (Setrun.components[name].prototype.autoload) {
                new Setrun[name]();
            }
            Setrun.components[name].booted = true;
        }
    };

    Setrun.component.bootComponents = function() {
        for (var component in Setrun.components) {
            Setrun.component.boot(component);
        }
    };

    /**
     * Check event
     * @return {void}
     */
    Setrun.$doc.on('DOMContentLoaded.Setrun', function(e) {
        Setrun.component.bootComponents();
        Setrun.domready = true;
        Setrun.$doc.trigger($.Event('ready.Setrun'));
    });

    /**
     * Check the exists of an element in an array
     *
     * @param {string} value  Value to check
     * @param {array}  array  Array to check
     *
     * @return {boolean}
     */
    Setrun.fn.inArray = function(value, array) {
        for (var i = 0; i < array.length; i++) {
            if (array[i] == value)
                return true;
        }
        return false;
    };

    /**
     * Check the data is in JSON format
     * @param  {string} str String to check
     * @return {boolean}
     */
    Setrun.fn.isJSON = function(str) {
        try {
            JSON.parse(str);
        } catch (e) {
            return false;
        }
        return true;
    };

    /**
     * Add value to the local storage
     * @param  {string} key   Key of local storage
     * @param  {string} value String to check
     * @return {void}
     */
    Setrun.fn.set = function(key, value) {
        if (typeof value === 'object') {
            value = JSON.stringify(value);
        }
        localStorage.setItem(key, value);
    };

    /**
     * Get value from the local storage
     * @param  {string} key Key of local storage
     * @return {mixed}
     */
    Setrun.fn.get = function(key) {
        if (typeof localStorage[key] !== 'undefined') {
            var value = localStorage.getItem(key);
            if (this.isJSON(value)) {
                value = JSON.parse(value);
            }
            return value;
        }
        return false;
    };

    /**
     * Update value from the local storage
     * @param  {string} key Key of local storage
     * @param  {object} obj Object to update
     * @return {void}
     */
    Setrun.fn.update = function(key, obj) {
        if (typeof obj === 'object' && typeof this.get(key) === 'object') {
            this.set(key, $.extend(this.get(key), obj));
        }
    };

    /**
     * Get the url not query string
     * @return {string}
     */
    Setrun.fn.url = function() {
        return location.href.split('?')[0];
    };


    /**
     * Get the parameter from query sring from url
     * @param  {string} param Parameter of url
     * @return {mixed}
     */
    Setrun.fn.paramQString = function(key) {
        var results = new RegExp('[\\?&]' + key + '=([^&#]*)').exec(location.search);
        if (!results) {
            return false;
        }
        return results[1] || false;
    };

    /**
     * Update query string from url
     * @param  {string} url   Url string
     * @param  {string} key   Key to replace
     * @param  {string} value Value to replace
     * @return {string}
     */
    Setrun.fn.updateQString = function(url, key, value) {
        var reg = new RegExp("([?|&])" + key + "=.*?(&|#|$)", "i"),
            up, separator;
        if (!url || url === '') {
            url = location.search;
        }
        if (url.match(reg)) {
            up = url.replace(reg, '$1' + key + "=" + value + '$2');
        } else {
            separator = url.indexOf('?') !== -1 ? "&" : "?";
            up = url + separator + key + "=" + value;
        }
        history.pushState(null, null, up);
        return up;
    };

    /**
     * Get the path url
     * @return {string}
     */
    Setrun.fn.pathUrl = function() {
        var href = location.pathname;
        return href.substr(1, href.length - 2);
    };

    /**
     * Redirect to url
     * @return {void}
     */
    Setrun.fn.redirect = function(url) {
        document.location.href = url;
    };

    /**
     * Generate a random string
     * @param {number} len Length characters
     * @return {string}
     */
    Setrun.fn.random = function(len) {
        var rand = '',
            len = typeof len === 'undefined' ? 12 : len,
            possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        for (var i = 0; i < len; i++) {
            rand += possible.charAt(Math.floor(Math.random() * possible.length));
        }
        return rand;
    };

    /**
     * Clear the hash of url
     * @return {void}
     */
    Setrun.fn.clearHash = function() {
        var doc = document,
            st = doc.body.scrollTop,
            sl = doc.body.scrollTop;
        doc.location.hash  = '';
        doc.body.scrollTop = st;
        doc.body.scrollTop = sl;
    };

    /**
     * Get meta data
     * @param {string} name Name of meta
     * @param {mixed}  def Default value
     * @return {mixed}
     */
    Setrun.fn.meta = function(name, def) {
        var value = $('meta[name="' + name + '"]').attr('content');
        if (typeof value !== 'undefined' && value.length > 0) {
            return value;
        } else if (typeof def !== 'undefined') {
            return def;
        }
        return false;
    };

    /**
     * Get language key
     * @param {string} key Key of Language
     * @return {mixed}
     */
    Setrun.fn.lang = function (key) {
        if (typeof Lang !== 'undefined' && Lang[key] !== 'undefined') {
            return Lang[key];
        }
        return false;
    };

    /**
     * Send ajax
     * @param {object} data     Data params to send
     * @param {object} options  Options of send
     * @param {string} url      Url of send
     * @return {void}
     */
    Setrun.fn.request = function(data, options, url) {
        if (typeof url === 'undefined') {
            url = location.href;
        }
        var that = this, setup = $.extend({}, Setrun.setup.request), request, ajax;
        if (typeof options === 'object') {
            $.extend(true, setup, options);
        } else if(typeof options === 'function') {
            setup.onSuccess = options;
        }

        setup.url = url;

        ajax = {
            type:      setup.type,
            url:       setup.url,
            dataType:  setup.dataType,
            async:     setup.async,
            data:      data,
            beforeSend: function(xhr) {
                if (typeof setup.onBefore === 'function') {
                    setup.onBefore(xhr)
                }
            },
            complete: function() {
                if (typeof setup.onComplete === 'function') {
                    setup.onComplete();
                }
            }
        };
        if (setup.formData) {
            $.extend(ajax, {
                contentType: false,
                processData: false
            });
        }
        request = $.ajax(ajax);
        request.done(function(res) {
            if (typeof res !== 'undefined' && typeof res.status !== 'undefined') {
                if (+res.status === 0) {
                    console.error("request: error");
                    typeof setup.onError === 'function' && setup.onError(res);
                } else if (+res.status === 1) {
                    console.info("request: success");
                    typeof setup.onSuccess === 'function' && setup.onSuccess(res);
                } else {
                    console.warn("request: undefined");
                    typeof setup.onUndefined === 'function' && setup.onUndefined(res);
                }
            } else if (res === null) {
                console.info("request: null");
            }
        });
        request.fail(function(res) {
            console.error("request: fail");
            typeof setup.onError === 'function' && setup.onError(res);
        });
        return request;
    };

    Setrun.fn.trim = function (text) {
        return text.replace(/^\s+/, '').replace(/\s+$/, '');
    };

    win.Setrun = Setrun;
    return Setrun;
})(window, jQuery, document);