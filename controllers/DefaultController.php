<?php

    /**
     * @link http://phe.me
     * @copyright Copyright (c) 2014 Pheme
     * @license MIT http://opensource.org/licenses/MIT
     */

    namespace jabernal\settings\controllers;

    use Yii;
    use jabernal\settings\models\Setting;
    use jabernal\settings\models\SettingSearch;
    use pheme\grid\actions\ToggleAction;
    use yii\web\Controller;
    use yii\web\NotFoundHttpException;
    use yii\filters\VerbFilter;

// Estas tres son indispensables para el control de acceso
    use yii\filters\AccessControl;
    use common\models\Rol;
    use common\components\AccessRule;

    /**
     * SettingsController implements the CRUD actions for Setting model.
     *
     * @author Aris Karageorgos <aris@phe.me>
     */
    class DefaultController extends Controller {
        /**
         * Defines the controller behaviors
         * @return array
         */
        public function behaviors() {
            return [
                'verbs' => [
                    'class' => VerbFilter::class,
                    'actions' => [
                        'delete' => ['post'],
                    ],
                ],
                'access' => [
                    'class' => AccessControl::class,
                    'ruleConfig' => [
                        'class' => AccessRule::class,
                    ],
                    'rules' => [
                        [
                            'allow' => true,
                            'roles' => $this->module->accessRoles,
                        ],
                    ],
                ],
            ];
        }

        public function actions() {
            return [
                'toggle' => [
                    'class' => ToggleAction::className(),
                    'modelClass' => 'jabernal\settings\models\Setting',
                    //'setFlash' => true,
                ]
            ];
        }

        /**
         * Lists all Settings.
         * @return mixed
         */
        public function actionIndex() {
            $isAjax = Yii::$app->request->isAjax;
            $searchModel = new SettingSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            $return_array = [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'isAjax' => $isAjax,
            ];
            if ($isAjax) {
                return $this->renderAjax(
                    'index', $return_array
                );
            } else {
                return $this->render(
                    'index', $return_array
                );
            }
        }

        /**
         * Displays the details of a single Setting.
         * @param integer $id
         * @return mixed
         */
        public function actionView($id) {
            $isAjax = Yii::$app->request->isAjax;
            $return_array = [
                'model' => $this->findModel($id),
                'isAjax' => $isAjax,
            ];
            if ($isAjax) {
                return $this->renderAjax(
                    'view',
                    $return_array
                );
            } else {
                return $this->render(
                    'view',
                    $return_array
                );
            }
        }

        /**
         * Creates a new Setting.
         * If creation is successful, the browser will be redirected to the 'view' page.
         * @return mixed
         */
        public function actionCreate() {
            $isAjax = Yii::$app->request->isAjax;
            $model = new Setting(['active' => 1]);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($isAjax) {
                    \Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['resultado' => 'ok'];
                } else {
                    $redirect = ['index'];
                    return $this->redirect($redirect);
                }
            } else {
                $return_array = [
                    'model' => $model,
                    'isAjax' => $isAjax,
                ];
                if ($isAjax) {
                    return $this->renderAjax(
                        'create',
                        $return_array
                    );
                } else {
                    return $this->render(
                        'create',
                        $return_array
                    );
                }
            }
        }

        /**
         * Updates an existing Setting.
         * If update is successful, the browser will be redirected to the 'view' page.
         * @param integer $id
         * @return mixed
         */
        public function actionUpdate($id) {
            $isAjax = Yii::$app->request->isAjax;
            $model = $this->findModel($id);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                if ($isAjax) {
                    \Yii::$app->response->format = Response::FORMAT_JSON;
                    return ['resultado' => 'ok'];
                } else {
                    $redirect = ['index'];
                    return $this->redirect($redirect);
                }
            } else {
                $return_array = [
                    'model' => $model,
                    'isAjax' => $isAjax,
                ];
                if ($isAjax) {
                    return $this->renderAjax(
                        'update',
                        $return_array
                    );
                } else {
                    return $this->render(
                        'update',
                        $return_array
                    );
                }
            }
        }

        /**
         * Deletes an existing Setting.
         * If deletion is successful, the browser will be redirected to the 'index' page.
         * @param integer $id
         * @return mixed
         */
        public function actionDelete($id) {
            if (Yii::$app->request->isPost) {
                $this->findModel($id)->delete();
            }
            return $this->redirect(['index']);
        }

        /**
         * Finds a Setting model based on its primary key value.
         * If the model is not found, a 404 HTTP exception will be thrown.
         * @param integer $id
         * @return Setting the loaded model
         * @throws NotFoundHttpException if the model cannot be found
         */
        protected function findModel($id) {
            if (($model = Setting::findOne($id)) !== null) {
                return $model;
            } else {
                throw new NotFoundHttpException('The requested page does not exist.');
            }
        }
    }
