<?php

namespace app\controllers;

use app\models\Author;
use app\models\ContactForm;
use app\models\LoginForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
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
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays Top 10 books with filter by year.
     *
     * @param int|null $year
     * @return string
     */
    public function actionIndex(int $year = null): string
    {

        /* $bookAuthors = BookAuthor::find()
             ->select(['COUNT(*) as bookCount', 'author_id'])
             ->joinWith('book')
             ->where(['between', 'book.releaseDate', "2020-01-01", "2024-01-01"])
             ->groupBy(['author_id'])
             ->limit(10)->asArray()
             ->orderBy('bookCount DESC')
             ->all();

         $books = Book::find()
             ->select(['COUNT(*) as bookCount', 'book_author.author_id'])
             ->joinWith('authors')
             ->where(['between', 'book.releaseDate', "2020-01-01", "2024-01-01"])
             ->groupBy(['author_id'])
             ->limit(10)->asArray()
             ->orderBy('bookCount DESC')
             ->all();*/

//        var_dump([$bookAuthors, $books]);
//        die;
        //todo add ability to see books count for selected year , see commented code below
        $currentYear = date('Y');
        if ($year) {
            if ($year > $currentYear) {
                throw new InvalidArgumentException('Year can not be in future');
            }
        } else {
            $year = $currentYear;
        }

        $topDataProvider = new ActiveDataProvider([
            'query' => Author::find()
                ->select(['COUNT(*) as bookCount', 'author.id', 'author.title', 'author.body'])
                ->joinWith('books')
                ->where(['between', 'book.releaseDate', $year . "-01-01", ($year + 1)."-01-01"])
                ->groupBy(['author.id'])
        ->limit(10)->orderBy('bookCount DESC'),
            'sort'       => [
//                'defaultOrder' => [
//                    'bookCount' => SORT_DESC,
//                ]
    ],

        ]);
        return $this->render('index', ['topDataProvider' => $topDataProvider, 'year'=>$year]);
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
        return $this->render('about');
    }
}
