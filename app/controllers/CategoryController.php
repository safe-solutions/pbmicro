<?php
class CategoryController extends Controller
{
	public function action_index($request)
	{
		$categories = Category::all();
		TemplateView::template([
				'content'=>'article/categories',
				'main'=>'default'
			])
			->bind('title', 'Категории')
			->bind('categories', $categories)
			->compile()
			->display();
	}
}