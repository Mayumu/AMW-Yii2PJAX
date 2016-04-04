<?php

use yii\helpers\Html;

$this->title = 'Random stuff.';

?>
<?php if ($user_level != "admin")
{
    die("You should not be here!");
}
?> 
<?= Html::beginForm("", 'post', []) ?>
<input class="form-control input-sm send-form-input" type="text" placeholder="<?= Yii::t('app', 'Post title'); ?>" name="title" style="margin-bottom: 5px;">
<textarea class="form-control input-sm send-form-input" rows="8" placeholder="<?= Yii::t('app', 'Post text'); ?>" name="text"></textarea>
<button style="width:20%; margin-top:5px;" type="submit" class="btn btn-danger btn-block btn-sm">Submit</button>
<?= Html::endForm() ?>