<?php
/**
 * @var \vendor\View $this
 * @var string $style
 * @var array $comment
 */
?>
<div class="panel <?php echo $style ?>" id="js-comment-<?php echo $comment['id'] ?>">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $comment['name'] ?></h3>
    </div>
    <div class="panel-body">
        <?php echo $comment['message'] ?>
    </div>
    <div class="js-child-comments p-l_m p-r_m" style="display: none"></div>
    <div class="panel-footer">
        <div class="row">
            <div class="fl-left m-l_m">
                <button onclick="js_default.createComment(this, <?php echo $comment['id'] ?>)" class="btn btn-default btn-xs">Write comment</button>
                <?php if ($comment['count_children']): ?>
                    <button onclick="js_default.showChilds(this, <?php echo $comment['id'] ?>)" class="btn btn-default btn-xs m-l_m">Show comments (<?php echo $comment['count_children'] ?>)</button>
                <?php endif ?>
            </div>
            <div class="fl-right m-r_m">
                <?php echo $this->getFormatter()->dateInTime($comment['created_at']) ?>
            </div>
        </div>
    </div>
</div>