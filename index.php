<!DOCTYPE html>
<?php
require_once 'core/init.php';

if(Session::exists('home')) {
	echo '<p>'. Session::flash('home') .'</p>';
}

$user = new User();
$todo = new Todo();
$doing = new Doing();
$done = new Done();

if($user->isLoggedIn()) {
	if(Input::exists()) {
		if(Token::check(Input::get('token'))) {

			try {
				$todo->create(array(
					'user_id' => $user->data()->id,
					'title' => Input::get('title'),
					'area' => Input::get('area'),
					'created' => date('Y-m-d H:i:s')
				));

				Redirect::to('index.php');
			} catch(PDOException $e) {
				die($e->getMessage());
			}
		}

	}
?>
<?php include 'includes/template/header.php' ?>

<?php
	if($user->hasPermission('admin')) {
		echo '<div class="alert alert-success" style="margin-top: 20px;">Ju jeni administrator!</div>';
	}
?>

<div class="row">
<div class="todo-list col">
	<h1 class="todo-title">To do.</h1>

	<ul class="todo-items">
		<?php if($todo->exists()): ?>
			<?php 
				$data = $todo->data();
				foreach($data as $title => $titles): 
			?>
				<li>
					<span class="todo-item"><?php echo escape($titles->title); ?></span><br>
					<span class="todo-item"><small><i><?php echo escape($titles->area); ?></i></small></span>
					<a href="doing.php?as=doing&item=<?php  echo escape($titles->id); ?>" class="send-todo">Doing</a>
					<p><small><i><b><?php echo escape($titles->created); ?></b></i></small></p>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

	<form action="" method="post" class="add-item">
		<input type="text" name="title" placeholder="Shkruaj..." autocomplete="off" class="todo-input" required>
		<input type="textbox" name="area" placeholder="Pershkrimi..." autocomplete="off" class="todo-input">

		<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
		<input type="submit" value="Shto" class="btn btn-priamry submit">
	</form>

</div>



<div class="todo-list col">
	<h1 class="todo-title">Doing.</h1>

	<ul class="todo-items">

		<?php if($doing->find()): ?>
			<?php
				$data = $doing->data();
				foreach($data as $doing => $do):
			?>
				<li>
					<span class="todo-item "><?php echo escape($do->title); ?></span><br>
					<span class="todo-item"><small><i><?php echo escape($do->area); ?></i></small></span>
					<a href="doing.php?as=done&item=<?php echo escape($do->id); ?>" class="send-todo">Done</a>
					<p><small><i><b><?php echo escape($do->created); ?></b></i></small></p>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

</div>


<div class="todo-list col">
	<h1 class="todo-title">Done.</h1>

	<ul class="todo-items">
		<?php if($done->find()): ?>
			<?php 
				
				$data = $done->data();
				foreach($data as $newDone => $dones):
			?>
				<li>
					<span class="todo-item "><?php echo escape($dones->title); ?></span><br>
					<span class="todo-item"><small><i><?php echo escape($dones->area); ?></i></small></span>
					<a href="doing.php?as=delete&item=<?php echo escape($dones->id); ?>" class="send-todo">X</a>
					<p><small><i><b><?php echo escape($dones->created); ?></b></i></small></p>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>

</div>
</div>
<?php

} else {
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>WipeOut - Agjenda ne xhepin tuaj ne cdo kohe !</title>
		
		<!-- Stilizimi me bootstrap -->
		<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.min.css">
	</head>
	<body>
		<div class="container">
			<div class="alert alert-success">
			<h3>Ju duhet te <a href="login.php">kyceni</a> ose <a href="register.php">regjistroheni</a> !</h3>
			</div>
		</div>
	</body>
</html>
<?php
}
