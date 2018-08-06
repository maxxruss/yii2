<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use yii\filters\AccessControl;
use app\models\search\EventSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;


/**
 * EventController implements the CRUD actions for Event model.
 */
class EventController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // авторизованные пользователи
                    ],
                    [
                        'allow' => false,
                        'roles' => ['?'], // гости
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Event models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Event model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCalendar(): string
    {
        {
            $dates = [
                '2018-08-01',
                '2018-08-02',
                '2018-08-03',
                '2018-08-04',
                '2018-08-05',
                '2018-08-06',
                '2018-08-07',
                '2018-08-08',
                '2018-08-09',
                '2018-08-10',
                '2018-08-11',
                '2018-08-12',
                '2018-08-13',
                '2018-08-14',
                '2018-08-15',
                '2018-08-16',
                '2018-08-17',
                '2018-08-18',
                '2018-08-19',
                '2018-08-20',
                '2018-08-21',
                '2018-08-22',
                '2018-08-23',
                '2018-08-24',
                '2018-08-25',
                '2018-08-26',
                '2018-08-27',
                '2018-08-28',
                '2018-08-29',
                '2018-08-30',
            ];
            $notes = Event::find()
                ->byDates($dates)
                ->all();
            $days = [];
            foreach ($notes as $note) {
                if (isset($days[$note->created_at])) {
                    $days[$note->created_at] = [];
                }
                $days[$note->created_at][] = $note;
            }
            //$notes2 = Event::find()->select(['created_at'])->where('id=1')->one();
            //$notes1 = date('Y-m-d.',strtotime($notes2->created_at));
            //
            return $this->render('calendar', [
                'days' => $days,
                //'notes' => $notes
            ]);
            // in calendar.php
//
        }


    }

    /**
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Event();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Event model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Event model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Event model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Event the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Event::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
