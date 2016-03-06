<?php
class Category extends DataModel
{
	protected $_table = 'categories';
	
	public function articles()
	{
		return $this->has_many('Article');
	}
}