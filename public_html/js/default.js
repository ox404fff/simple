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


    obj.deleteComment = function(el, id) {

    };


    obj.editComment = function(el, id) {

        var $el = $(el);

        _startLoading($el);

        $.ajax({
            url: _params.urls.get,
            method: "GET",
            data: {"id": id},
            dataType: "json"
        }).done(function(response) {

            _endLoading($el);

            var $createCommentForm = $_createCommentPopup.find("form");
            var $createCommentPopup = $(_params.selectors.createCommentPopup);
            var $currentCommentInput = $(_params.selectors.currentCommentInput);
            var $parentCommentInput = $(_params.selectors.parentCommentInput);

            $(_params.selectors.commentTitle).val(response.data.name);
            $(_params.selectors.commentText).html(response.data.message);

            $(_params.selectors.popupCommentTitle).html(_params.text.editCommentTitle);
            $(_params.selectors.saveButton).html(_params.text.update);

            $createCommentPopup.modal("show");
            $currentCommentInput.val(id);
            $parentCommentInput.val(0);

            $createCommentForm.attr({action:_params.urls.update});

        }).fail(function() {
            alert( "Something wrong, try to reload page" );
        });
    };


    obj.createComment = function(el, parentId) {
        var $createCommentForm = $_createCommentPopup.find("form");
        var $createCommentPopup = $(_params.selectors.createCommentPopup);
        var $parentCommentInput = $(_params.selectors.parentCommentInput);
        var $currentCommentInput = $(_params.selectors.currentCommentInput);

        $(_params.selectors.commentTitle).val("");
        $(_params.selectors.commentText).html("");

        $(_params.selectors.popupCommentTitle).html(_params.text.createCommentTitle);
        $(_params.selectors.saveButton).html(_params.text.create);

        parentId = parentId || 0;

        $createCommentPopup.modal("show");
        $parentCommentInput.val(parentId);
        $currentCommentInput.val(0);

        $createCommentForm.attr({action:_params.urls.create});
    };


    obj.saveComment = function() {
        var $createCommentForm = $_createCommentPopup.find("form");
        var $parentCommentInput = $(_params.selectors.parentCommentInput);
        var $currentCommentInput = $(_params.selectors.currentCommentInput);

        var parentId = $parentCommentInput.val();
        var currentId = $currentCommentInput.val();
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

                if (response.data.saved) {

                    _refreshControlsAfterCreate();

                    if (currentId != 0) {

                        var $currentCommentContainer = $("#js-comment-" + currentId);

                        $currentCommentContainer.find(".js-comment-title:first").html(response.data.comment.name);
                        $currentCommentContainer.find(".js-comment-text:first").html(response.data.comment.message);

                    } else {

                        if (parentId != 0) {
                            obj.showChilds(null, parentId, response.data.createdId);
                        } else {
                            $_commentsContainer.prepend(response.data.html.comment);
                        }
                    }

                    $_createCommentPopup.modal("hide");
                    js_main.success(response.data.message);
                }
            } else {
                js_main.error(response.error);
            }

        }).fail(function() {
            alert( "Something wrong, try to reload page" );
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
            alert( "Something wrong, try to reload page" );
        });
    };


    obj.showChilds = function(el, parentId, newNodeId) {

        var $el = $(el);

        newNodeId = newNodeId || 0;

        _startLoading($el);

        $.ajax({
            url: _params.urls.childs,
            method: "GET",
            data: {"parent-id": parentId, "new-node-id": newNodeId},
            dataType: "json"
        }).done(function(response) {

            _endLoading($el);

            if (response.status) {
                var $childContainer = $("#js-comment-" + parentId.toString() + " .js-child-comments");
                $childContainer.html(response.data.html);

                var $rootCountContainer = $("#js-count-" + response.data.rootId.toString());
                $rootCountContainer.show();
                $rootCountContainer.html(_params.text.refresh + " (" + response.data.countNodesInRoot.toString() + ")");

                $childContainer.slideDown(100);
            }

        }).fail(function() {
            alert( "Something wrong, try to reload page" );
        });

    };


    var _backupLabel;

    var _refreshControlsAfterCreate = function() {
        if (_params.isRemoveEmptyAfterCreated) {
            $(_params.selectors.empty).remove();
            _params.isRemoveEmptyAfterCreated = 0;
        }

        if (_params.isShowCreateBtnAfterCreated) {
            $(_params.selectors.create).fadeIn(500);
            _params.isShowCreateBtnAfterCreated = 0;
        }
    };

    var _startLoading = function($el) {
        if ($el != null) {
            _backupLabel = $el.html();
            $el.attr("disabled", "disabled");
            $el.html(_params.text.loading);
        }
    };


    var _endLoading = function($el) {
        if ($el != null) {
            $el.html(_backupLabel);
            $el.removeAttr("disabled");
        }
    };


    var _hideErrors = function($el) {
        $el.find("p.error").remove();
        $el.find(".error").removeClass("error");
    };

    return obj;

}({});