var js_default = function(obj) {

    var _params = {};

    var $_createCommentPopup;
    var $_parentCommentInput;
    var $_currentCommentInput;
    var $_createCommentForm;
    var $_commentsContainer;

    obj.init = function(params) {
        _params = params || {};

        $_parentCommentInput = $(_params.selectors.parentCommentInput);
        $_currentCommentInput = $(_params.selectors.currentCommentInput);
        $_commentsContainer = $(_params.selectors.commentsContainer);

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

        var parentId = $_parentCommentInput.val();

        $.ajax({
            url: $_createCommentForm.attr("action"),
            method: "POST",
            data: $_createCommentForm.serializeArray(),
            dataType: "json"
        }).done(function(response) {

            if (response.status) {

                $_createCommentPopup.modal("hide");

                js_main.success(response.data.message);

                $_commentsContainer.prepend(response.data.html.comment);

            } else {
                js_main.error(response.error);
            }

        }).fail(function() {
            alert( "Something wrong, try to reload the page" );
        });

    };


    obj.loadMore = function(fromId) {


    };

    return obj;

}({});