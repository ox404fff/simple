<?php
/**
 * @var \vendor\View $this   Layout view object
 * @var string $content      Content string
 * @var string $title        Page title
 */
?>
<!DOCTYPE html>
<html lang="<?php echo $this->escape(\vendor\Application::getInstance()->getParameter('language')) ?>">
    <head>
        <meta charset="<?php echo $this->escape(\vendor\Application::getInstance()->getParameter('charset')) ?>">
        <title><?php echo $this->escape($title) ?></title>
        <?php echo implode('', $this->getAssertManager()->getCssFiles()) ?>
    </head>
    <body>
        <div class="container">
            <div id="js-alert-cont" style="display: none;">
                <div id="js-alert" class="alert">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <span class="message"></span>
                </div>
            </div>
            <?php echo $this->getVar('content', true) ?>
        </div>
        <footer class="footer">
            <div class="container">
                <p class="text-muted">Author - Fedosenko Oleg.</p>
            </div>
        </footer>
        <?php echo implode('', $this->getAssertManager()->getJsFiles()) ?>
        <?php if ($this->getAssertManager()->ifExistsJs()): ?>
        <script type="text/javascript">
            jQuery(document).ready(function () {
                <?php echo implode('', $this->getAssertManager()->getJs()) ?>
            });
        </script>
        <?php endif ?>
    </body>
</html>