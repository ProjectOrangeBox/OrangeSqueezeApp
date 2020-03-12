<?php pear::plugins() ?>

<?php pear::block('js') ?>
<!-- https://cdnjs.com/ -->
<!-- start block js -->
<!-- middle block js -->
<?php pear::parentBlock() ?>
<!-- end block js -->
<?php pear::end() ?>

<?php pear::block('css') ?>
<!-- start block css -->
<!-- middle block css -->
<?php pear::parentBlock() ?>
<!-- end block css -->
<?php pear::end() ?>

<?php pear::include('_templates/header') ?>
<div id="container" class="container hide-until-domready">
	<?php pear::getBlock('container') ?>
</div>
<?php pear::include('_templates/footer') ?>