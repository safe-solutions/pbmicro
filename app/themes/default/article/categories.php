<? foreach ($categories as $category): ?>
	<a href="<?=Router::url('article_index', ['url'=>$category->url])?>"><?=$category->title?></a><br>
<? endforeach; ?>