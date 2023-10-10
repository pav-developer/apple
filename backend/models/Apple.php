<?php

namespace backend\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property float|null $size
 * @property int|null $created_date
 * @property int|null $fallen_date
 * @property int|null $status
 */
class Apple extends \yii\db\ActiveRecord
{

  const STATUS_HANGING = 1;
  const STATUS_FALLEN = 2;
  const STATUS_ROTTEN = 3;
  const ROTTEN_TIME = 5*360;

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
      ['color', 'string'],
      ['created_date', 'datetime', 'timestampAttribute' => 'created_date'],
      ['fallen_date', 'datetime', 'timestampAttribute' => 'fallen_date'],
      [['created_date', 'fallen_date'], 'default', 'value' => null],
      ['status', 'default', 'value' => self::STATUS_HANGING],
      [['size'], 'number'],
      [
        ['status'],
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
    ];
  }


  /**
   * @return bool
   */
  public static function generate(): bool {

    $count = 10;
    $aColors = self::getColorList();

    for ($i = 0; $i < $count; $i++) {
      $color = rand(0, count($aColors)-1);
      $createdDate = time() + rand(-self::ROTTEN_TIME, 0);

      $oApple = new Apple([
        'color' => $aColors[$color],
        'created_date' => $createdDate,
      ]);

      if (!$oApple->save()) {
        throw new Exception('Ошибка сохранения яблока');
      }
    }
    return true;
  }

  /**
   * @return string[]
   */
  public static function getColorList(): array
  {
    return ['green', 'yellow', 'red'];
  }

  /**
   * @return string[]
   */
  public static function getStatusList(): array
  {
    return [
      self::STATUS_HANGING => 'Висит',
      self::STATUS_FALLEN => 'Упало',
      self::STATUS_ROTTEN => 'Гнилое',
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
