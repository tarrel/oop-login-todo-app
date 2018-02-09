<?php
  require_once 'core/init.php';

  $user = new User();

  if(!$user->isLoggedIn()) {
    Redirect::to('index.php');
  }
?>
<?php include 'includes/template/header.php'; ?>
<?php

  if(Input::exists()) {
    if(Token::check(Input::get('token'))) {

      $validate = new Validate();
      $validation = $validate->check($_POST, array(
        'password' => array(
          'name' => 'Fjalekalimi',
          'required' => true,
          'min' => 6
        ),
        'password_new' => array(
          'name' => 'Fjalekalimi i ri',
          'required' => true,
          'min' => 6
        ),
        'password_new_again' => array(
          'name' => 'Perserit fjalekalimin e ri',
          'required' => true,
          'min' => 6,
          'matches' => 'password_new'
        )
      ));

      if($validation->passed()) {
        //ndrysho fjalekalimin
        if(Hash::make(Input::get('password'), $user->data()->salt) !== $user->data()->password) {
          echo '<div class="alert alert-danger">Fjalekalimi aktual nuk perputhet !</div>';
        } else {
          $salt = Hash::salt(32);
          $user->update(array(
            'password' => Hash::make(Input::get('password_new'), $salt),
            'salt' => $salt
          ));

          Redirect::to('index.php');
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

<h3>Ndrysho Fjalekalimin</h3>
<form action="" method="post">
  <div class="form-group row">
    <label for="password" class="col-2 col-form-label">Fjalekalimi aktual:</label>
    <div class="col-3">
      <input class="form-control" type="password" name="password" id="password">
    </div>
  </div>

  <div class="form-group row">
    <label for="password_new" class="col-2 col-form-label">Fjalekalimi i ri: </label>
    <div class="col-3">
      <input class="form-control" type="password" name="password_new" id="password_new">
    </div>
  </div>

  <div class="form-group row">
    <label for="password_new_again" class="col-2 col-form-label">Perserit Fjalekalimin: </label>
    <div class="col-3">
      <input class="form-control" type="password" name="password_new_again" id="password_new_again">
    </div>
  </div>

  <input type="submit" value="Ndrysho" class="btn btn-primary">
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
</form>

</div>
