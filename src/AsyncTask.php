<?php

namespace omegaalfa\AsyncTask;

use Closure;

class AsyncTask
{

	/**
	 * @var callable
	 */
	protected $runnable;

	/**
	 * @param  callable  $runnable
	 */
	public function __construct(callable $runnable)
	{
		$this->runnable = $runnable;
	}

	/**
	 * @return Closure
	 */
	public function run(): Closure
	{
		return function() {
			call_user_func($this->runnable);
		};
	}
}
