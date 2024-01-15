<?php

// tests/AsyncTaskManagerTest.php

use PHPUnit\Framework\TestCase;
use omegaalfa\AsyncTask\AsyncTaskManager;
use omegaalfa\AsyncTask\AsyncTask;

class AsyncTaskManagerTest extends TestCase
{
    public function testRunAsyncTask()
    {
        $taskManager = new AsyncTaskManager();
        $ran = false;

        // Define uma tarefa assíncrona simples
        $asyncTask = new AsyncTask(function () use (&$ran) {
            $ran = true;
        });

        // Submete a tarefa ao AsyncTaskManager
        $taskManager->submit($asyncTask);

        // Executa todas as tarefas em segundo plano
        $taskManager->run();

        // Verifica se a tarefa foi executada
        $this->assertTrue($ran);
    }

    public function testRunMultipleAsyncTasks()
    {
        $taskManager = new AsyncTaskManager();
        $ranTasks = 0;

        // Define múltiplas tarefas assíncronas simples
        for ($i = 0; $i < 3; $i++) {
            $asyncTask = new AsyncTask(function () use (&$ranTasks) {
                $ranTasks++;
            });

            // Submete cada tarefa ao AsyncTaskManager
            $taskManager->submit($asyncTask);
        }

        // Executa todas as tarefas em segundo plano
        $taskManager->run();

        // Verifica se todas as tarefas foram executadas
        $this->assertEquals(3, $ranTasks);
    }

    public function testShutdownAsyncTaskManager()
    {
        $taskManager = new AsyncTaskManager();

        // Define uma tarefa assíncrona simples
        $asyncTask = new AsyncTask(function () {});

        // Submete a tarefa ao AsyncTaskManager
        $taskManager->submit($asyncTask);

        // Desliga o AsyncTaskManager
        $taskManager->shutdown();

        // Executa todas as tarefas (não deve haver execução, pois o gerenciador foi desligado)
        $taskManager->run();

        // Verifica se o AsyncTaskManager está desligado
        $this->assertTrue($taskManager->isShutdown());
    }
}
