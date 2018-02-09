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
					<a href="login.php">Kycu</a>
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
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users' // unik ne tabelen e users ne databaze !
			),
			'password' => array(
				'name' => 'Fjalekalimi',
				'required' => true,
				'min' => 6
			),
			'password_again' => array(
				'name' => 'Perserit fjalekalimin',
				'required' => true,
				'matches' => 'password'
			),
			'name' => array(
				'name' => 'Emri',
				'required' => true,
				'min' => 2,
				'max' => 50
			)
		));

		if($validation->passed()) {
			//regjistro userin
			$user = new User();

			$salt = Hash::salt(32);

			try {
				$user->create(array(
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password'), $salt),
					'salt' => $salt,
					'name' => Input::get('name'),
					'joined' => date('Y-m-d H:i:s'),
					'group' => 1
				));

				Session::put('home', '<div class="container alert alert-success"><strong>Regjistrimi u krye me sukses !</strong></div>');
				Redirect::to('index.php');
			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {
			// shfaq error
			?>
			<div class="container alert alert-danger">
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
<h3>Regjistrohu !</h3><br>
<form action="" method="post">
	<div class="form-group row">
		<label for="username" class="col-2 col-form-label">Emri i perdoruesit:</label>
		<div class="col-3">
			<input class="form-control" type="text" name="username" id="username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off">
		</div>
	</div>

	<div class="form-group row">
		<label for="password" class="col-2 col-form-label">
			Fjalekalimi:
		</label>
		<div class="col-3">
			<input class="form-control" type="password" name="password" id="password">
		</div>
	</div>

	<div class="form-group row">
		<label for="password_again" class="col-2 col-form-label">
			Perserit fjalekalimin:
		</label>
		<div class="col-3">
			<input class="form-control" type="password" name="password_again" id="password_again">
		</div>
	</div>

	<div class="form-group row">
		<label for="name" class="col-2 col-form-label">
			Vendos emrin:
		</label>
		<div class="col-3">
			<input class="form-control" type="text" name="name" value="<?php echo escape(Input::get('name')); ?>" id="name" >
		</div>
	</div>

	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Regjistrohu!" class="btn btn-primary">
</form>
</div>
</body>
</html>
