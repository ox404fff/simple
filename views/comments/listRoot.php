<?php
/**
 * @var \vendor\View $this
 * @var array $commentsList
 * @var int $limit Count comments requested
 * @var int $count Count comments received
 */
?>
<?php $fromId = 0; ?>
<?php foreach ($commentsList as $num => $comment) : ?>
    <?php if ($num != $limit - 1): ?>
        <?php $fromId = $comment['id']; ?>
        <?php $this->render('itemRoot', [
            'comment' => $comment,
            'style'   => 'panel-primary'
        ]) ?>
    <?php else: ?>
        <div class="text-center" id="js-more-comments-replace">
            <button class="btn btn-default btn-lg full-w" onclick="js_default.loadMore(this, <?php echo $fromId ?>)">Load more</button>
        </div>
    <?php endif ?>
<?php endforeach ?>