<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Example</title>
	<style>
		html,
		body {
			height: 100%;
		}

		body {
			display: -ms-flexbox;
			display: flex;
			-ms-flex-align: center;
			align-items: center;
			padding-top: 40px;
			padding-bottom: 40px;
			background-color: #f5f5f5;
		}

		.form-signin {
			width: 100%;
			max-width: 330px;
			padding: 15px;
			margin: auto;
		}

		.form-signin .checkbox {
			font-weight: 400;
		}

		.form-signin .form-control {
			position: relative;
			box-sizing: border-box;
			height: auto;
			padding: 10px;
			font-size: 16px;
		}

		.form-signin .form-control:focus {
			z-index: 2;
		}

		.form-signin input[type="email"] {
			margin-bottom: -1px;
			border-bottom-right-radius: 0;
			border-bottom-left-radius: 0;
		}

		.form-signin input[type="password"] {
			margin-bottom: 10px;
			border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
	</style>
</head>

<body>

	<form class="form-signin" action="/login/process" method="post">
		<h1 class="h3 mb-3 font-weight-normal">Please Sign In</h1>
		<label for="username" class="sr-only">Email address</label>
		<input type="email" name="username" id="username" class="form-control" placeholder="Email address" required autofocus value="donmyers@quadratec.com">
		<label for="password" class="sr-only">Password</label>
		<input type="password" name="password" id="password" class="form-control" placeholder="Password" required value="password">
		<div class="checkbox mb-3">
			<label>
				<input type="checkbox" name="remember" value="1"> Remember me
			</label>
		</div>
		<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
		<p>
			<div id="notify"></div>
		</p>
	</form>
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script>
		document.addEventListener("DOMContentLoaded", function(e) {
			jQuery.get('/notify', function(data) {
				console.log(data);
				if (data.error) {
					$('#notify').html('<div class="alert alert-' + data.error.status + '" role="alert">' + data.error.msg + '</div>');
				}
			});
		});
	</script>
</body>

</html>