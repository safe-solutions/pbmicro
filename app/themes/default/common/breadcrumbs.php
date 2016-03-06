<ol class="breadcrumb">
	<? $current = end($breadcrumbs_tree); ?>
	<? foreach ($breadcrumbs_tree as $url=>$title): ?>
		<? if ($title == $current): ?>
			<li class="active"><?=$title?></li>
		<? else: ?>
			<li><a href="<?=$url?>"><?=$title?></a></li>
		<? endif; ?>
	<? endforeach; ?>
</ol>