<?php

namespace backend\models;

class AppleStandard
{
  const ROTTEN_TIME = 5*360;

  private AppleState $stateHanging;
  private AppleState $stateFallen;
  private AppleState $stateRotten;

  /**
   * @var AppleState Текущее состояние
   */
  private AppleState $state;

  private int $stateId;
  private float $size;
  private string $color;
  private int $createdDate;
  private int $fallenDate;

  public function __construct(string $color)
  {
    $this->stateHanging = new AppleStateHanging($this);
    $this->stateFallen= new AppleStateFallen($this);
    $this->stateRotten = new AppleStateRotten($this);

    $this->state = $this->stateHanging;
    $this->size = 1;
    $this->color = $color;
    $this->createdDate = time() + rand(-self::ROTTEN_TIME, 0);
  }

  public function switchToStateFallen(): void
  {
    $this->state = $this->stateFallen;
  }

  public function switchToStateRotten(): void
  {
    $this->state = $this->stateRotten;
  }

  public function eat(int $percent): void
  {
    $this->state->eat($percent);
  }

  public function fall(): void
  {
    $this->state->fall();
  }

  public function delete(): void
  {
    $this->state->delete();
  }

  /**
   * @return float
   */
  public function getSize(): float
  {
    return $this->size;
  }

  /**
   * @param float $size
   */
  public function setSize(float $size): void
  {
    $this->size = $size;
  }

  /**
   * @return int
   */
  public function getFallenDate(): int
  {
    return $this->fallenDate;
  }

  /**
   * @param int $fallenDate
   */
  public function setFallenDate(int $fallenDate): void
  {
    $this->fallenDate = $fallenDate;
  }

  /**
   * @return string
   */
  public function getColor(): string
  {
    return $this->color;
  }

}
