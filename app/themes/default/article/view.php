<p><?=$article->article?></p>
Просмотров: <?=$article->views?>
<h2>Комментарии</h2>
<? foreach ($comments as $comment): ?>
	<p>
		<?=$comment->title?> <a href="<?=Router::url('article_delete_comment', ['id'=>$comment->id])?>">Удалить</a>
	</p>
<? endforeach; ?>
<form method="post">
	Новый комментарий
	<textarea class="form-control" name="title"></textarea>
	<input class="form-control btn btn-primary" type="submit" name="do" value="Добавить">
</form>