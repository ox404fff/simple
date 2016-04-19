<?php
/**
 * @var \vendor\View $this
 * @var string $createCommentPopup - Selector for popup
 * @var string $parentCommentInput - Selector to set value width parent comment id
 * @var string $currentCommentInput - Selector for set current comment id if editing
 * @var string $action
 * @var array $errors
 * @var array $values
 */
?>
<div class="modal fade" id="<?php echo $createCommentPopup ?>" tabindex="-1" role="dialog" aria-labelledby="new-comment">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="new-comment">New comment</h4>
            </div>
            <div class="modal-body horizontal-form">
                <form action="<?php echo $action ?>" onsubmit="js_default.saveComment(); return false;">
                    <div class="form-group<?php echo empty($errors['comment-title']) ? '' : ' error' ?>">
                        <label for="comment-title" class="control-label">Title:</label>
                        <input type="text" value="<?php
                            echo isset($values['comment-title']) ? $values['comment-title'] : ''
                        ?>" name="comment-title" class="form-control" id="js-comment-title">
                        <?php if (!empty($errors['comment-title'])): ?>
                            <p class="error text-danger"><?php echo $errors['comment-title'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="form-group<?php echo empty($errors['comment-text']) ? '' : ' error' ?>">
                        <label for="comment-text" class="control-label">Text:</label>
                        <textarea class="form-control" name="comment-text" id="js-comment-text"><?php
                            echo isset($values['comment-text']) ? $values['comment-text'] : ''
                        ?></textarea>
                        <?php if (!empty($errors['comment-text'])): ?>
                            <p class="error text-danger"><?php echo $errors['comment-text'] ?></p>
                        <?php endif ?>
                    </div>
                    <input type="hidden" class="form-control" value="<?php
                    echo isset($values['parent-comment-id']) ? $values['parent-comment-id'] : ''
                    ?>"  name="parent-comment-id" id="<?php echo $parentCommentInput ?>">
                    <input type="hidden" class="form-control" value="<?php
                    echo isset($values['current-comment-id']) ? $values['current-comment-id'] : ''
                    ?>"  name="current-comment-id" id="<?php echo $currentCommentInput ?>">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button onclick="js_default.saveComment()" id="js-save-button" type="button" class="btn btn-primary">Add comment</button>
            </div>
        </div>
    </div>
</div>