<?php

namespace backend\models;

use yii\base\Exception;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "apple".
 *
 * @property int $id
 * @property string $color
 * @property float|null $size
 * @property int|null $created_date
 * @property int|null $fallen_date
 * @property int|null $status
 * @property AppleState $state
 */
class AppleStandard extends ActiveRecord
{
  const STATUS_HANGING = 1;
  const STATUS_FALLEN = 2;
  const STATUS_ROTTEN = 3;
  const ROTTEN_TIME = 5*3600;

  private AppleState $stateHanging;
  private AppleState $stateFallen;
  private AppleState $stateRotten;

  /**
   * @var AppleState Текущее состояние
   */
  private AppleState $state;

  /**
   * {@inheritdoc}
   */
  public static function tableName()
  {
    return 'apple';
  }

  /**
   * @param string $color
   * @param $config
   */
  public function __construct(string $color = '', $config = [])
  {
    $this->stateHanging = new AppleStateHanging($this);
    $this->stateFallen = new AppleStateFallen($this);
    $this->stateRotten = new AppleStateRotten($this);

    $this->status = self::STATUS_HANGING;
    $this->state = $this->stateHanging;
    $this->size = 1;
    $this->color = $color;

    parent::__construct($config);
  }

  /**
   * @return void
   */
  public function afterFind()
  {
    parent::afterFind();

    if ($this->status === self::STATUS_FALLEN) {
      $this->state = $this->stateFallen;
    } elseif ($this->status == self::STATUS_ROTTEN) {
      $this->state = $this->stateRotten;
    } else {
      $this->state = $this->stateHanging;
    }

  }

  /**
   * @return void
   */
  public function switchToStateFallen(): void
  {
    $this->state = $this->stateFallen;
    $this->status = self::STATUS_FALLEN;
    $this->save();
  }

  /**
   * @return void
   */
  public function switchToStateRotten(): void
  {
    $this->state = $this->stateRotten;
    $this->status = self::STATUS_ROTTEN;
    $this->save();
  }

  /**
   * @param int $percent
   * @return void
   * @throws \Exception
   */
  public function eat(int $percent): void
  {
    $this->state->eat($percent);
  }

  /**
   * @return void
   */
  public function fall(): void
  {
    $this->state->fall();
  }

  /**
   * @return bool
   * @throws Exception
   */
  public static function generate(): bool {

    $count = 10;
    $aColors = self::getColorList();

    for ($i = 0; $i < $count; $i++) {
      $color = rand(0, count($aColors)-1);
      $createdDate = time() + rand(-self::ROTTEN_TIME, 0);

      $oApple = new AppleStandard($aColors[$color]);
      $oApple->created_date = $createdDate;

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
      self::STATUS_HANGING => 'Hanging on a tree',
      self::STATUS_FALLEN => 'Fallen to ground',
      self::STATUS_ROTTEN => 'Rotten',
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
