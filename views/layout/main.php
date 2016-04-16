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
    </head>
    <body>
        <?php echo $content ?>
    </body>
</html>