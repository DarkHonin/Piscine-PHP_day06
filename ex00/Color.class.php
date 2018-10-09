<?php

class Color{

	public $r = 0;
	public $g = 0;
	public $b = 0;

	static $verbose = false;

	function __construct($color){
		if(is_array($color) && array_key_exists("rgb", $color)){
			$color['rgb'] = min(intval($color['rgb']), 0xFFFFFF);
			$parts = [ 
				($color['rgb'] >> 16) & 0xFF,
				($color['rgb'] >> 8) & 0xFF,
				$color['rgb']
			];
		}else
			$parts = [
				$color['red'],
				$color['green'],
				$color['blue']
			];
		foreach($parts as $k=>$v){
			$parts[$k] = min(intval($v), 255);
			if ($parts[$k] < 0)
				$parts[$k] = 0;
		}
		$this->r = $parts[0];
		$this->g = $parts[1];
		$this->b = $parts[2];
		
		if(self::$verbose)
			echo $this->__toString()." constructed.\n";
	}

	function __toString(){
		return "Color( red: $this->r, green: $this->g, blue: $this->b)";
	}

	function __destruct(){
		if(self::$verbose)
			echo $this." destructed.\n";
	}

	function add(Color $a){
		$parts = [];
		$keys = ["red", "green", "blue"];
		foreach(str_split("rgb") as $k=>$c)
			$parts[$keys[$k]] = $a->$c + $this->$c;
		return new Color($parts);
	}

	function sub(Color $a){
		$parts = [];
		$keys = ["red", "green", "blue"];
		foreach(str_split("rgb") as $k=>$c)
			$parts[$keys[$k]] = $this->$c - $a->$c;
		return new Color($parts);
	}

	function mult($a){
		$parts = [];
		$keys = ["red", "green", "blue"];
		foreach(str_split("rgb") as $k=>$c)
			if ($a instanceof Color)
				$parts[$keys[$k]] = $a->$c * $this->$c;
			else
				$parts[$keys[$k]] = $a * $this->$c;
		return new Color($parts);
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

}


?>