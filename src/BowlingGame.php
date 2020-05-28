<?php

namespace PF;

class BowlingGame
{

    public array $rolls = [];

    public function roll(int $points): void
    {
        $this->rolls[] += $points;
    }

    /**
     * @return int|bool
     */
    public function getScore()
    {
        $score = 0;
        $roll = 0;

        for ($frame = 0; $frame < 10; $frame++) {
            if ($this->hasInvalidPoints($roll)) {
                return false;
            }

            if ($this->isStrike($roll)) {
                $score += $this->getPointsForStrike($roll);
                $roll++;
                continue;
            }

            if ($this->isSpare($roll)) {
                $score += $this->getSpareBonus($roll);
            }

            $score += $this->getNormalScore($roll);
            $roll += 2;
        }

        return $score;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getNormalScore(int $roll): int
    {
        return $this->rolls[$roll] + $this->rolls[$roll + 1];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isSpare(int $roll): bool
    {
        return $this->getNormalScore($roll) === 10;
    }

    /**
     * @param int $roll
     * @return mixed
     */
    public function getSpareBonus(int $roll): int
    {
        return $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function isStrike(int $roll): bool
    {
        return $this->rolls[$roll] === 10;
    }

    /**
     * @param int $roll
     * @return int
     */
    public function getPointsForStrike(int $roll): int
    {
        return 10 + $this->rolls[$roll + 1] + $this->rolls[$roll + 2];
    }

    /**
     * @param int $roll
     * @return bool
     */
    public function hasInvalidPoints(int $roll): bool
    {
        return $this->rolls[$roll] > 10 || $this->rolls[$roll] < 0;
    }
}