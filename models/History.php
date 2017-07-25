<?php

namespace app\models;

use Yii;
use yii\db\Expression;


/**
 * This is the model class for table "history".
 *
 * @property integer $id
 * @property integer $deposit_id
 * @property integer $operation_type
 * @property string $date
 * @property integer $revenue
 *
 * @property Deposits $deposit
 * @property Operations $operationType
 */
class History extends \yii\db\ActiveRecord
{
    
    public $month;
    public $turnover;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deposit_id', 'operation_type', 'date', 'revenue'], 'required'],
            [['deposit_id', 'operation_type', 'revenue'], 'integer'],
            [['date'], 'safe'],
            [['deposit_id'], 'exist', 'skipOnError' => true, 'targetClass' => Deposits::className(), 'targetAttribute' => ['deposit_id' => 'id']],
            [['operation_type'], 'exist', 'skipOnError' => true, 'targetClass' => Operations::className(), 'targetAttribute' => ['operation_type' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deposit_id' => 'Deposit ID',
            'operation_type' => 'Operation Type',
            'date' => 'Date',
            'revenue' => 'Revenue',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeposit()
    {
        return $this->hasOne(Deposits::className(), ['id' => 'deposit_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperationType()
    {
        return $this->hasOne(Operations::className(), ['id' => 'operation_type']);
    }
    
    /**
     * Get bank turnover by month
     * @return type
     */
    public function getTurnover()
    {
        return self::find()->select([
            'month'    => new Expression("DATE_FORMAT(date,'%Y-%m')"),
            'turnover' => new Expression('SUM(revenue)')
        ])->groupBy('month')->all();
    }
}
