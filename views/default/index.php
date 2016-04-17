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
            <div class="btn btn-success btn-lg full-w" onclick="js_default.createComment()">Write comment</div>
        </div>
    </div>
</div>
<?php if ($isShowEmptyBlock && empty($commentsList)): ?>
    <div class="well well-lg text-center">
        <div class="btn btn-primary btn-lg" onclick="js_default.createComment()">Write comment</div>
    </div>
<?php else: ?>
    <div id="comments-container">

        <?php $this->render('commentsList', [
            'commentsList' => $commentsList,
            'limit'        => $limit,
            'count'        => $count,
        ]) ?>

    </div>
<?php endif;?>
<?php $this->render('createComment', $createCommentElementIds) ?>

<?php \vendor\Application::getInstance()->assetsManager->beginJs() ?>
    js_default.init({
        selectors: {
            createCommentPopup: "#<?php echo $createCommentElementIds['createCommentPopup'] ?>",
            parentCommentInput: "#<?php echo $createCommentElementIds['parentCommentInput'] ?>",
            currentCommentInput: "#<?php echo $createCommentElementIds['currentCommentInput'] ?>",
            commentsContainer: "#comments-container"
        },
        urls: {
            createComment: "/default/createComment",
            updateComment: "/default/updateComment",
        }
    });
<?php \vendor\Application::getInstance()->assetsManager->endJs() ?>