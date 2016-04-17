<?php
/**
 * @var \vendor\View $this
 * @var string $createCommentPopup - Selector for popup
 * @var string $parentCommentInput - Selector to set value width parent comment id
 * @var string $currentCommentInput - Selector for set current comment id if editing
 */
?>
<div class="modal fade" id="<?php echo $createCommentPopup ?>" tabindex="-1" role="dialog" aria-labelledby="new-comment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="new-comment">New comment</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="comment-title" class="control-label">Title:</label>
                        <input type="text" class="form-control" name="comment-title" id="comment-title">
                    </div>
                    <div class="form-group">
                        <label for="comment-text" class="control-label">Text:</label>
                        <textarea class="form-control" name="comment-text" id="comment-text"></textarea>
                    </div>
                    <input type="hidden" class="form-control" name="<?php echo $parentCommentInput ?>" id="<?php echo $parentCommentInput ?>">
                    <input type="hidden" class="form-control" name="<?php echo $currentCommentInput ?>" id="<?php echo $currentCommentInput ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="js_default.saveComment()">Add comment</button>
            </div>
        </div>
    </div>
</div>