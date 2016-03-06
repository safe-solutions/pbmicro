<? foreach ($articles as $article): ?>
	<a href="<?=Router::url('article_view', ['category_url'=>$article->category()->url, 'url'=>$article->url])?>"><?=$article->title?></a><br>
<? endforeach; ?>