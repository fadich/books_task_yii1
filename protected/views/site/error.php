<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle ='Ошибка';
$this->breadcrumbs = array(
    'Ошибка',
);
?>
<div>
    <h1>Ошибка <?php echo $code; ?></h1>

    <div class="error" style="font-size: 16px">
        <?php
        //echo CHtml::encode($message);
        ?>
        Страница по запросу <strong><?= $_SERVER['PHP_SELF'] ?></strong> не найдена...
    </div>
</div>