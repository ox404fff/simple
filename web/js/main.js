var js_main = function(obj) {

    obj.error = function(response) {
        alert(response.error);
    };

    return obj;

}({});