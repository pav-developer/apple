<?php

namespace backend\models;

final class AppleStateRotten extends AppleState
{

  public function eat(int $percent): void
  {
    echo 'eat: can not eat, it is rotten!<br/>';
  }

  public function fall(): void
  {
    echo 'fall: already fallen<br/>';
  }

  public function rotten(): void
  {
    echo 'rotten: already rotten<br/>';
  }

  public function delete(): void
  {
    echo 'delete<br/>';
  }
}
