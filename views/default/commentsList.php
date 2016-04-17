<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 */
?>
<?php foreach ($commentsList as $comment) : ?>
    <?php $this->render('commentsItem', [
        'comment' => $comment
    ]) ?>
<?php endforeach ?>