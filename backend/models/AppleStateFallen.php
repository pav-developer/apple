<?php

namespace backend\models;

use yii\db\StaleObjectException;

final class AppleStateFallen extends AppleState
{

  /**
   * @throws \Throwable
   * @throws StaleObjectException
   */
  public function eat(int $percent): void
  {
    $newSize = $this->appleStandard->size - $percent/100;

    if ($newSize <= 0) {
      $this->delete();
      throw new \Exception('Apple fully eaten and deleted');
    }
    $this->appleStandard->size = $newSize;
    $this->appleStandard->save();
  }

  /**
   * @throws \Exception
   */
  public function fall(): void
  {
    throw new \Exception('fall: not, already fallen');
  }

  /**
   * @throws \Exception
   */
  public function rotten(): void
  {
    throw new \Exception('rotten: can be rotten only after 5 hours');
  }

  /**
   * @throws StaleObjectException
   * @throws \Throwable
   */
  public function delete(): void
  {
    $this->appleStandard->delete();
  }
}
