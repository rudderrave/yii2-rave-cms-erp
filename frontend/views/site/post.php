<?php
/* @var $this yii\web\View */

use ravesoft\comments\widgets\Comments;
use ravesoft\post\models\Post;

/* @var $post ravesoft\post\models\Post */

$this->title = $post->title;
$this->params['breadcrumbs'][] = $post->title;
?>

<?= $this->render('/items/post.php', ['post' => $post]) ?>

<?php if ($post->comment_status == Post::COMMENT_STATUS_OPEN): ?>
    <?php echo Comments::widget(['model' => Post::className(), 'model_id' => $post->id]); ?>
<?php endif; ?>