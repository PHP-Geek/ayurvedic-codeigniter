<table border="1" style="border-collapse: collapse;" cellpadding="5" cellspacing="5">
	<tr>
		<th>ID</th>
		<th>Username</th>
		<th>Email</th>
		<th>Password</th>
	</tr>
	<?php foreach ($users as $user) { ?>
		<tr>
			<td><?php echo $user['user_id']; ?></td>
			<td><?php echo $user['user_login']; ?></td>
			<td><?php echo $user['user_email']; ?></td>
			<td><?php echo $user['password']; ?></td>
		</tr>
	<?php }
	?>
</table>