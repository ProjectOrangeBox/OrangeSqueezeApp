<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title><?= pear::html('title') ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<?= pear::html('meta') ?>
	<?= pear::html('css') ?>
	<style>
		<?= pear::html('style') ?>
	</style>
	<?= pear::html('icon') ?>
	<?= pear::getBlock('head') ?>
</head>

<body class="<?= pear::html('body_class') ?>">