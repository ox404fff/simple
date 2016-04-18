var js_default = function(obj) {

    var _params = {};

    var $_createCommentPopup;
    var $_commentsContainer;

    obj.init = function(params) {
        _params = params || {};

        $_commentsContainer = $(_params.selectors.commentsContainer);
        $_createCommentPopup = $(_params.selectors.createCommentPopup);

        $_createCommentPopup.on('hide.bs.modal', function (event) {
            _hideErrors($_createCommentPopup);
        });
    };


    obj.createComment = function(el, parentId) {
        var $createCommentForm = $_createCommentPopup.find("form");
        var $createCommentPopup = $(_params.selectors.createCommentPopup);
        var $parentCommentInput = $(_params.selectors.parentCommentInput);
        var $currentCommentInput = $(_params.selectors.currentCommentInput);


        parentId = parentId || 0;


        $createCommentPopup.modal("show");
        $parentCommentInput.val(parentId);
        $currentCommentInput.val(0);

        $createCommentForm.attr({action:_params.urls.create});
    };


    obj.saveComment = function() {
        var $createCommentForm = $_createCommentPopup.find("form");
        var $parentCommentInput = $(_params.selectors.parentCommentInput);

        var parentId = $parentCommentInput.val();
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

        _startLoading($el);

        $.ajax({
            url: _params.urls.more,
            method: "GET",
            data: {"from-id": fromId},
            dataType: "json"
        }).done(function(response) {

            _endLoading($el);

            $(_params.selectors.moreCommentsReplace).replaceWith(response.data.html);

        }).fail(function() {
            alert( "Something wrong, try to reload the page" );
        });
    };


    obj.showChilds = function(el, rootId) {

        var $el = $(el);

        _startLoading($el);

        $.ajax({
            url: _params.urls.childs,
            method: "GET",
            data: {"root-id": rootId},
            dataType: "json"
        }).done(function(response) {

            _endLoading($el);

            if (response.status) {
                var $childContainer = $("#js-comment-" + rootId.toString() + " .js-child-comments");
                $childContainer.html(response.data.html);
                $childContainer.slideDown(100);
            }

        }).fail(function() {
            alert( "Something wrong, try to reload the page" );
        });

    };

    var _backupLabel;

    var _startLoading = function($el) {
        _backupLabel = $el.html();
        $el.attr("disabled", "disabled");
        $el.html(_params.text.loading);
    };


    var _endLoading = function($el) {
        $el.html(_backupLabel);
        $el.removeAttr("disabled");
    };


    var _hideErrors = function($el) {
        $el.find("p.error").remove();
        $el.find(".error").removeClass("error");
    };

    return obj;

}({});