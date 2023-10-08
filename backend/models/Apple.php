<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property float|null $size
 * @property int $created_date
 * @property int|null $fallen_date
 * @property int|null $status
 */
class Apple extends \yii\db\ActiveRecord
{

  const STATUS_HANGING = 1;
  const STATUS_FALLEN = 2;
  const STATUS_ROTTEN = 3;

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
          ['status', 'integer'],
          ['rotten', 'boolean'],
          ['color', 'string'],
          ['created_date', 'datetime', 'timestampAttribute' => 'created_date'],
          ['fallen_date', 'datetime', 'timestampAttribute' => 'fallen_date'],
          [['created_date', 'fallen_date'], 'default', 'value' => null],
          ['rotten', 'default', 'value' => 0],
          [['size'], 'number'],
          [['created_date'], 'required'],
          [
            ['status', 'rotten'],
            'filter',
            'skipOnEmpty' => true,
            'filter' => function ($value) {
              return (int)$value;
            }
          ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'color' => 'Цвет',
            'size' => 'Сколько съели',
            'created_date' => 'Дата появления',
            'fallen_date' => 'Дата падения',
            'status' => 'Статус',
            'rotten' => 'Гнилое',
        ];
    }

  /**
   * @return string[]
   */
  public static function getStatusList(): array
    {
      return [
        self::STATUS_HANGING => 'Висит',
        self::STATUS_FALLEN => 'Упало',
      ];
    }

  /**
   * @return string
   */
  public function getStatus(): string
  {
    $ar = self::getStatusList();
    return $ar[$this->status] ?? 'unknown status';
  }
}
