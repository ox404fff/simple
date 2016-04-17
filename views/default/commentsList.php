<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 */
?>
<?php foreach ($commentsList as $num => $comment) : ?>
    <?php if ($num != $limit - 1): ?>
        <?php $this->render('commentItemRoot', [
            'comment' => $comment,
            'style'   => 'panel-primary'
        ]) ?>
    <?php else: ?>
        <div class="text-center">
            <div class="btn btn-default btn-lg" onclick="js_default.loadMore(<?php echo $comment['id'] ?>)">Load more</div>
        </div>
    <?php endif ?>
<?php endforeach ?>