<?php
/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use common\models\LoginForm;
use common\components\UserService;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
        <?php $this->beginBody() ?>

        <div class="wrap">
            <?php
            /* NavBar::begin([
              'brandLabel' => 'My Company',
              'brandUrl' => Yii::$app->homeUrl,
              'options' => [
              'class' => 'navbar-inverse navbar-fixed-top',
              ],
              ]);
              $menuItems = [
              ['label' => 'Home', 'url' => ['/site/index']],
              ];
              if (Yii::$app->user->isGuest) {
              $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
              $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
              } else {
              $menuItems[] = '<li>'
              . Html::beginForm(['/site/logout'], 'post')
              . Html::submitButton(
              'Logout (' . Yii::$app->user->identity->username . ')',
              ['class' => 'btn btn-link']
              )
              . Html::endForm()
              . '</li>';
              }
              echo Nav::widget([
              'options' => ['class' => 'navbar-nav navbar-right'],
              'items' => $menuItems,
              ]);
              NavBar::end(); */
            ?>

            <div class="container">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
<?= Alert::widget() ?>
                <div id="main-container">
                    <div id="banner"></div>
                    <div id="content-thin">
                        <input type="image" src="img/user.png" data-toggle="collapse" data-target="#usercontent" class="menu-header-collapsible">
                        <div id="usercontent" class="collapse">
                            <?php
                            $id = Yii::$app->user->getId();
                            if (!Yii::$app->user->isGuest)
                            {
                                ?>
                                <div style="height: 5px;"></div><center><?= UserService::getName($id); ?> | <?= Html::a('Logout', ['site/logout'], ['data' => ['method' => 'post']]) ?></center>
                                <div style="text-align: center; margin-bottom: 10px;"><?= Html::img(UserService::getAvatar($id)) ?></div>
                                
                            <?php
                            if(UserService::getName($id) == "Mayumu")
                            {
                                echo Html::img("http://www.listingsinabox.com/images/iconSmall_Add.jpg");
                                echo ' ';
                                echo Html::a("Add a post", ['site/addpost'])."<br>";
                                echo Html::img("http://releasenotes.docs.salesforce.com/spring15/spring15/release-notes/release_notes/images/communities_gear_16x16.png")." ";
                                echo Html::a("Manage posts", ['site/manageposts']);
                            }
                            }
                            else
                            {
                                ?> <div style="height: 5px;"></div>
    <?= Html::a('Login', ['site/login'], ['data' => ['method' => 'post']]) ?> | <?= Html::a('Sign up', ['site/signup'], ['data' => ['method' => 'post']]) ?>
<?php } ?>
                        </div></div>
                    <div id="content-thin"><?= Html::img("img/findmeon.png", ['class' => 'menu-header']); ?>
                        <br><img src="https://twitter.com/favicon.ico"> <a href="https://twitter.com/Mayumu_">Twitter</a>
                        <br><img src="https://twitch.tv/favicon.ico"> <a href="https://twitch.tv/mayumu">Twitch</a>
                        <br><img src="http://myanimelist.net/favicon.ico"> <a href="http://myanimelist.net/mayumu">MyAnimeList</a></div>
                    <div id="content-wide">
                        <?= Html::a("Home", ['site/index']) ?> | <?= Html::a("Random joke", ['site/randomjoke']) ?>
                    </div>
                    <div id="content-wide">
        <?= $content ?>
                    </div>
                </div>
            </div>
        </div>
        <?php /*
          <footer class="footer">
          <div class="container">
          <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

          <p class="pull-right"><?= Yii::powered() ?></p>
          </div>
          </footer>
         */ ?>
<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
