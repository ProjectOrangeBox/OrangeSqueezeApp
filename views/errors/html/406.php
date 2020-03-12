<?php

if (count($errors)) {
	foreach ($errors as $group => $record) {
		foreach ($record as $value) {
			echo '<p class="error-group-' . $group . ' error">' . $value . '</p>' . PHP_EOL;
		}
	}
}
