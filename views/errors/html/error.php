<?php

if (count($errors)) {
	foreach ($errors as $group => $record) {
		foreach ($record as $value) {
			echo '<div class="error-group-' . $group . ' error">' . $value . '</div>' . PHP_EOL;
		}
	}
}
