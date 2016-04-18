<?php
/**
 * @var \vendor\View $this
 * @var string $style
 * @var array $comment
 */
?>
<div class="panel <?php echo $style ?> level-<?php echo $comment['level'] ?>" id="js-comment-<?php echo $comment['id'] ?>">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $comment['name'] ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $comment['message'] ?>
    </div>
    <?php if (isset($comment['items'])): ?>
    <div class="js-child-comments p-l_m p-r_m">
        <?php $this->render('listTree', [
            'commentsList' => $comment['items']
        ]) ?>
    </div>
    <?php else: ?>
    <div class="js-child-comments p-l_m p-r_m" style="display: none"></div>
    <?php endif ?>
    <div class="panel-footer">
        <div class="row">
            <div class="fl-left m-l_m">
                <button onclick="js_default.createComment(this, <?php echo $comment['id'] ?>, <?php echo $comment['level'] ?>)" class="btn btn-default btn-xs">Write comment</button>
            </div>
            <div class="fl-right m-r_m">
                <?php echo $this->getFormatter()->dateInTime($comment['created_at']) ?>
            </div>
        </div>
    </div>
</div>