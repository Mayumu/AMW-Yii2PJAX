<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

$this->title = 'Random stuff.';

?>

<?php Pjax::begin(); ?>
<?= Html::a("Shoot!", ['site/randomjoke'], ['class' => 'btn btn-lg btn-primary']) ?>
<br><div class="panel panel-default"><div class="panel-body"><p><?= $joke ?></p></div></div>
<?php Pjax::end(); ?>
