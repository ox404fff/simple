var js_default = function(obj) {

    var _params = {};

    var $_createCommentPopup;
    var $_parentCommentInput;
    var $_currentCommentInput;
    var $_createCommentForm;

    obj.init = function(params) {
        _params = params || {};

        $_parentCommentInput = $(_params.selectors.parentCommentInput);
        $_currentCommentInput = $(_params.selectors.currentCommentInput);

        $_createCommentPopup = $(_params.selectors.createCommentPopup);
        $_createCommentForm = $_createCommentPopup.find("form");
    };

    obj.createComment = function(parentId) {
        parentId = parentId || 0;

        $_createCommentForm.attr({action:_params.urls.createComment});
        $_createCommentPopup.modal("show");
        $_parentCommentInput.val(parentId);
        $_currentCommentInput.val(0);
    };


    obj.saveComment = function() {

        $.ajax({
            url: $_createCommentForm.attr("action"),
            method: "POST",
            data: $_createCommentForm.serializeArray(),
            dataType: "json"
        }).done(function(response) {

            if (response.status) {

            } else {
                js_main.error(response);
            }

        }).fail(function() {
            alert( "Something wrong, try to reload the page" );
        });

    };


    obj.loadMore = function(fromId) {


    };

    return obj;

}({});