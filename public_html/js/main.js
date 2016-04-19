var js_main = function(obj) {

    obj.error = function(message) {
        obj.alert("alert-danger", message, 5000);
    };


    obj.success = function(message) {
        obj.alert("alert-success", message, 1000);
    };


    obj.alert = function(type, message, timeout) {
        var $alertContainer = $("#js-alert-cont");
        var $alert = $("#js-alert");

        $alertContainer.slideUp(100);

        $alertContainer.find(".message").html(message);

        $alert.attr("class", "alert " + type);
        $alertContainer.slideDown(100);

        setTimeout(function() {
            $alertContainer.slideUp(100);
        }, timeout);
    };

    return obj;

}({});