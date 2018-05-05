<?php

namespace App;

class BowlingGame
{
	protected $rolls = [];

	public function roll($pins): void
	{
		$this->guardAgainstInvalidRoll($pins);

		$this->rolls[] = $pins;
	}

	public function getDefaultFrameScore($roll): int
	{
		return $this->rolls[$roll] + $this->rolls[$roll+1];
	}

	public function score(): int
	{
		$score = 0;
		$roll = 0;

		for ($frame = 1; $frame <= 10; $frame++)
		{ 
			if ($this->isStrike($roll))
			{
				$score += $this->strikeBonus($roll);
				$roll += 1;
			}
			elseif ($this->isSpare($roll))
			{
				$score += $this->spareBonus($roll);
				$roll += 2;
			}
			else
			{
				$score += $this->getDefaultFrameScore($roll);
				$roll += 2;
			}

			}

		return $score;
	}

	public function isSpare($roll)
	{
		return $this->rolls[$roll] + $this->rolls[$roll+1] == 10;
	}

	public function isStrike($roll): bool
	{
		return $this->rolls[$roll] == 10;
	}

	private function strikeBonus($roll): int
	{
		return 10 + $this->rolls[$roll+1] + $this->rolls[$roll+2];
	}

	private function spareBonus($roll): int
	{
		return 10 + $this->rolls[$roll+2];
	}

	private function guardAgainstInvalidRoll(int $pins)
	{
		if ($pins < 0)
		{
			throw new \InvalidArgumentException();
			
		}
	}
}