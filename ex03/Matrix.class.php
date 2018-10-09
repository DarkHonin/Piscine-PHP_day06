<?php

class Matrix{

	const IDENTITY = 0;
	const SCALE = 1;
	const RX = 2;
	const RY = 3;
	const RZ = 4;
	const TRANSLATION = 5;
	const PROJECTION = 6;

	private const params = [
		Matrix::IDENTITY => [],
		Matrix::SCALE => ['scale'],
		Matrix::RX => ['angle'],
		Matrix::RY => ['angle'],
		Matrix::RZ => ['angle'],
		Matrix::TRANSLATION => ['vtc'],
		Matrix::PROJECTION => ['fov', 'ratio', 'near', 'far']
	];

	static $verbose = false;

	private $_matrix = [
						[1, 0, 0, 0],
						[0, 1, 0, 0],
						[0, 0, 1, 0],
						[0, 0, 0, 1]
					];

	private $_preset;
	private $_scale;
	private $_angle;
	private $_vtc;
	private $_fov;
	private $_ratio;
	private $_near;
	private $_far;

	function __construct($params){
		if (!isset($params['preset']) || !array_key_exists($params['preset'], self::params))
			throw (new ArgumentCountError("No matrix preset"));
		$this->_preset = $params['preset'];
		foreach(self::params[$this->_preset] as $v){
			if (!isset($params[$v]))
				throw (new ArgumentCountError("Paramater missing: $v"));
			$var = "_$v";
			$this->$var = $params[$v];
		}
		$this->configure();
		if (self::$verbose)
			echo $this." constructed.\n";
	}

	private function configure(){
		switch($this->_preset){
			case self::IDENTITY: return;
			case self::SCALE:
				foreach($this->_matrix as $k=>$v)
					$this->_matrix[$k][$k] = $this->_scale;
				return ;
			case self::RX:
				$this->_matrix[1] = [0, cos($this->_angle), -sin($this->_angle), 0];
				$this->_matrix[2] = [0, sin($this->_angle), cos($this->_angle), 0];
				return;
			case self::RY:
				$this->_matrix[0] = [cos($this->_angle), 0, sin($this->_angle), 0];
				$this->_matrix[2] = [-sin($this->_angle), 1, cos($this->_angle), 0];
				return;
			case self::RZ:
				$this->_matrix[0] = [cos($this->_angle), -sin($this->_angle), 0, 0];
				$this->_matrix[1] = [sin($this->_angle), cos($this->_angle), 0, 0];
				return;
			case self::TRANSLATION:
				if (!($this->_vtc instanceof Vector))
					throw(ValueError("Invalid value for vtc"));
				$this->matrix[0][3] = $this->_vtc->getX();
				$this->matrix[1][3] = $this->_vtc->getY();
				$this->matrix[2][3] = $this->_vtc->getZ();
				return;
		}
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
		$str = sprintf("\tM | vtx1 | vtx2 | vtx3 | vtx4\n");
		$str .=sprintf("\t..|......|......|......|......\n");
		foreach($this->_matrix as $k=>$d){
			$str .=vsprintf("\t$k |%6.2f|%6.2f|%6.2f|%6.2f\n", $d);
		}
		return "Matrix(\n$str\n)";
	}

	function __destruct(){
		if(self::$verbose)
			echo $this." destructed.\n";
	}
}

?>