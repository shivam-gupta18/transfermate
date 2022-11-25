<?php 

      getAllXmlFiles('\Downloads\Transfermate\Books\*'); 

      function getAllXmlFiles($folder)
      {
            $dbConnection = "pgsql:host=localhost;port=5432;dbname=transfermate;user=root;password=root";
            $pdo = new PDO($dbConnection);

            $files = glob($folder);
            foreach ($files as $file)
            {
                  if (is_dir($file)) {
                        $files = array_merge($files, getAllXmlFiles($f .'\*'));
                  }
                  else {

                        $xmlFile = simplexml_load_file($f);
      
                        if ($xmlFile != FALSE) 
                        {
                              $jsonData = json_encode($xmlFile);
                              $data = json_decode($jsonData, TRUE);
                        
                              foreach($data['book'] as $book)
                              {
                                    $bookName = $book['name'];
                                    $authorName = $book['author'];
                                    insertUpdateBooks($pdo, $bookName, $authorName);
                              }
                        }
                  }
            }

            return $files;
      }

      function insertUpdateBooks($pdo, $book_name, $author_name)
      {
            $authorExistQuery = "SELECT * FROM authors WHERE author_name = $author_name";
            $authorExists = $pdo->prepare($authorExistQuery);
            $authorExists->execute();
            $getAuthor = $authorExists->fetchAll();

            if(empty($getAuthor))
            {
                  $insertAuthorQuery = "INSERT INTO authors (author_name) VALUES ($author_name)";
                  $insertAuthor = $pdo->prepare($insertAuthorQuery);
                  $insertAuthor->execute();
                  $insertedAuthor = $insertAuthor->rowCount();

                  if($insertedAuthor) 
                        echo "Author Inserted";
                  else 
                        echo "Author not inserted. Something went wrong.";
            }
            
            else 
                  echo "Author Record already exists.";
            
            $author_id = $getAuthor ? $getAuthor : $pdo->lastInsertId();

            $bookExistQuery = "SELECT * FROM books WHERE book_name = $book_name AND author_id = $author_id";
            $bookExists = $pdo->prepare($bookExistQuery);
            $bookExists->execute();
            $getBook = $bookExists->fetchAll();

            $book_id = $getBook;
            if(empty($getBook)) 
            {
                  $insertBookQuery = "INSERT INTO books (book_name, author_id) VALUES ($book_name, $author_id)";
                  $insertBook = $pdo->prepare($insertBookQuery);
                  $insertBook->execute();
                  $insertedBook = $insertBook->rowCount();

                  if($insertedBook){
                        $book_id = $pdo->lastInsertId();
                        echo "Book Inserted";
                  }
                  else 
                        echo "Book not inserted. Something went wrong.";
            }
            else
            {
                  $updateBookQuery = "UPDATE books SET author_id = $author_id WHERE book_id = $book_id";
                  $updateBook = $pdo->prepare($updateBookQuery);
                  $updateBook->execute();
                  $UpdatedBook = $updateBook->rowCount();

                  echo "Book Exist. Record updated";
            }
      }
?>