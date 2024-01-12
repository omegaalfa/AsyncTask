<?php

namespace src\tasks;

use Fiber;


class AsyncTaskManager
{
	/**
	 * @var array
	 */
	private array $pool = [];

	/**
	 * @param  AsyncTask  $task
	 *
	 * @return void
	 */
	public function submit(AsyncTask $task): void
	{
		$this->pool[] = new Fiber($task->run());
	}

	/**
	 * @return void
	 */
	public function run(): void
	{
		while(!empty($this->pool)) {
			$fiber = array_shift($this->pool);
			if(!$fiber->isStarted()) {
				$fiber->start();
			}
			if($fiber->isSuspended()) {
				$fiber->resume();
			}
			if(!$fiber->isTerminated()) {
				$this->pool[] = $fiber;
			}
		}
	}
}
