<?php

namespace backend\models;

final class AppleStateFallen extends AppleState
{

  public function eat(int $percent): void
  {
    $newSize = $this->appleStandard->getSize() - $percent/100;
    if ($newSize <= 0) {
      echo 'eat: ok<br/>';
      $this->appleStandard->delete();
      return;
    }
    $this->appleStandard->setSize($newSize);
    echo 'eat: ok<br/>';
  }

  public function fall(): void
  {
    echo 'fall: not, already fallen<br/>';
  }

  public function rotten(): void
  {
    echo 'rotten: can be rotten only after 5 hours<br/>';
    //if ($this->appleStandard->)
  }

  public function delete(): void
  {
    echo 'delete<br/>';
  }
}
