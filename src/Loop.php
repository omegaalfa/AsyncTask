<?php

declare(strict_types=1);

namespace omegaalfa\AsyncTask;

class Loop
{

	/**
	 * @var array
	 */
	protected array $callables;

	/**
	 * @var AsyncTaskManager
	 */
	protected AsyncTaskManager $AsyncTaskManager;

	/**
	 * @var AsyncTask
	 */
	protected AsyncTask $AsyncTask;


	public function __construct()
	{
		$this->AsyncTaskManager = new AsyncTaskManager();
	}


	/**
	 * @param  callable  $callable
	 *
	 * @return $this
	 */
	public function defer(callable $callable): static
	{
		$this->AsyncTask = new AsyncTask($callable);
		$this->AsyncTaskManager->submit($this->AsyncTask);

		return $this;
	}

	/**
	 * @param  mixed     $name
	 * @param  callable  $callable
	 *
	 * @return $this
	 */
	public function addTask(mixed $name, callable $callable): static
	{
		$this->AsyncTask = new AsyncTask($callable);
		$this->AsyncTaskManager->submit($this->AsyncTask, $name);

		return $this;
	}

	/**
	 * @return mixed
	 */
	public function getResult(): mixed
	{
		return $this->AsyncTask->getResult();
	}


	/**
	 * @param  mixed|null  $tasks
	 *
	 * @return void
	 */
	public function run(mixed $tasks = null): void
	{
		$this->AsyncTaskManager->run($tasks);
	}
}
