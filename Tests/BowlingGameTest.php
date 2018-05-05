<?php

require '../vendor/autoload.php';

use App\BowlingGame;
use PHPUnit\Framework\TestCase;

class BowlingGameTest extends TestCase
{

	public function test_it_scores_a_gutter_game_as_zero()
	{
		$bg = new BowlingGame();
		$this->rollTimes(20, 0, $bg);

		$this->assertEquals(0, $bg->score());
	}

	public function test_it_scores_the_sum_of_all_knocked_down_pins_for_a_game()
	{
		$bg = new BowlingGame();

		$this->rollTimes(20, 1, $bg);

		$this->assertEquals(20, $bg->score());
	}

	public function test_it_awards_a_one_roll_bonus_for_every_spare()
	{
		$bg = new BowlingGame();

		$this->rollSpare($bg);

		$bg->roll(5);

		$this->rollTimes(17, 0, $bg);

		$this->assertEquals(20, $bg->score());
	}

	public function test_it_awards_a_two_roll_bonus_fora_strike_in_the_previous_frame()
	{
		$bg = new BowlingGame;

		$bg->roll(10);
		$bg->roll(7);
		$bg->roll(2);

		$this->rollTimes(17, 0, $bg);
		$this->assertEquals(28, $bg->score());
	}

	public function test_it_scores_a_perfect_game()
	{
		$bg = new BowlingGame;

		$this->rollTimes(12, 10, $bg);

		$this->assertEquals(300, $bg->score());
	}

	function test_it_takes_exception_with_invalid_rolls()
	{
		$bg = new BowlingGame();

		$this->expectException(InvalidArgumentException::class);

		$bg->roll(-1);
	}
	
	private function rollSpare($bg)
	{
		$bg->roll(2);
		$bg->roll(8);
	}

	public function rollTimes($count, $pins, $bg)
	{
		//$bg = new BowlingGame();

		for ($i = 0; $i < $count; $i++)
		{
			$bg->roll($pins);
		}
	}
}