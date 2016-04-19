<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 * @var int $createdNodeId id just created node
 */
?>
<?php foreach ($commentsList as $comment) : ?>
    <?php $this->render('itemTree', [
        'comment' => $comment,
        'style'   => $comment['id'] == $createdNodeId ? 'panel-info' : 'panel-default'
    ]) ?>
<?php endforeach ?>