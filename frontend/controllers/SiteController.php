<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\components\PostsService;
use common\components\UserService;
use app\models\Jokes;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $posts = PostsService::getPosts();
        return $this->render('index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    
    public function actionAddpost()
    {
        $id = Yii::$app->user->getId();
        $user_level = UserService::getLevel($id);
        if (Yii::$app->request->isPost)
        {
            $date = date("Y-m-d H:i:s");
            $title = Yii::$app->request->post('title');
            $text = Yii::$app->request->post('text');
            if (PostsService::addPost($id, $date, $title, $text))
            {
                Yii::$app->session->setFlash('success', 'Post has been successfully added!');
            }
        }
        return $this->render('addpost', [
            'user_level' => $user_level,
        ]);
    }
    
    public function actionManageposts()
    {
        $user_level = UserService::getLevel(Yii::$app->user->getId());
        if (Yii::$app->request->isPost)
        {
            $type = Yii::$app->request->post('type');
            switch($type)
            {
                case "delete":
                    $id = Yii::$app->request->post('id');
                    PostsService::removePost($id);
                    break;
                case "edit":
                    
                    break;
            }
        }
        $posts = PostsService::getPosts();
        return $this->render('manageposts', [
            'posts' => $posts,
            'user_level' => $user_level,
        ]);
    }
    
    public function actionEditpost()
    {
        $id = Yii::$app->request->get('id');
        $user_level = UserService::getLevel(Yii::$app->user->getId());
        $posts = PostsService::getPosts();
        if (Yii::$app->request->isPost)
        {
            $title = Yii::$app->request->post('title');
            $text = Yii::$app->request->post('text');
            PostsService::editPost($id, $title, $text);
        }
        foreach($posts as $post)
        {
            if($post['id']==$id)
            {
                $title = $post['title'];
                $post_text = $post['post_text'];
            }
        }
        return $this->render('editpost', [
            'id' => $id,
            'posts' => $posts,
            'title' => $title,
            'post_text' => $post_text,
            'user_level' => $user_level,
        ]);
    }
    
    public function actionPost()
    {
        $userid = Yii::$app->user->getId();
        $id = Yii::$app->request->get('id');
        $posts = PostsService::getPosts();
        $post_id = Yii::$app->request->get('id');
        $comments = PostsService::getComments($post_id);
        if (Yii::$app->request->isPost)
        {
            $loggedin = Yii::$app->request->post('loggedin');
            $comment_text = Yii::$app->request->post('text');
            switch($loggedin)
            {
                case "true":
                    PostsService::addComment($post_id, $userid, $comment_text, false, "");
                    break;
                case "false":
                    $anonymous_author_name = Yii::$app->request->post('anon_author');
                    PostsService::addComment($post_id, null, $comment_text, true, $anonymous_author_name);
                    break;
            }
        }
        foreach($posts as $post)
        {
            if($post['id']==$id)
            {
                $title = $post['title'];
                $post_text = $post['post_text'];
                $author = $post['author'];
                $post_date = $post['post_date'];
            }
        }
        return $this->render('post', [
            'title' => $title,
            'post_text' => $post_text,
            'author' => $author,
            'post_date' => $post_date,
            'id' => $userid,
            'comments' => $comments,
        ]);
    }
    
    public function actionRandomjoke()
    {
        $jokes = Jokes::find()->all();
        $amount = count($jokes);
        $random = rand(0,$amount-1);
        $joke = $jokes[$random]['joke'];
        return $this->render('randomjoke', ['joke' => $joke]);
    }
    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
