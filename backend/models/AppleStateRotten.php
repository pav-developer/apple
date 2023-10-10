<?php

namespace backend\models;

final class AppleStateRotten extends AppleState
{

  /**
   * @throws \Exception
   */
  public function eat(int $percent): void
  {
    throw new \Exception('eat: can not eat, it is rotten!');
  }

  /**
   * @throws \Exception
   */
  public function fall(): void
  {
    throw new \Exception('fall: already fallen');
  }

  /**
   * @throws \Exception
   */
  public function rotten(): void
  {
    throw new \Exception('rotten: already rotten');
  }

  public function delete(): void
  {
    $this->appleStandard->delete();
  }
}
