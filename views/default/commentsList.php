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
<?php if ($isShowEmptyBlock && empty($commentsList)): ?>
    <div class="well text-center">
        <a class="btn btn-primary btn-lg">Write comment</a>
    </div>
<?php endif;?>
<?php foreach ($commentsList as $num => $comment) : ?>
    <?php if ($num != $limit - 1): ?>
        <?php $this->render('commentsItemRoot', [
            'comment' => $comment
        ]) ?>
    <?php else: ?>
        <div class="text-center">
            <div class="btn btn-default btn-lg">Load more</div>
        </div>
    <?php endif ?>
<?php endforeach ?>

<?php \vendor\Application::getInstance()->assetsManager->beginJs() ?>
    js_defaut.init({
    });
<?php \vendor\Application::getInstance()->assetsManager->endJs() ?>