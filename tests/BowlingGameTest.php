<?php

use PF\BowlingGame;

class BowlingGameTest extends \PHPUnit\Framework\TestCase
{
    public function testGetScore_withAllZeros_getZeroScore()
    {
        //set up
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(0);
        }

        //test
        $score = $game->getScore();

        //assert
        self::assertEquals(0, $score);
    }

    public function testGetScore_withAllOnes_get20asScore()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();
        self::assertEquals(20, $score);
    }

    public function testGetScore_withASpare_returnsScoreWithSpareBonus()
    {
        $game = new BowlingGame();

        $game->roll(2);
        $game->roll(8);
        $game->roll(5);
        //2 + 8 + 5
        for ($i = 0; $i < 17; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(37, $score);
    }

    public function testGetScore_withAStrike_addsStrikeBonus()
    {
        $game = new BowlingGame();

        $game->roll(10);
        $game->roll(5);
        $game->roll(3);
        //10 + 5 (bonus) + 3 (bonus) + 5 +3  + 16
        for ($i = 0; $i < 16; $i++) {
            $game->roll(1);
        }

        $score = $game->getScore();

        self::assertEquals(42, $score);
    }

    public function testGetScore_withPerfectGame_returns300()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 12; $i++) {
            $game->roll(10);
        }

        $score = $game->getScore();

        self::assertEquals(300, $score);
    }

    public function testGetScore_withNegativePoints_returnsFalse()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(-1);
        }

        $score = $game->getScore();

        self::assertFalse($score);
    }

    public function testGetScore_withTooManyPoints_returnsFalse()
    {
        $game = new BowlingGame();

        for ($i = 0; $i < 20; $i++) {
            $game->roll(11);
        }

        $score = $game->getScore();

        self::assertFalse($score);
    }
}