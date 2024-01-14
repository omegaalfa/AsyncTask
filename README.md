# AsyncTask
Gerencia um conjunto de tarefas assíncronas utilizando Fibers

# Descrição

Este repositório contém um código simples para gerenciar tarefas assíncronas utilizando Fibers.
O código consiste em três classes:

- **AsyncTaskManager:** Gerencia um conjunto de tarefas assíncronas.
- **AsyncTask:** Representa uma tarefa assíncrona.
- **Loop:** Oferece uma interface de alto nível para criar e executar tarefas assíncronas.

O `AsyncTaskManager` é responsável por manter um pool de tarefas assíncronas. As tarefas são adicionadas ao pool usando o método `submit()`. O `AsyncTaskManager` então executa as tarefas no pool de forma cooperativa, alternando entre elas até que todas sejam concluídas.

O `AsyncTask` representa uma tarefa assíncrona. As tarefas são criadas instanciando objetos `AsyncTask` passando a lógica da tarefa como um callable no construtor.

O `Loop` oferece uma interface mais amigável para a criação e execução de tarefas assíncronas, facilitando a definição de tarefas e a obtenção de resultados.

# Funcionalidades
- Submissão de tarefas assíncronas ao gerenciador.
- Execução de tarefas em segundo plano até que todas sejam concluídas.
- Utiliza a funcionalidade de Fibers para permitir operações assíncronas.

# Pré-requisitos

PHP 8.1 ou superior

# Instalação

Instruções sobre como instalar o repositório.

# Exemplos

```php

use omegaalfa\AsyncTask\AsyncTask;
use omegaalfa\AsyncTask\AsyncTaskManager
// Cria uma instância do AsyncTaskManager
$taskManager = new AsyncTaskManager();

// Define uma tarefa assíncrona simples
$asyncTask = new AsyncTask(function () {
    // Código a ser executado assincronamente
    echo "Tarefa assíncrona concluída!\n";
});

// Submete a tarefa ao AsyncTaskManager
$taskManager->submit($asyncTask);

// Executa todas as tarefas em segundo plano
$taskManager->run();

```

# Usando a class Loop

```php
//usando o Loop
use omegaalfa\AsyncTask\Loop;

// Cria uma instância do Loop
$loop = new Loop();

// Adiciona tarefa assíncrona ao Loop
$loop->defer(function () {
    // Código a ser executado assincronamente
    return "Tarefa assíncrona concluída!";
});

// Adiciona tarefa com nome ao Loop
$loop->addTask('minhaTarefa', function () {
    // Código da tarefa com nome
    return "Tarefa com nome concluída!";
});

// Executa tarefas em segundo plano, aguarda até que todas sejam concluídas
$loop->run();

// Obtém resultados
$resultado = $loop->getResult();

```

## Contribuição

Se desejar contribuir com melhorias ou correções, fique à vontade para criar uma pull request ou abrir uma issue no repositório.

## Licença

Este projeto está licenciado sob a Licença MIT.
