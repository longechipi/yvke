<?php
//Fecha creacion 10-06-2021//
//Autor: Jean Castillo//
////////////////////////CONEXION A BASE DE DATOS SIGESP PRINCIPAL ACTUAL////////////////////////
$host        = "host = 192.168.0.215";
$port        = "port = 5432";
$dbname      = "dbname = 2021_radio_mundial_BsD";
$credentials = "user = postgres password=*yvke5050pg*";
$conP = pg_connect("$host $port $dbname $credentials");
if (!$conP) {
   echo "<center><h1>¡Error en de conexion con la Base de Dato " . $dbname . " </h1></center>";
}
////////////////////////CONEXION A BASE DE DATOS USUARIOS////////////////////////
$host2        = "host = 127.0.0.1";
$port2        = "port = 5432";
$dbname2      = "dbname = test";
$credentials2 = "user = postgres password=123456";
$conU = pg_connect("$host2 $port2 $dbname2 $credentials2");
if (!$conU) {
   echo "<center><h1>¡Error en de conexion con la Base de Dato Usuarios" . $dbname2 . "</h1></center>";
}
////////////////////////CONEXION A BASE DE DATOS PRINCIPAL 2020////////////////////////
$host3        = "host = 192.168.0.215";
$port3        = "port = 5432";
$dbname3      = "dbname = 2020_radio_mundial";
$credentials3 = "user = postgres password=*yvke5050pg*";
$conn2020 = pg_connect("$host3 $port3 $dbname3 $credentials3");
if (!$conn2020) {
   echo "<center><h1>¡Error en de conexion con la Base de Dato " . $dbname3 . "</h1></center>";
}
////////////////////////CONEXION A BASE DE DATOS DYSAI////////////////////////
$host4        = "host = 127.0.0.1";
$port4        = "port = 5432";
$dbname4      = "dbname = dysai";
$credentials4 = "user = postgres password=123456";
$conDy = pg_connect("$host4 $port4 $dbname4 $credentials4");
if (!$conDy) {
   echo "<center><h1>¡Error en de conexion con la Base de Dato " . $dbname4 . "</h1></center>";
}
