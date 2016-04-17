var js_default = function(obj) {

    var _params = {};

    var $_createCommentPopup;
    var $_parentCommentInput;
    var $_currentCommentInput;
    var $_commentsContainer;

    obj.init = function(params) {
        _params = params || {};

        $_parentCommentInput = $(_params.selectors.parentCommentInput);
        $_currentCommentInput = $(_params.selectors.currentCommentInput);
        $_commentsContainer = $(_params.selectors.commentsContainer);

        $_createCommentPopup = $(_params.selectors.createCommentPopup);
    };


    obj.createComment = function(parentId) {
        var $createCommentForm = $_createCommentPopup.find("form");

        parentId = parentId || 0;

        $_createCommentPopup.modal("show");
        $_parentCommentInput.val(parentId);
        $_currentCommentInput.val(0);

        $createCommentForm.attr({action:_params.urls.createComment});
        $createCommentForm.find("input:first").focus();
    };


    obj.saveComment = function() {
        var $createCommentForm = $_createCommentPopup.find("form");

        var parentId = $_parentCommentInput.val();
        var action = $createCommentForm.attr("action");

        $.ajax({
            url: action,
            method: "POST",
            data: $createCommentForm.serializeArray(),
            dataType: "json"
        }).done(function(response) {

            if (response.status) {

                var $newForm = $(response.data.html.form).find("form");
                $createCommentForm.replaceWith($newForm);

                if (response.data.created) {

                    $_createCommentPopup.modal("hide");
                    $_commentsContainer.prepend(response.data.html.comment);
                    js_main.success(response.data.message);

                }
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