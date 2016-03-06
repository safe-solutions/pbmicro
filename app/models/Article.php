<?php
class Article extends DataModel
{
	protected $_table = 'articles';
	protected $_autofill = ['title'];
	
	public function category()
	{
		return $this->belongs_to('Category');
	}
	
	public function comments()
	{
		return $this->has_many('Comment');
	}
}