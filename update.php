<?php
require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
  Redirect::to('index.php');
}

if(Input::exists()) {
  if(Token::check(Input::get('token'))) {
    $validate = new Validate();
    $validation = $validate->check($_POST, array(
      'name' => array(
        'name' => 'Emri Mbiemri',
        'required' => true,
        'min' => 2,
        'max' => 50
      ),
    ));

    if($validation->passed()) {
      // perditeso
      try {
        $user->update(array(
          'name' => Input::get('name')
        ));

        Redirect::to('index.php');

      } catch(Exception $e) {
        die($e->getMessage());
      }
    } else {
      foreach($validation->errors() as $error) {
        echo $error, '<br>';
      }
    }
  }
}
?>
<?php include 'includes/template/header.php'; ?>

<h3>Perditeso te dhenat</h3>
<form action="" method="post">
  <div class="form-group row">
    <label for="name" class="col-2 col-form-label">Emri Mbiemri: </label>
    <div class="col-3">
      <input class="form-control" type="text" name="name" value="<?php echo escape($user->data()->name) ?>">
    </div>

    <input type="submit" value="Ndrysho" class="btn btn-primary">
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
  </div>
</form>

</div>
