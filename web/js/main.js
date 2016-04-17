var js_main = function(obj) {

    obj.error = function(message) {
        alert(message);
    };

    obj.success = function(message) {
        alert(message);
    };

    return obj;

}({});