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
            <div class="page-header">
                <h1>Simple comments tree</h1>
            </div>
            <?php echo $this->getVar('content', true) ?>
        </div>
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