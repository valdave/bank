<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Deposits;
use app\models\History;

class ReportsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays bank turnover by monthes.
     *
     * @return html
     */
    public function actionRevenue()
    {
        $data = (new History())->getTurnover();
        return $this->render('revenue', ['data' => $data]);
    }

    /**
     * Displays avarage deposits by age ranges.
     *
     * @return html
     */
    public function actionAvarage()
    {
        $data = [
            '18-24' => (object)['avarage' => 0],
            '25-49' => (object)['avarage' => 0],
            '>50' => (object)['avarage' => 0]
        ];
        $data = array_merge($data, (new Deposits())->avarageDeposits);
        return $this->render('avarage', ['data' => $data]);
    }
}
