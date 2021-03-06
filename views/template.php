<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Example</title>
</head>
<style>
	body {
		background-color: #EBEDF3
	}

	.e {
		border: 1px solid black;
		padding: 4px 8px;
		border-radius: 4px;
		margin: 2px;
		height: 36px;
		line-height: 36px;
	}
</style>

<body>
	<p class="e"><?= $start ?></p>
	<p class="e">Start Template Build <?= date('H:i:s') ?></p>
	<div class="e">
		<span id="div1">Div 1</span>
	</div>
	<div class="e">
		<span id="div2">Div 2</span>
	</div>
	<div class="e">
		<span id="div3">Div 3</span>
	</div>
	<div class="e">
		<span id="div4">Div 4</span>
	</div>
	<div class="e">
		<span id="div5">Div 5</span>
	</div>
	<div class="e">
		<span id="div6">Div 6</span>
	</div>
	<div class="e">
		<span id="div7">Div 7</span>
	</div>
	<div class="e">
		<span id="div8">Div 8</span>
	</div>
	<div class="e">
		<span id="div9">Div 9</span>
	</div>
	<p class="e">End Template Build <?= date('H:i:s') ?></p>
	<p class="e">
		<span id="endController"></span>
	</p>
</body>

</html>