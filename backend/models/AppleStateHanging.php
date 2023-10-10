<?php

namespace backend\models;

final class AppleStateHanging extends AppleState
{

  public function eat(int $percent): void
  {
    echo 'eat: can not eat, because hanging<br/>';
  }

  public function fall(): void
  {
    $this->appleStandard->setFallenDate(time());
    $this->appleStandard->switchToStateFallen();
    echo 'fall: ok<br/>';
  }

  public function rotten(): void
  {
    echo 'rotten: can not rotten, because hanging<br/>';
  }

  public function delete(): void
  {
    echo 'delete<br/>';
  }
}
