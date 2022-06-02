<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property int $created_at
 * @property int $fell_at
 * @property int $status
 * @property float $size
 * @property float $spoiled
 */
class Apple extends \yii\db\ActiveRecord
{
    const STATUS_ON_THE_TREE = 1;
    const STATUS_ON_THE_GROUND = 2;
    const STATUS_ROTTEN = 3;
    public static $statuses = [
        self::STATUS_ON_THE_TREE => 'На дереве',
        self::STATUS_ON_THE_GROUND => 'На земле',
        self::STATUS_ROTTEN => 'Гнилой',
    ];

    public static $colors = [
        'Желтая','Красная','Зеленая','Розовая'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apple';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['color', 'created_at'], 'required'],
            [['created_at', 'fell_at', 'status'], 'integer'],
            [['size', 'spoiled'], 'double'],
            [['color'], 'string', 'max' => 100],
        ];
    }

    public function eat($percent){
        $percent = (float)$percent / 100;
        $size = $this->size - $this->spoiled;
        if ($this->status != self::STATUS_ON_THE_GROUND){
            return 'Яблоко не на земле или же не свежая';
        }elseif($percent < 0 || $percent > 1){
            return 'Неверный процент';
        }elseif($percent > $size){
            return 'Нет столько съедобного в яблоке';
        }else{
            $this->size -= $percent;
            return true;
        }
    }
    public function fall(){
        if($this->status == self::STATUS_ON_THE_TREE){
            $this->status = self::STATUS_ON_THE_GROUND;
            $this->fell_at = time();
            $this->save(false);
        }
    }
    public function beforeSave($insert)
    {
        if ($insert){
            if(!$this->color){
                $this->color = self::$colors[rand(0, count(self::$colors) - 1)];
            }
            if(!$this->created_at){
                $this->created_at = rand(strtotime('-1 year'), time());
            }
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'created_at' => 'Дата появления',
            'fell_at' => 'Дата падения',
            'status' => 'Статус',
            'size' => 'Сколько осталон',
            'spoiled' => 'Сколько испорчен',
        ];
    }
}
