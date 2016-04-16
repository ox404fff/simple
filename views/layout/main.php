<?php
/**
 * @var \vendor\View $this   Layout view object
 * @var string $content      Content string
 * @var string $title        Page title
 */
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        <title><?php echo $this->escape($title) ?></title>
    </head>
    <body>
        <?php echo $content ?>
    </body>
</html>