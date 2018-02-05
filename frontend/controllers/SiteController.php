<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\ResetPasswordRequestForm;
use frontend\models\SignupForm;
use frontend\models\Email;
use yii\helpers\Json;
use frontend\models\ContactForm;
use frontend\models\DesignToughts;

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
                'only' => ['logout'],
                'rules' => [
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
        return $this->redirect(['app/index']);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($a = null, $id = null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        Yii::$app->session->remove('backURL');

        $backURL = Yii::$app->request->referrer;
        $message = '';

        if ($a !== null) {
            switch($a) {
                case 'add_book':
                    $message = 'Вам нужно войти, чтобы добавить книгу на сайт';
                    $backURL = ['book/add'];
                    break;
                case 'write_review':
                    $message = 'Вам нужно войти, чтобы написать рецензию';
                    $backURL = ['review/write', 'bookid' => $id];
                    break;
                case 'add_author':
                    $message = 'Вам нужно войти, чтобы добавить автора на сайт';
                    $backURL = ['author/add'];
                    break;
                case 'review_view':
                    $message = 'Вам нужно войти, чтобы оставить оценку рецензии';
                    $backURL = ['review/view', 'id' => $id];
                    break;
                case 'edit_review':
                    $message = 'Вам нужно войти, чтобы редактировать рецензию';
                    $backURL = ['review/edit', 'id' => $id];
                    break;
                case 'delete_review':
                    $message = 'Вам нужно войти, чтобы удалить свою рецензию';
                    $backURL = ['review/delete', 'id' => $id];
                    break;
                default:
                    $backURL = Yii::$app->request->referrer;
                    break;
            }
        }

        if(!Yii::$app->session->has("backURL")) {
            Yii::$app->session->set("backURL", $backURL, true);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->session->get("backURL")); 
        } else {
            return $this->render('login', [
                'model' => $model,
                'message' => $message
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

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {

        if (Yii::$app->user->getId()) {
            return $this->goHome();
        }

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect(['user/index']);
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionResetPasswordRequest()
    {
        $model = new ResetPasswordRequestForm();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->createResetToken()) {
                return $this->render('success-restore-password-request');
            } else {
                return $this->render('cant-create-reset-token');
            }
        }

        return $this->render('restore-password-request', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionOpinion()
    {
        if (Yii::$app->request->isAjax) {
            
            $data = Yii::$app->request->post();

            $opinion = new DesignToughts();
            $opinion->user_id = @Yii::$app->user->getId() ?? 0;
            $opinion->time = time();
            $opinion->opinion = $data['id'];

            if ($opinion->save())
                return true;

        }

        return false;
    }

}
