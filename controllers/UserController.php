<?php

namespace app\controllers;

use app\models\Auth;
use app\models\Follow;
use Yii;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller {
    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex() {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = \Yii::$app->user->identity;
        if (!$user->isAdmin()) {
            return $this->goHome();
        }
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        $model = $this->findModel($id);
        return $this->redirect(['profile', 'hash' => $model->url_hash]);
    }

    /**
     * Displays a single User model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionProfile($hash) {
        return $this->render('view', [
            'model' => $this->findModelByHash($hash),
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id = null) {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = \Yii::$app->user->identity;
        if (!$user->isAdmin() && !empty($id)) {
            return $this->redirect(['update']);
        }
        if (empty($id)) {
            $id = $user->getId();
        }
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['profile', 'hash' => $model->url_hash]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionFollow($id) {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = \Yii::$app->user->identity;
        $model = $this->findModel($id);

        $follow = new Follow([
            'user_id' => $user->getId(),
            'follow_id' => $model->getId(),
        ]);
        $follow->save();

        return $this->redirect(['profile', 'hash' => $model->url_hash]);
    }
    public function actionUnfollow($id) {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = \Yii::$app->user->identity;
        $model = $this->findModel($id);

        $follow = Follow::findOne([
            'user_id' => $user->getId(),
            'follow_id' => $id,
        ]);
        if ($follow) {
            $follow->delete();
        }

        return $this->redirect(['profile', 'hash' => $model->url_hash]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $user = \Yii::$app->user->identity;
        if (!$user->isAdmin() && $user->getId() != $id) {
            return $this->goHome();
        }
        $deleteUser = $this->findModel($id);
        try {
            try {
                $deleteUser->getAuth()->one()->delete();
            } catch (\Exception $e) {
            }
            try {
                $deleteUser->delete();
            } catch (\Exception $e) {
            }
        } catch (\Exception $e) {
        }
        if ($deleteUser->getId() == $id) {
            Yii::$app->user->logout();
            return $this->redirect(['/site/login']);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelByHash($hash) {
        if (($model = User::findOne(['url_hash' => $hash])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
