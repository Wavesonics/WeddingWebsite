<?php
include_once "guestbookentry.class.php";

$fileContents = file_get_contents("guestbook.json");
$entries = json_decode( $fileContents );

$rows =  count( $entries );

if( $rows <= 0 )
{
	echo 'No one has said hello yet, be the first!';
	exit;
}

$row = 0;
if( is_numeric( $_GET['row'] ) && $_GET['row'] >= 0 && $_GET['row'] < $rows )
{
	$row = $_GET['row'];
}

if ($rows > 10)
{
	if (!isset ($row) )
	{
		$row = 0;
	}

	print ("<table class=\"guestbookLinks\"><tr><td width=\"50%\">");

	if ($row > 0)
	{
		echo "<div class=\"nextPage\"><< <a href=\"guestbook.shtml?row=" . ($row - 10) . "\">Next 10</a></div>";
	}

	print ("</td><td width=\"50%\">");

	if ( ($rows - $row) > 10)
	{
		echo "<div class=\"previousPage\"><a href=\"guestbook.shtml?row=" . ($row + 10) . "\">Previous 10</a> >></div>";
	}

	print ("</td></tr></table>");

	$endRow = $row + 10;
	if($endRow > $rows)
	{
		$endRow = $rows;
	}
	for ($i = $row; $i < $endRow; $i++)
	{
		renderEntries( $entries[$i], $i % 2 == 1 );
	}
}
else
{
	for ($i=0; $i < $rows; $i++)
	{
		renderEntries( $entries[$i], $i % 2 == 1 );
	}
}
 
// Render entry to HTML 
function renderEntries( $entry, $altRow )
{
	$alt = '';
	if( $altRow === true )
	{
		$alt = 'alt';
	}

	echo "<div class=\"guestBookEntry $alt\">";
	echo  '<h3><strong>' .$entry->name . '</strong> -  <i>' . date('d M Y', $entry->date) . '</i></h3>' .
			$entry->message;
	echo '</div>';
}
?>