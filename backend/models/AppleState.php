<?php

namespace backend\models;

abstract class AppleState
{
  protected AppleStandard $appleStandard;

  /**
   * @param AppleStandard $appleStandard
   */
  public function __construct(AppleStandard $appleStandard)
  {
    $this->appleStandard = $appleStandard;
  }

  /**
   * @param int $percent
   * @return void
   */
  abstract public function eat(int $percent): void;

  /**
   * @return void
   */
  abstract function fall(): void;

  /**
   * @return void
   */
  abstract public function rotten(): void;

  /**
   * @return void
   */
  abstract public function delete(): void;
}
