<?php 
session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new Slim();

$app->config('debug', true);

$app->get('/', function() {
    
	//$sql = new Hcode\DB\Sql();
	
	//$results = $sql->select("SELECT * FROM tb_user");
	
	//echo json_encode($results);
	
	$page = new Page();

	$page->setTpl("index");
	
});

$app->get('/admin', function() {
	
	User::verifyLogin();
	
	$page = new PageAdmin(); //classe

	$page->setTpl("index"); 
	
});

$app->get('/admin/login', function(){
	
	$page = new PageAdmin([
		"header"=>false, //desabilitando o header padrão
		"footer"=>false  //desabilitando o footer padrão
	]);
	
	$page->setTpl("login");
});

$app->post('/admin/login', function (){
	
	User::login($_POST["login"], $_POST["password"]);
	
	header("Location: /admin");
	exit;
	
});

$app->get('/admin/logout', function() {
	
	User::logout();
	
	header("Location: /admin/login");
	exit;
	
});

$app->run();

?>