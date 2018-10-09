<?php

class Vertex{
	private $_x = 0;
	private $_y = 0;
	private $_z = 0;
	private $_w = 1;
	private $_color;
	static	$verbose = false;

	function __construct($params){
		$this->_x = ($params["x"]);
		$this->_y = ($params["y"]);
		$this->_z = ($params["z"]);
		$this->_w = (isset($params["w"]) ? $params["z"] : 1);
		$this->_color = (isset($params["color"]) && ($params["color"] instanceof Color) ? $params["color"]: new Color(["rgb" => 0xFFFFFF]));
		if (self::$verbose)
			echo $this." constructed.\n";
	}

	function __toString(){
		return "Vertex( x: $this->_x, y: $this->_y, z: $this->_z, w: $this->_w, ".$this->_color.")";
	}

	function __destruct(){
		if(self::$verbose)
			echo $this." destructed.\n";
	}

	function getX(){ return $this->_x ;}
	function getY(){ return $this->_y ;}
	function getZ(){ return $this->_z ;}
	function getW(){ return $this->_w ;}
	
	function setX($val){ $this->_x = $val;}
	function setY($val){ $this->_y = $val;}
	function setZ($val){ $this->_z = $val;}
	function setW($val){ $this->_w = $val;}
	function getColor(){ return $this->_color ;}
	function setColor( Color $val){ $this->_color = $val;}
	
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