<?php
require_once 'system/PBMicro.php';

Router::map('get', '/hello_world', ['as'=>'hello_world'], function ($request) use ($app) {
	echo 'Hello, World!';
});

Router::map('get', '/', ['as'=>'category_index'], 'index@CategoryController');
Router::map('get', '/delete/{id}', ['as'=>'article_delete_comment', 'rules'=>['id'=>'\d*']], 'delete@ArticleController');
Router::map('get', '/{url}', ['as'=>'article_index'], 'index@ArticleController');
Router::map('get', '/{category_url}/{url}', ['as'=>'article_view'], 'view@ArticleController');
Router::map('post', '/{category_url}/{url}', ['as'=>'article_add_comment'], 'comment@ArticleController');

$config_routes = false;

$app
	->configure(['app/config/database.php', 'app/config/main.php'])
	->if($config_routes)
		->configure(['app/config/routes.php'])
	->endif()
	->bind('Db', 'db')
	->run();