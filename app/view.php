<?php
namespace app;

class View 
{
	public function show(\Transfermate\app $Model)
	{
		$viewHtml = '<h1>Search by Author</h1>';

		$viewHtml .= 
		'
			<form action="" method="get">
				<input type="hidden" value="getAllBooks" name="route" />
				<input type="text" name="search" placeholder="Enter Author name" />
				<input type="submit" value="Search"/>
			</form>
			
		';

		$viewHtml .= '
			<div class="tbl-header">
				<table>
					<thead>
						<tr>
							<th>Author</th>
							<th>Book</th>
						</tr>
					</thead>
				</table>
			</div>';


		$viewHtml .= '
			<div class="tbl-content">
				<table>
					<tbody>';
		
					foreach ($Model->search() as $book) 
					{
						$viewHtml .= 	'<tr>';
							$viewHtml .= '<td>' . $book['author_name'].'</td>';
							$viewHtml .= '<td>' . $book['book_name'] . '</td>';
						$viewHtml .= 	'</tr>';
					}
		$viewHtml .= '
					</tbody>
				</table>
			</div>';

		return $viewHtml;

	}
}
