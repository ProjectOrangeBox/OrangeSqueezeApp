<?php

function println(string $msg, string $filename = 'println'): void
{
	file_put_contents(__ROOT__ . '/var/logs/' . $filename . '.log', date('Y-m-d H:i:s') . chr(9) . $msg . PHP_EOL, FILE_APPEND | LOCK_EX);
}

/*
function showException($exception): void
{
	$echo = 'Exception Thrown:' . chr(9) . (string) $exception;

	echo $echo . PHP_EOL;

	println($echo, 'exception');

	exit(1);
}
*/

function showException($exception): void
{
	ob_flush();

	$exception = (string) $exception;

	log_message('critical', $exception);

	if (PHP_SAPI == 'cli') {
		echo 'Exception Thrown:' . PHP_EOL . $exception . PHP_EOL;
	} else {
		echo '<h2>Exception Thrown:</h2><pre>Error: ' . $exception . '</pre>';
	}

	exit(1);
}
/*
function showException($exception): void
{
	echo "Uncaught exception: ", $exception->getMessage() . '<br>';
	echo 'File ' . $exception->getFile() . '<br>';
	echo 'Line ' . $exception->getLine() . '<br>';
	exit(1);
}
*/

set_exception_handler('showException');

function showError($errno, $errstr, $errfile, $errline)
{
	if (!(error_reporting() & $errno)) {
		return false;
	}

	echo "<b>ERROR</b>[$errno]<br> $errstr<br>";
	echo "Line $errline of $errfile<br>";
	echo "PHP " . PHP_VERSION . " (" . PHP_OS . ")<br>";
	exit(1);
}

set_error_handler('showError');

require __ROOT__ . '/vendor/autoload.php';

(new \projectorangebox\app\App(parse_ini_file(__ROOT__ . '/.env', true, INI_SCANNER_TYPED)))->dispatch();
