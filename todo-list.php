<?php include('todo_functions.php'); ?>
<?php
	if (isset($_GET['del_task'])) {
		$id = $_GET['del_task'];

		mysqli_query($db, "DELETE FROM tasks WHERE id=".$id);
		header("location: todo-list.php");
	} 

	if (isset($_GET['edit_task'])) {
		$id = $_GET['edit_task'];
		$update = true;
		$record = mysqli_query($db, "SELECT * FROM tasks WHERE id=".$id);

		if (count($record) == 1) {
			$n = mysqli_fetch_array($record);
			$task = $n['task'];
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Creating a PHP to-do app</title>
	<style>
		html {
			visibility: hidden;
			opacity:0;
		}
	</style>
	<link rel="stylesheet" href="https://use.typekit.net/zwl3lms.css">
	<link rel="stylesheet" href="css/todo.css" type="text/css" />
</head>
<body>
	<?php if (isset($_SESSION['message'])): ?>
		<div class="msg">
			<?php 
				echo $_SESSION['message']; 
				unset($_SESSION['message']);
			?>
		</div>
	<?php endif ?>

	<header>
		<h1>To-do list</h1>
		<p>Need to keep yourself on track? Create and manage a to-do list.</p>
	</header>
	<div class="todo--form">
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" class="todo--form__input">
			<!--added to help identify the entry -->
			<input type="hidden" name="id" value="<?php echo $id ?>">

			<input type="text" name="task" class="input__task" value="<?php echo $task ?>">

			<!-- this button now changes to allow updates-->
			<?php if ($update == true): ?>
				<button type="submit" name="update" id="update_btn" class="add_btn">Update Task</button>
			<?php else: ?>
				<button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
			<?php endif ?>
		</form>
		<?php if (isset($errors)) { ?>
			<p class="form__error"><?php echo $errors; ?></p>
		<?php } ?>
	</div>
	<div class="todo--table">
		<table>
			<thead>
				<tr>
					<th>Number</th>
					<th>Tasks</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody>
				<?php
				//select all tasks if page is visited or refreshed
				$tasks = mysqli_query($db, "SELECT * FROM tasks");

				$i = 1; while ($row = mysqli_fetch_array($tasks)) { ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td class="task"><?php echo $row['task']; ?></td>
						<td class="delete">
							<a href="todo-list.php?edit_task=<?php echo $row['id']; ?>" class="edit_btn">Edit</a>
							<a href="todo-list.php?del_task=<?php echo $row['id'] ?>" class="del_btn">x</a>
						</td>
					</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</body>
</html>