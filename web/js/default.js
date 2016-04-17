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

        $_createCommentPopup.on('hide.bs.modal', function (event) {
            _hideErrors($_createCommentPopup);
        });
    };


    obj.createComment = function(parentId) {
        var $createCommentForm = $_createCommentPopup.find("form");

        parentId = parentId || 0;

        $_createCommentPopup.modal("show");
        $_parentCommentInput.val(parentId);
        $_currentCommentInput.val(0);

        $createCommentForm.attr({action:_params.urls.create});
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

                    if (_params.isRemoveEmptyAfterCreated) {
                        $(_params.selectors.empty).remove();
                        _params.isRemoveEmptyAfterCreated = 0;
                    }

                    if (_params.isShowCreateBtnAfterCreated) {
                        $(_params.selectors.create).fadeIn(500);
                        _params.isShowCreateBtnAfterCreated = 0;
                    }

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


    obj.loadMore = function(el, fromId) {
        var $el = $(el);

        $el.attr("disabled", "disabled");

        var backupLabel = $el.html();
        $el.html(_params.text.loading);

        $.ajax({
            url: _params.urls.more,
            method: "GET",
            data: {"from-id": fromId},
            dataType: "json"
        }).done(function(response) {

            $el.html(backupLabel);
            $el.removeAttr("disabled");

            $(_params.selectors.moreCommentsReplace).replaceWith(response.data.html);

        }).fail(function() {
            alert( "Something wrong, try to reload the page" );
        });
    };


    var _hideErrors = function($el) {
        $el.find("p.error").remove();
        $el.find(".error").removeClass("error");
    };

    return obj;

}({});