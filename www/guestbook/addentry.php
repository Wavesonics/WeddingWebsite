<?php
include_once "guestbookentry.class.php";

$MAX_INPUT_LENGTH = 65536;

if ($_POST["message"] != '' && $_POST["name"]) 
{
	// Sanitize and validate input
	$message = substr( $message, 0, $MAX_INPUT_LENGTH );
	$message = str_replace ("\n","<br/>",$_POST["message"]);
	$message = strip_tags ($message, '<br/>');
	$message = htmlspecialchars( $message );
	
	$name = substr( $name, 0, $MAX_INPUT_LENGTH );
	$name = htmlspecialchars( $_POST["name"] );
	
	$entry = new Entry();
	$entry->name = $name;
	$entry->date = time();
	$entry->message = $message;

	$oldEntries = file_get_contents('guestbook.json');
	$entries = json_decode( $oldEntries );

	if( is_array( $entries ) )
	{
		array_unshift( $entries, $entry );
	}
	else
	{
		$entries = array( $entry );
	}
	
	$encodedEntries = json_encode($entries);

	$fileName = fopen ('guestbook.json', 'w');
	fputs ($fileName, $encodedEntries );
	fclose ($fileName);
}

header("Location: /guestbook.shtml");
?>
