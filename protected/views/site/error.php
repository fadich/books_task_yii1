<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle = 'Ошибка';
$this->breadcrumbs = array(
    'Ошибка',
);
?>
<div>
    <h1>Ошибка <?php echo $code; ?></h1>

    <div class="error">
        <?php
        //echo CHtml::encode($message);
        ?>
        Страница по запросу <strong class="strong"><?= $_SERVER['PHP_SELF'] ?></strong> не найдена...
    </div>
</div>
<style>
    .error {
        font-style: normal;
        font-size: 14px;
    }

    .error:hover {

    }

    .strong {
        font-style: normal;
        color: #ff7777;
    }

    .strong:hover {
        color: #ff0000;
    }

    #counter {
        color: #0a0a0a;
        font-size: 15px;
        padding: 5px;
        align-content: stretch;
    }

    #counter:hover {
        font-size: 16px;
    }
</style>
<script>
    var min = 0;
    var hours = 0;
    function counter() {
        var sec = document.getElementById('timer_inp').innerHTML++;
        if (sec == 60) {
            min = min + 1;
            document.getElementById('timer_inp').innerHTML = 0;
        }
        if (min == 60) {
            hours = hours + 1;
            min = 0;
        }
        if (hours > 0) {
            document.getElementById('counter').innerHTML = "Бездействие в течение " + hours + " ч " +
                min + " мин " + sec + " сек.";
        } else if (min > 0) {
            document.getElementById('counter').innerHTML = "Бездействие в течение " + min + " мин " + sec + " сек.";
        } else {
            document.getElementById('counter').innerHTML = "Бездействие в течение " + sec + " сек.";
        }
        setTimeout(counter, 1000);
    }
    setTimeout(counter, 1000);
</script>
<hr>
<div id="timer_inp" hidden="hidden">0</div>
<span id="counter"></span>