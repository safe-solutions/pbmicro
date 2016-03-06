<?php
class Comment extends DataModel
{
	protected $_table = 'comments';
	protected $_autofill = ['title'];
}