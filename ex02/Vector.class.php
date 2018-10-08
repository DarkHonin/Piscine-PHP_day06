<?php

require_once("ex01/Vertex.class.php");

class Vector{
	private $_x = 0.0;
	private $_y = 0.0;
	private $_z = 0.0;
	private $_w = 0.0;
	static $verbose = false;

	function __construct($params){
		if(isset($params['orig']) && $params['orig'] instanceof Vertex)
			$O = $params['orig'];
		else
			$O = new Vertex(["x"=>0,"y"=>0,"z"=>0]);
		$D = $params['dest'];
		foreach(str_split("XYZW") as $k=>$v){
			$gstr = "get$v";
			$sstr = "_".strtolower($v);
			$this->$sstr = $D->$gstr() - $O->$gstr();
		}
		if (self::$verbose)
			echo $this." constructed.\n";
	}

	function getX(){ return $this->_x ;}
	function getY(){ return $this->_y ;}
	function getZ(){ return $this->_z ;}
	function getW(){ return $this->_w ;}
			
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
		return "Vector( x: $this->_x, y: $this->_y, z: $this->_z, w: $this->_w)";
	}

	function __destruct(){
		if(self::$verbose)
			echo $this." destructed.\n";
	}

	function magnatude() : float{
		$t = 0;
		foreach(str_split("_x_y_z", 2) as $v)
			$t += pow($this->$v, 2);
		return sqrt($t);
	}

	function normalize() : Vector{
		$m = $this->magnatude();
		if ($m == 1) return clone $this;
		$arr = [];
		foreach(str_split("xyz", 1) as $v)
		{
			$str = "_$v";
			$arr[$v] = $this->$str / $m;
		}
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function add(Vector $D) : Vector{
		$arr = [];
		foreach(str_split("XYZW") as $k=>$v){
			$gstr = "get$v";
			$arr[strtolower($v)] = $D->$gstr() + $this->$gstr();
		}
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function sub(Vector $D) : Vector{
		$arr = [];
		foreach(str_split("XYZW") as $k=>$v){
			$gstr = "get$v";
			$arr[strtolower($v)] = $D->$gstr() - $this->$gstr();
		}
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function opposite() : Vector{
		$arr = [];
		foreach(str_split("_x_y_z", 2) as $v)
			$arr[$v[1]] = $this->$v * -1;
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function scalarProduct($k) : Vector{
		$arr = [];
		foreach(str_split("_x_y_z", 2) as $v)
			$arr[$v[1]] = $this->$v * $k;
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function dotProduct(Vector $rhs) : float{
		$arr = [];
		foreach(str_split("XYZ") as $k=>$v){
			$gstr = "get$v";
			$arr[strtolower($v)] = $D->$gstr() * $rgs->$gstr();
		}
		return new Vector(["dest"=> new Vertex($arr)]);
	}

	function cos(Vector $rhs) : float{
		$a = $this->magnatude() * $rhs->magnatude();
		$b = $this->dotProduct() + $rhs->dotProduct();
		$c = $b / $a;
		return acos($c);
	}

	function crossProduct(Vector $rhs) : Vector{
		$arr = [];
		$keys = str_split("XYZ");
		foreach($keys as $k=>$v){
			$gstr1 = "get".$keys[($k + 1) % 3];
			$gstr2 = "get".$keys[($k + 2) % 3];
			$arr[strtolower($v)] = ($this->$gstr1() * $rhs->$gstr2()) - ($rhs->$gstr1() * $this->$gstr2());
		}
		return new Vector(["dest"=> new Vertex($arr)]);
	}
}

?>