<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 */
?>
<?php foreach ($commentsList as $comment) : ?>
    <?php $this->render('itemTree', [
        'comment' => $comment,
        'style'   => 'panel-default'
    ]) ?>
<?php endforeach ?>