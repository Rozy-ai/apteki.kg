<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <br/>
    <br/>
    <br/>
    <center>
      <h1><?= Html::encode($this->title) ?></h1>

      <div class="error-message">
          <?= nl2br(Html::encode($message)) ?>
      </div>
    </center>

    <br/>
    <br/>
    <br/>
</div>
