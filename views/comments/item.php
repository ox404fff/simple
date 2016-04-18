<?php
/**
 * @var \vendor\View $this
 * @var string $style
 * @var array $comment
 */
?>
<div class="panel <?php echo $style ?>" id="js-comment-<?php echo $comment['id'] ?>" style="margin-left: <?php echo 20 * ($comment['level'] - 1) ?>px">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $comment['name'] ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $comment['message'] ?>
    </div>
    <div class="js-child-comments" style="display: none"></div>
    <div class="panel-footer">
        <div class="row">
            <div class="fl-left m-l_m">
                <button onclick="js_default.createComment(this, <?php echo $comment['id'] ?>)" class="btn btn-default btn-xs">Write comment</button>
            </div>
            <div class="fl-right m-r_m">
                <?php echo $this->getFormatter()->dateInTime($comment['created_at']) ?>
            </div>
        </div>
    </div>
</div>