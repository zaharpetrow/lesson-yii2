<?php

namespace app\controllers;

use yii\web\Controller;
use app\models\Triangular_with_divided;
use yii\data\Pagination;

class TriangularController extends Controller
{

    public function actionIndex()
    {
        $query       = Triangular_with_divided::find();
        $pages       = new Pagination([
            'totalCount' => $query->count(),
            'pageSize'   => 5
        ]);
        $triangulars = $query->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

        return $this->render('index', [
                    'triangulars' => $triangulars,
                    'pages'       => $pages
        ]);
    }

    public function actionInteger()
    {
        $get   = \Yii::$app->request->get();
        $query = Triangular_with_divided::findOne($get['id']);
        return $this->render('integer', [
                    'integer' => $query,
        ]);
    }

}
