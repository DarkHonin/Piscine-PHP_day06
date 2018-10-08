<?php

require_once("ex00/Color.class.php");
require_once("ex01/Vertex.class.php");
require_once("ex02/Vector.class.php");

$o = new Vertex(["x"=>0,"y"=>20,"z"=>0]);
$d = new Vertex(["x"=>10,"y"=>2000,"z"=>10]);

$vect = new Vector(["orig"=>$o, "dest"=>$d]);
$vect2 = new Vector(["dest"=>$d]);
Vector::doc();
//$vect->normalize();
//$vect->crossProduct($vect2);
//Color::doc();

?>