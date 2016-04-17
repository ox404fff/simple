<?php
/**
 * @var \vendor\View $this
 * @var array $comment
 */
?>
<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo $comment['name'] ?></h3>
    </div>
    <div class="panel-body">
        Panel content
        <?php echo $comment['message'] ?>
    </div>
    <div class="panel-footer">
        <div class="row">
            <div class="fl-left m-l_m">
                <a href="javascript:void(0)" onclick="js_default.createComment(<?php echo $comment['id'] ?>);">Write comment</a>
                <?php if ($comment['count_children']): ?>
                    <a href="javascript:void(0)" class="m-l_m">Show comments (<?php echo $comment['count_children'] ?>)</a>
                <?php endif ?>
            </div>
            <div class="fl-right m-r_m">
                <?php echo $this->getFormatter()->dateInTime($comment['created_at']) ?>
            </div>
        </div>
    </div>
</div>