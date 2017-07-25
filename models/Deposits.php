<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "deposits".
 *
 * @property integer $id
 * @property integer $client_id
 * @property integer $deposit
 * @property integer $percent
 * @property string $date
 * @property integer $current_balance
 *
 * @property Clients $client
 * @property History[] $histories
 */
class Deposits extends \yii\db\ActiveRecord
{

    public $avarage;
    public $age_range;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'deposits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['client_id', 'deposit', 'percent', 'date', 'current_balance'], 'required'],
            [['client_id', 'deposit', 'percent', 'current_balance'], 'integer'],
            [['date'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'Client ID',
            'deposit' => 'Deposit',
            'percent' => 'Percent',
            'date' => 'Date',
            'current_balance' => 'Current Balance',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHistories()
    {
        return $this->hasMany(History::className(), ['deposit_id' => 'id']);
    }
    
    public function getAvarageDeposits()
    {
        return self::find()->select([
            'avarage' => new Expression('ROUND(AVG(deposit))'),
            'age_range' => new Expression('case 
                when birthday < DATE_SUB( CURDATE( ) , INTERVAL 50 YEAR ) then ">50" 
                when birthday < DATE_SUB( CURDATE( ) , INTERVAL 25 YEAR ) then "25-49" 
                when birthday < DATE_SUB( CURDATE( ) , INTERVAL 18 YEAR ) then "18-24"
             end')
        ])
        ->innerJoinWith('client')  
        ->having('age_range is not null')
        ->indexBy('age_range')
        ->groupBy('age_range')->all();
    }
}
