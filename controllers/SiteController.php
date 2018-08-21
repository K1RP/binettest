<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\data\Pagination;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\SignupForm;
use app\models\User;
use app\models\RefLinks;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
		if (Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$query = User::find()
			->where(['refid' => Yii::$app->user->id]);
		$pagination = new Pagination([
            'defaultPageSize' => 20,
            'totalCount' => $query->count(),
        ]);
		$users = $query->orderBy('username')
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
		
		$refid = User::find()
			->select('refid')
			->where(['id' => Yii::$app->user->id])
			->one();
		$refUser = User::find()
			->select('username')
			->where(['id' => $refid])
			->one();
        return $this->render('about', ['users' => $users, 'pagination' => $pagination, 'refUser' => $refUser] );
    }
	
	public function actionSignup()
	{
		if (!Yii::$app->user->isGuest) {
			return $this->goHome();
		}
		$model = new SignupForm();
		if($model->load(\Yii::$app->request->post()) && $model->validate()){
			$user = new User();
			$user->username = $model->username;
			$user->password = \Yii::$app->security->generatePasswordHash($model->password);
			$refUser = Yii::$app->request->get('referrer');
			if($refUser){
				$user->refid = $refUser;
			}
			if($user->save()){
				return $this->goHome();
			}
		}
		return $this->render('signup', compact('model'));
	}
}
