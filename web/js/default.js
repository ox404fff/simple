var js_defaut = function(obj) {

    var _params = {};

    obj.init = function(params) {
        _params = params || {};
    };

    return obj;

}({});