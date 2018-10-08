<?php

class Matrix{
	static $verbose = false;

	private $matrix = [
						[1, 0, 0, 0],
						[0, 1, 0, 0],
						[0, 0, 1, 0],
						[0, 0, 0, 1]
					];

	function __construct(){


		if (self::$verbose)
			echo $this." constructed.\n";
	}
	
	static function doc(){
		$file = fopen(__DIR__."/".get_class().".doc.txt", "r");
		echo "\n";
		while ($file && !feof($file)){
			echo fgets($file);
		}
		echo "\n";
		fclose($file);
	}

	function __toString(){
		$str = "hahahahaha";
		return "Matrix(\n$str\n)";
	}

	function __destruct(){
		if(self::$verbose)
			echo $this." destructed.\n";
	}
}

?>