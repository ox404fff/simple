<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 * @var bool $isShowEmptyBlock Show block with empty text if comments is not fount
 * @var array $createCommentElementIds - Ids for create comment form
 */

\vendor\Application::getInstance()->assetsManager->addJsFile('<script src="/js/default.js"></script>');
?>
<div class="page-header">
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <h1 class="m-0">Simple comments tree</h1>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="btn btn-success btn-lg full-w" onclick="js_default.createComment()" id="js-create"<?php
                echo $count == 0 ? ' style="display:none"' : ''
            ?>>Write comment</div>
        </div>
    </div>
</div>
<div id="js-comments-container">
<?php if ($isShowEmptyBlock && empty($commentsList)): ?>
<div class="well well-lg text-center" id="js-empty">
    <div class="btn btn-primary btn-lg" onclick="js_default.createComment(this)">Write comment</div>
</div>
<?php else: ?>
<?php $this->render('listRoot', [
    'commentsList' => $commentsList,
    'limit'        => $limit,
    'count'        => $count,
]) ?>
<?php endif;?>
</div>

<?php $this->render('create', array_merge($createCommentElementIds, [
    'action' => '/comments/create',
    'errors' => [],
    'values' => [],
])) ?>

<?php \vendor\Application::getInstance()->assetsManager->beginJs() ?>
    js_default.init({
        selectors: {
            createCommentPopup: "#<?php echo $createCommentElementIds['createCommentPopup'] ?>",
            parentCommentInput: "#<?php echo $createCommentElementIds['parentCommentInput'] ?>",
            currentCommentInput: "#<?php echo $createCommentElementIds['currentCommentInput'] ?>",
            commentsContainer: "#js-comments-container",
            moreCommentsReplace: "#js-more-comments-replace",
            empty: "#js-empty",
            create: "#js-create",
            saveButton: "#js-save-button",
            commentTitle: "#js-comment-title",
            commentText: "#js-comment-text",
            popupCommentTitle: "#js-create-comment-title"
        },
        urls: {
            create: "/comments/create/",
            update: "/comments/update/",
            childs: "/comments/childs/",
            more: "/comments/more/",
            get: "/comments/getComment/"
        },
        text: {
            loading: "Loading...",
            refresh: "Refresh",
            create: "Add comment",
            update: "Save",
            createCommentTitle: "Create new comment",
            editCommentTitle: "Edit comment"
        },
        isRemoveEmptyAfterCreated: <?php echo (int) ($count == 0) ?>,
        isShowCreateBtnAfterCreated: <?php echo (int) ($count == 0) ?>
    });
<?php \vendor\Application::getInstance()->assetsManager->endJs() ?>