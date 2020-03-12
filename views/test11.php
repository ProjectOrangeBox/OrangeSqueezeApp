<?php pear::extends('_templates/default') ?>

<?php pear::block('container') ?>
Welcome!

<p>Name: <?= $name ?></p>

<p>Age: <?= $age ?></p>

<?php pear::element('div', ['id' => 'notify']) ?>

<?php pear::end() ?>