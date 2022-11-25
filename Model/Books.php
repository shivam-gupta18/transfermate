<?php
namespace Transfermate;

class Books 
{
	private $pdo;
	private $keyword;

	public function __construct(\PDO $pdo, string $keyword = '') 
	{
		$this->pdo = $pdo;
		$this->keyword = $keyword;
	}

	public function search($keyword) 
	{
		if ($this->keyword) 
		{
			$where = " WHERE authors.author_name LIKE %". $this->keyword ."% ";
		}
		else 
		{
			$where = '';
		}

		$query = $this->pdo->prepare("SELECT books.book_id, books.author_id, books.book_name, authors.author_name FROM books JOIN authors ON books.author_id = authors.author_id". $where);
		$query->execute();

		return $query->fetchAll();
	}

	public function getSearchKeyword()
	{
		return $this->keyword;
	}
}