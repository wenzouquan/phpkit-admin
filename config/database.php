<?php
$data =   require dirname(dirname(dirname(dirname(__FILE__))))."/make/database.php";//
return array(
	"host" =>$data['hostname'],
	"username" => $data['username'],
	"password" => $data['password'],
	"dbname" => $data['database'],
	"charset" => "utf8",
	"prefix"=>$data['prefix'],
);