<?php

require_once("ex00/Color.class.php");
require_once("ex01/Vertex.class.php");
require_once("ex02/Vector.class.php");
require_once("ex03/Matrix.class.php");
Matrix::$verbose = true;
new Matrix(["preset"=>Matrix::RX, "angle"=>4]);
//$vect->normalize();
//$vect->crossProduct($vect2);
//Color::doc();

?>