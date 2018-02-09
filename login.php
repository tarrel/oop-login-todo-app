<!DOCTYPE html>
<html>
	<head>
		<title>WipeOut - Agjenda ne doren tuaj ne cdo kohe.</title>
		<meta charset="utf-8">

		<!-- Stilizimi personal -->
		<link rel="stylesheet" href="css/style.css">

		<!-- Stilizimi me bootstrap -->
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<nav class="navbar navbar-light bg-faded">
  		<h1 class="navbar-brand mb-0">WipeOut</h1>
			<form class="form-inline my-2 my-lg-0">
	      <span class="navbar-text">
					<a href="register.php">Regjistrohu</a>
				</span>
    	</form>
		</nav>

		<div class="container">
<?php
require_once 'core/init.php';

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'username' => array(
				'name' => 'Emri i perdoruesit',
				'required' => true
			),
			'password' => array(
				'name' => 'Fjalekalimi',
				'required' => true
			)
		));

		if($validation->passed()) {
			// kycet perdoruesi
			$user = new User();

			$remember = ($_POST['remember'] === 'on') ? true : false;
			$login = $user->login(Input::get('username'), Input::get('password'), $remember);


			if($login) {
				Redirect::to('index.php');
			} else {
				echo '<p>Nuk jeni kycur !</p>';
			}
		} else {
			?>
			<div class="alert alert-danger">
			<?php
			foreach($validation->errors() as $error) {
				echo '<strong>' .$error . '</strong><br>';
			}
			?>
			</div>
			<?php
		}
	}
}
?>

		<h3>Kycu !</h3>
		<form action="" method="post">
			<div class="form-group row">
				<label for="username" class="col-2 col-form-label">Emri i perdoruesit:</label>
				<div class="col-3">
					<input class="form-control" type="text" name="username" id="username" autocomplete="off">
				</div>
			</div>
			<div class="form-group row">
				<label for="password" class="col-2 col-form-label">Fjalekalimi:</label>
				<div class="col-3">
					<input class="form-control" type="password" name="password" id="password" autocomplete="off">
				</div>
			</div>

			<div class="form-check mb-2 mr-sm-2 mb-sm-0">
				<label for="remember" class="form-check-label">
						<input class="form-check-input" type="checkbox" name="remember" id="remember" value="on"> Ruaj sesionin.
				</label>
			</div>

			<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
			<input type="submit" value="Kycu!" class="btn btn-primary">
		</form>
	</div>
	</body>
</html>
