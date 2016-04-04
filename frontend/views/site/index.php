<?php
use yii\helpers\Html;
use common\components\PostsService;

/* @var $this yii\web\View */

$this->title = 'Random stuff.';

?>

<?php 
if(count($posts) == 0) echo 'Looks like there\'s no entries!';
foreach ($posts as $post)
{ ?>
<h1><?php echo $post['title']; ?></h1>
<h2><?php echo $post['post_date']; ?> by <?php echo $post['author']; ?></h2>
<p><?php echo $post['post_text']; ?></p>
<?= Html::a("Comments (".count(PostsService::getComments($post['id'])).")", ['site/post','id'=>$post['id']])?><div style="height: 10px;"></div>
<?php
}
?>

