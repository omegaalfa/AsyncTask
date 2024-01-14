<?php

declare(strict_types=1);

namespace omegaalfa\AsyncTask;

use Closure;

class AsyncTask
{

	/**
	 * @var callable
	 */
	protected $runnable;

	/**
	 * @var mixed
	 */
	protected mixed $result;

	/**
	 * @param  callable  $runnable
	 */
	public function __construct(callable $runnable)
	{
		$this->runnable = $runnable;
	}

	/**
	 * @return mixed
	 */
	public function getResult(): mixed
	{
		return $this->result ?? null;
	}

	/**
	 * @return Closure
	 */
	public function run(): Closure
	{
		return function() {
			$this->result[] = call_user_func($this->runnable);
		};
	}
}
