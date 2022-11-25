<?php
	$conn = "pgsql:host=localhost;port=5432;dbname=transfermate;user=root;password=root";
	$pdo = new \PDO($conn);
	$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

	$route = $_GET['route'] ?? '';

	if ($route == '')
	{
		$Model = new \Transfermate\app($pdo);
		$View = new \app\View($pdo);
	}
	else if ($route == 'getAllBooks')
	{
		$Model = new \Transfermate\app($pdo);
		$View = new \app\View();
		$Controller = new \app\Controller();

		$Model = $Controller->getBooks($Model);
	}
	else
	{
		http_response_code(404);
		echo 'Page not found';
	}

	echo $View->show($Model);