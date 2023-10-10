<?php

namespace backend\models;

abstract class AppleState
{
  protected AppleStandard $appleStandard;

  public function __construct(AppleStandard $appleStandard)
  {
    $this->appleStandard = $appleStandard;
  }

  abstract public function eat(int $percent): void;
  abstract function fall(): void;
  abstract public function rotten(): void;
  abstract public function delete(): void;
}
