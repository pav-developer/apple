<?php

namespace backend\models;

use yii\db\StaleObjectException;

final class AppleStateHanging extends AppleState
{

  /**
   * @throws \Exception
   */
  public function eat(int $percent): void
  {
    throw new \Exception("eat: can not eat ID[{$this->appleStandard->id}], because hanging");
  }

  /**
   * @return void
   */
  public function fall(): void
  {
    $this->appleStandard->fallen_date = time();
    $this->appleStandard->switchToStateFallen();
  }

  /**
   * @throws \Exception
   */
  public function rotten(): void
  {
    throw new \Exception('rotten: can not rotten, because hanging');
  }

  /**
   * @return void
   * @throws \Throwable
   * @throws StaleObjectException
   */
  public function delete(): void
  {
    $this->appleStandard->delete();
  }
}
