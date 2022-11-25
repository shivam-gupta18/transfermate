<?php

namespace app;

class Controller 
{
	public function getBooks(\Transfermate\app $getBook): \Transfermate\app  
	{
		$searchBook = $getBook->search($_GET['search']);

		return $searchBook;
	}
}