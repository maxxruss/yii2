<?php
namespace app\controllers;

use app\models\Access;
use app\models\forms\NoteForm;
use app\models\Note;
use app\models\search\NoteSearch;
use app\objects\ViewModels\NoteCreateView;
use app\objects\ViewModels\NoteView;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
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
     * Lists all Note models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Displays a single Note model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $note = $this->findModel($id);
        if (!$this->checkAccess($note)) {
            throw new ForbiddenHttpException('У Вас нет доступа к данной заметке');
        }
        $author = $note->author;
        $notes = $author->notes;

        $viewModel = new NoteView();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'viewModel' => $viewModel,
        ]);
    }
    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NoteForm();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $viewModel = new NoteCreateView();
        return $this->render('create', [
            'model' => $model,
            'viewModel' => $viewModel,
        ]);
    }
    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!$this->checkWriteAccess($model)) {
            throw new ForbiddenHttpException();
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $viewModel = new NoteCreateView();

        return $this->render('update', [
            'model' => $model,
            'viewModel' => $viewModel,

        ]);
    }
    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $note = $this->findModel($id);
        if (!$this->checkWriteAccess($note)) {
            throw new ForbiddenHttpException();
        }
        $note->delete();
        return $this->redirect(['index']);
    }
    /**
     * @return mixed
     * @throws \yii\base\InvalidConfigException
     */
    public function actionBigForm()
    {
        $bodyParams = \Yii::$app->getRequest()->getBodyParams();
        $model = new NoteForm();
        if ($model->load($bodyParams) && $model->createUserAndSave())  {
            return $this->redirect(['note/view', 'id' => $model->id]);
        }
        return $this->render('big-form', [
            'model' => $model,
        ]);
    }
    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NoteForm::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     */

    /**
     * @param Note $note
     *
     * @return bool
     */
    protected function checkAccess(Note $note): bool
    {
        $currentUid = \Yii::$app->getUser()->getId();
        if ($note->author_id == $currentUid) {
            return true;
        } elseif (Access::find()->andWhere(['note_id' => $note->id, 'user_id' => $currentUid])->count()) {
            return true;
        }
        return false;
    }
    /**
     * @return bool
     * @param Note $note
     */
    protected function checkWriteAccess(Note $note): bool
    {
        return $note->author_id == \Yii::$app->getUser()->getId();
    }
}