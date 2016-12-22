<?php

namespace App\Utils;

class Calc
{
	// Get the sum of the numbers
	public static function add(...$operands)
	{
		$result = $operands[0];

		for ($i = 1; $i < count($operands); $i++) {
			$result = bcadd((float) $result, (float) $operands[$i], 2);
		}

		return (float) $result;
	}

	// Get the subtraction of numbers
	public static function sub(...$operands)
	{
		$result = $operands[0];

		for ($i = 1; $i < count($operands); $i++) {
			$result = bcsub((float) $result, (float) $operands[$i], 2);
		}

		return (float) $result;
	}

	// Get the product of numbers
	public static function mul(...$operands)
	{
		$result = $operands[0];

		for ($i = 1; $i < count($operands); $i++) {
			$result = bcmul((float) $result, (float) $operands[$i], 2);
		}

		return (float) $result;
	}

	// Get the division of numbers
	public static function div(...$operands)
	{
		$result = $operands[0];

		for ($i = 1; $i < count($operands); $i++) {
			$result = bcdiv((float) $result, (float) $operands[$i], 2);
		}

		return (float) $result;
	}

	// Get the percentage of summ
	public static function percent($sum, $percent)
	{
		return (float) bcdiv(bcmul((float) $sum, (float) $percent, 2), 100, 2);
	}
}