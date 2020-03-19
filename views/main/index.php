<? pear::extends('_templates/default') ?>

<? pear::block('container') ?>
<!-- block container start -->
<h1>Hello, world!</h1>
<div class="alert alert-<?= $status ?>" role="alert">
	<?= $msg ?>
</div>

<div class="alert alert-primary" role="alert">
	<?= $name ?>
</div>

<div class="alert alert-primary" role="alert">
	<?= $age ?>
</div>

<?= pear::element('div', ['id' => 'example', 'class' => 'alert alert-primary', 'role' => 'alert'], 'Oh Darn!') ?>

<!-- block container end -->
<? pear::end() ?>

<?php pear::html()->jsVariable('person_name', 'Don Myers') ?>
<?php pear::html()->domready('$(\'#example\').html(person_name);') ?>
