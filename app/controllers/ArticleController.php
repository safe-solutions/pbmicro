<?php
class ArticleController extends Controller
{
	public function action_index($request)
	{
		$category = Category::where('url', $request->url)->first();
		if (!$category->exists()) Error::create(404);
		$articles = $category->articles();
		$breadcrumbs_tree = [
			'/'=>'Главная',
			''=>$category->title
		];
		TemplateView::template([
				'breadcrumbs'=>'common/breadcrumbs',
				'content'=>'article/index',
				'main'=>'default'
			])
			->bind('breadcrumbs_tree', $breadcrumbs_tree)
			->bind('title', $category->title)
			->bind('articles', $articles)
			->compile()
			->display();
	}
	
	public function action_view($request)
	{
		$category = Category::where('url', $request->category_url)->first();
		if (!$category->exists()) Error::create(404);
		$article = $category->articles()->where('url', $request->url)->first();
		if (!$article->exists()) Error::create(404);
		$article->views++;
		$article->save();
		$comments = $article->comments()->get();
		$breadcrumbs_tree = [
			'/'=>'Главная',
			Router::url('article_index', ['url'=>$request->category_url])=>$category->title,
			''=>$article->title
		];
		TemplateView::template([
				'breadcrumbs'=>'common/breadcrumbs',
				'content'=>'article/view',
				'main'=>'default'
			])
			->bind('breadcrumbs_tree', $breadcrumbs_tree)
			->bind('title', $article->title)
			->bind('article', $article)
			->bind('comments', $comments)
			->compile()
			->display();
	}
	
	public function action_comment($request)
	{
		$category = Category::where('url', $request->category_url)->first();
		if (!$category->exists()) Error::create(404);
		$article = $category->articles()->where('url', $request->url)->first();
		if (!$article->exists()) Error::create(404);
		$article->comments()->create($_POST)->save();
		Router::redirect(Router::url('article_view', ['category_url'=>$article->category()->url, 'url'=>$article->url]));
	}
	
	public function action_delete($request)
	{
		Comment::find($request->id)->delete();
		Router::back();
	}
}