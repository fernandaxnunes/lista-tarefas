<?php

	require "../../app_lista_tarefas/conexao.php";
	require "../../app_lista_tarefas/tarefa.service.php";
	require "../../app_lista_tarefas/tarefa_model.php";

	$acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

	if (isset($_GET['acao']) && $_GET['acao'] == 'inserir') {
		$tarefa = new Tarefa();
		$tarefa->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->create();

		header('Location: nova_tarefa.php?inclusao=1');

	}else if($acao == 'recuperar'){
		$tarefa = new Tarefa();
		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->read();

	}else if($acao == 'atualizar'){
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_POST['id']);
		$tarefa->__set('tarefa', $_POST['tarefa']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		if($tarefaService->update()){

			if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}
		}
	}else if($acao == 'remover'){
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->delete();

		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}
		
	}else if($acao == 'realizada'){
		$tarefa = new Tarefa();
		$tarefa->__set('id', $_GET['id']);
		$tarefa->__set('id_status', 2);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefaService->realizada();
		
		if(isset($_GET['pag']) && $_GET['pag'] == 'index'){
				header('location: index.php');
			}else{
				header('location: todas_tarefas.php');
			}
	}else if($acao == 'recuperarPendentes'){
		$tarefa = new Tarefa();
		$tarefa->__set('id_status', 1);

		$conexao = new Conexao();

		$tarefaService = new TarefaService($conexao, $tarefa);
		$tarefas = $tarefaService->recuperarPendentes();
	}

?>