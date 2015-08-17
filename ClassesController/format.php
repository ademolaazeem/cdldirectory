<?php

class Format
{
	public function __construct()
	{
	}
	
	public function processfield($field)
	{
		if(get_magic_quotes_gpc())
			return htmlspecialchars($field);
		else
			return htmlspecialchars(addslashes($field));	
	}
}

?>