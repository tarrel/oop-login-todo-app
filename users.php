<?php
require_once 'core/init.php';

$db = DB::getInstance();
$user = new User();

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
} else {
?>
<?php include 'includes/template/header.php'; ?>
<?php
	if($user->hasPermission('admin')) {
		$results = $db->query("SELECT * FROM users ORDER BY id DESC LIMIT 0,50");
		?>
				<table class="table">
					<thead>
						<tr>
							<th>Emri Mbiemri</th>
							<th>Emri i perdoruesit</th>
							<th>Fshij</th>
						</tr>
					</thead>
					<tbody>
		<?php
		foreach($results->results() as $result) {
			?>
						<tr class="info">
							<td><?php echo escape($result->name); ?></td>
							<td>
								<?php echo escape($result->username); ?>
							</td>
							<td><a href="actionUser.php?as=remove&item=<?php echo escape($result->id); ?>">Fshij</a></td>
						</tr>
			<?php
		}
		?>
					</tbody>
				</table>
		<?php
	}

}