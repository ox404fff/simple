<?php
/**
 * @var \vendor\View $this
 * @var string $style
 * @var array $comment
 */
?>
<div class="panel <?php echo $style ?>" id="js-comment-<?php echo $comment['id'] ?>">
    <div class="panel-heading">
        <h3 class="panel-title">
            <span class="js-comment-title"><?php echo $comment['name'] ?></span>
            <button onclick="js_default.deleteComment(this, <?php echo $comment['id'] ?>)" type="button" class="btn btn-danger btn-xs fl-right m-l_m">
                Delete
            </button>
            <button onclick="js_default.editComment(this, <?php echo $comment['id'] ?>)" type="button" class="btn btn-default btn-xs fl-right">
                Edit
            </button>
        </h3>
    </div>
    <div class="panel-body js-comment-text">
        <?php echo nl2br($comment['message']) ?>
    </div>
    <div class="js-child-comments p-l_m p-r_m" style="display: none"></div>
    <div class="panel-footer">
        <div class="row">
            <div class="fl-left m-l_m">
                <button onclick="js_default.createComment(this, <?php echo $comment['id'] ?>)" class="btn btn-default btn-xs">Comment this</button>
                <button onclick="js_default.showChilds(this, <?php echo $comment['id'] ?>)" id="js-count-<?php echo $comment['id'] ?>" class="btn btn-default btn-xs m-l_m"<?php echo empty($comment['count_children']) ? ' style="display:none"' : '' ?>>
                    Show comments (<?php echo $comment['count_children'] ?>)
                </button>
            </div>
            <div class="fl-right m-r_m">
                <?php echo $this->getFormatter()->dateInTime($comment['created_at']) ?>
            </div>
        </div>
    </div>
</div>