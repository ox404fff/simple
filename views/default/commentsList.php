<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 */

\vendor\Application::getInstance()->assetsManager->addJsFile('<script src="/js/default.js"></script>');
?>
<?php foreach ($commentsList as $comment) : ?>
    <?php $this->render('commentsItem', [
        'comment' => $comment
    ]) ?>
<?php endforeach ?>

<?php \vendor\Application::getInstance()->assetsManager->beginJs() ?>
    js_defaut.init({
    });
<?php \vendor\Application::getInstance()->assetsManager->endJs() ?>