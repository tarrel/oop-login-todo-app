<?php
require_once 'core/init.php';

if(!$username = Input::get('user')) {
  Redirect::to('index.php');
} else {
  $user = new User($username);


  if(!$user->exists()) {
    Redirect::to(404);
  } else {
    $data = $user->data();
  }
  ?>
  <?php include 'includes/template/header.php'; ?>

    <div class="container">

    <h3>Profili i perdoruesit</h3>
    <p>Emri Mbiemri: <u><?php echo escape($data->name); ?></u></p>

    <ul>
  		<li><a href="update.php">Perditeso te dhenat!</a></li>
  		<li><a href="changepassword.php">Ndrysho fjalekalimin!</a></li>
      <?php if($user->hasPermission('admin')): ?>
      <li><a href="users.php">Perdoruesit</a></li>
      <?php endif; ?>
  		<li><a href="logout.php">Dilni nga sesioni!</a></li>
  	</ul>

  </div>
</body>
</html>
  <?php
}
