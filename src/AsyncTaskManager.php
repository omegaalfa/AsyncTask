<?php

namespace omegaalfa\AsyncTask;

use Fiber;


class AsyncTaskManager
{
	/**
	 * @var array
	 */
	protected array $pool = [];

	/**
	 * @var mixed
	 */
	protected mixed $error = null;

	/**
	 * @var array
	 */
	protected array $taskFailed = [];

	/**
	 * @param  AsyncTask    $task
	 * @param  string|null  $name
	 *
	 * @return void
	 */
	public function submit(AsyncTask $task, string|null $name = null): void
	{
		if($name) {
			$this->pool[$name] = new Fiber($task->run());
		}

		$this->pool[] = new Fiber($task->run());
	}

	/**
	 * @return mixed
	 */
	public function getError(): mixed
	{
		return $this->error;
	}

	/**
	 * @return array
	 */
	public function getFailedTasks(): array
	{
		return $this->taskFailed;
	}


	/**
	 * @return void
	 */
	public function runTasks(): void
	{
		while(!empty($this->pool)) {
			$fiber = array_shift($this->pool);
			try {
				if(!$fiber->isStarted()) {
					$fiber->start();
				}
				if($fiber->isSuspended()) {
					$fiber->resume();
				}
				if(!$fiber->isTerminated()) {
					$this->taskFailed[] = $fiber;
				}
			} catch(\Throwable $e) {
				$this->error = $e->getMessage();
			}
		}
	}

	/**
	 * @param  mixed|null  $tasks
	 *
	 * @return void
	 */
	public function run(mixed $tasks = null): void
	{
		if(is_array($tasks)) {
			foreach($this->pool as $key => $task) {
				if(!in_array($key, $tasks, true)) {
					unset($this->pool[$key]);
				}
			}
		}

		if(is_null($tasks)) {
			foreach($this->pool as $key => $task) {
				if(is_string($key)) {
					unset($this->pool[$key]);
				}
			}
		}

		if(is_string($tasks) && isset($this->pool[$tasks])) {
			foreach($this->pool as $key => $task) {
				if($key !== $tasks) {
					unset($this->pool[$key]);
				}
			}
		}

		$this->runTasks();
	}
}
