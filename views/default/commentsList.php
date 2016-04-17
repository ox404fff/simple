<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 * @var bool $isShowEmptyBlock Show block with empty text if comments is not fount
 */

\vendor\Application::getInstance()->assetsManager->addJsFile('<script src="/js/default.js"></script>');
?>
<div class="page-header">
    <div class="row">
        <div class="col-xs-12 col-md-9">
            <h1 class="m-0">Simple comments tree</h1>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="btn btn-primary btn-lg full-w" onclick="js_default.createComment()">Write comment</div>
        </div>
    </div>
</div>
<?php if ($isShowEmptyBlock && empty($commentsList)): ?>
    <div class="well well-lg text-center">
        <div class="btn btn-primary btn-lg" onclick="js_default.createComment()">Write comment</div>
    </div>
<?php else: ?>
    <div id="comments-container">
    <?php foreach ($commentsList as $num => $comment) : ?>
        <?php if ($num != $limit - 1): ?>
            <?php $this->render('commentsItemRoot', [
                'comment' => $comment,
                'style'   => 'panel-info'
            ]) ?>
        <?php else: ?>
            <div class="text-center">
                <div class="btn btn-default btn-lg" onclick="js_default.loadMore(<?php echo $comment['id'] ?>)">Load more</div>
            </div>
        <?php endif ?>
    <?php endforeach ?>
    </div>
<?php endif;?>
<?php $this->render('createComment', [
    'createCommentPopup'  => 'js-create-comment-popup',
    'parentCommentInput'  => 'js-parent-comment-input',
    'currentCommentInput' => 'js-current-comment-input',
]) ?>

<?php \vendor\Application::getInstance()->assetsManager->beginJs() ?>
    js_default.init({
        selectors: {
            createCommentPopup: "#js-create-comment-popup",
            parentCommentInput: "#js-parent-comment-input",
            currentCommentInput: "#js-current-comment-input",
            commentsContainer: "#comments-container"
        },
        urls: {
            createComment: "/default/createComment",
            updateComment: "/default/updateComment",
        }
    });
<?php \vendor\Application::getInstance()->assetsManager->endJs() ?>