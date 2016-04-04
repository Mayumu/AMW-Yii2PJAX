<?php
use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Random stuff.';
?>
<?php if ($user_level != "admin")
{
    die("You should not be here!");
}
?> 
<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>id</th>
            <th>Title</th>
            <th>Date</th>
            <th>Author</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($posts as $post)
    { ?>
        <tr style="vertical-align: middle;">
        <td><?php echo $post['id']; ?></td>
        <td><?php echo $post['title']; ?></td>
        <td><?php echo $post['post_date']; ?></td>
        <td><?php echo $post['author']; ?></td>
        <td><?= Html::a("Edit", ['site/editpost','id'=>$post['id']], ['class'=>'btn btn-warning btn-block btn-sm']) ?></td>
        <td>
            <?= Html::beginForm("", 'post', []) ?>
            <input type="hidden" name="type" value="delete">
            <input type="hidden" name="id" value="<?php echo $post['id']; ?>">
            <button type="submit" class="btn btn-danger btn-block btn-sm">Delete</button>
            <?= Html::endForm() ?>
        </td>
        </tr>
 <?php   }
?>
    </tbody>
</table>
