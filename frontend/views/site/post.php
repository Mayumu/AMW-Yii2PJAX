<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Random stuff.';

?>
<?php  ?>
<h1><?php echo $title; ?></h1>
<h2><?php echo $post_date; ?> by <?php echo $author; ?></h2>
<p><?php echo $post_text; ?></p>
Leave a comment:
<?php 
if($id!=null) //user
{ ?>
    <?= Html::beginForm("", 'post', []) ?>
    <textarea class="form-control input-sm send-form-input" rows="8" placeholder="<?= Yii::t('app', 'Comment text'); ?>" name="text"></textarea>
    <input type="hidden" name="loggedin" value="true">
    <button style="width:20%; margin-top:5px;" type="submit" class="btn btn-danger btn-block btn-sm">Submit</button>
    <?= Html::endForm() ?>
<?php }
else //guest
{ ?>
    <?= Html::beginForm("", 'post', []) ?>
    <input class="form-control input-sm send-form-input" type="text" placeholder="<?= Yii::t('app', 'Name'); ?>" name="anon_author" style="margin-bottom: 5px;">
    <textarea class="form-control input-sm send-form-input" rows="8" placeholder="<?= Yii::t('app', 'Comment text'); ?>" name="text"></textarea>
    <input type="hidden" name="loggedin" value="false">
    <button style="width:20%; margin-top:5px;" type="submit" class="btn btn-danger btn-block btn-sm">Submit</button>
    <?= Html::endForm() ?>
<?php } ?>
 <br>
 <?php foreach ($comments as $comment)
 {
    if($comment['guest']==0)
    { ?>
        <div class="panel panel-info">
            <div class="panel-heading"><img src='<?= $comment['avatar'] ?>' class="img-circle" height="35px"> <?= $comment['username'] ?></div>
            <div class="panel-body"><?= $comment['text'] ?></div>
        </div>
    <?php }
    else if($comment['guest']==1)
    { ?>
        <div class="panel panel-info">
            <div class="panel-heading"><?= $comment['username'] ?><h2 style='margin-bottom: -1px;'>Guest</h2></div>
            <div class="panel-body"><?= $comment['text'] ?></div>
        </div>
   <?php }
 }
?>

