<?php

namespace app\controllers;

use Yii;
use app\models\Event;
use yii\filters\AccessControl;
use app\models\search\EventSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Access;
use app\models\forms\EventForm;
use app\objects\ViewModels\EventCreateView;
use app\objects\ViewModels\EventView;
use yii\filters\HttpCache;



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
            ],
            'cache' => [
                'class' => HttpCache::class,
                'only' => ['view'],
                'lastModified' => function () {
                    $id = (int) \Yii::$app->getRequest()->getQueryParam('id');
                    $model = $this->findModel($id);
                    return \strtotime($model->updated_at);
                },
//				'etagSeed' => function ($action, $params) {
//
//				}
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
        $event = $this->findModel($id);
        if (!$this->checkAccess($event)) {
            throw new ForbiddenHttpException('У Вас нет доступа к данному событию');
        }
        $author = $event->author;
        $events = $author->event;

        $viewModel = new EventView();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'viewModel' => $viewModel,
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
        $model = new EventForm();
        //d($model);exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $viewModel = new EventCreateView();
        //d($viewModel);exit;


        return $this->render('create', [
            'model' => $model,
            'viewModel' => $viewModel,
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

        if (!$this->checkWriteAccess($model)) {
            throw new ForbiddenHttpException('Редактировать событие может только автор');
        }

        if ($this->checkPastEvent($model)) {
            throw new ForbiddenHttpException('Прошедшее событие редактировать нельзя');
        };

        $model->updated_at=date('Y-m-d h:i:s');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $viewModel = new EventCreateView();

        return $this->render('update', [
            'model' => $model,
            'viewModel' => $viewModel,
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
        $event = $this->findModel($id);

        if (!$this->checkWriteAccess($event)) {
            throw new ForbiddenHttpException('Удалять событие может только автор');
        }

        if ($this->checkPastEvent($event)) {
            throw new ForbiddenHttpException('Прошедшее событие удалить нельзя');
        };

        $event->delete();

        return $this->redirect(['index']);
    }

    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBigForm()
    {
        $bodyParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new EventForm();
        if ($model->load($bodyParams) && $model->createUserAndSave())  {
            return $this->redirect(['event/view', 'id' => $model->id]);
        }
        return $this->render('big-form', [
            'model' => $model,
        ]);
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
        if (($model = EventForm::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     *
     * @param Event $event
     *
     * @return bool
     */
    protected function checkAccess(Event $event): bool
    {
        $currentUid = \Yii::$app->getUser()->getId();
        if ($event->author_id == $currentUid) {
            return true;
        } elseif (Access::find()->andWhere(['event_id' => $event->id, 'user_id' => $currentUid])->count()) {
            return true;
        }
        return false;
    }
    /**
     * @return bool
     * @param Event $event
     */
    protected function checkWriteAccess(Event $event): bool
    {
        return $event->author_id == \Yii::$app->getUser()->getId();
    }

    protected function checkPastEvent(Event $event)
    {
        return (strtotime($event->end_at)<strtotime(date('Y-m-d h:i:s')));
    }
}
