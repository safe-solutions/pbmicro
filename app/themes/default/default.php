<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?=$title?> - PrettyBits Micro Demo</title>
<link href="/assets/css/bootstrap.css" rel="stylesheet" />
<script type = "text/javascript" src = "/assets/js/jquery-1.11.2.min.js"></script>
<script type = "text/javascript" src = "/assets/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<?=(isset($breadcrumbs) ? $breadcrumbs : '')?>
			<h1><?=$title?></h1>
			<?=$content?>
		</div>
	</div>
</div>
</body>
</html>