<?php
	session_start();
	$db = mysqli_connect("localhost:3306", "root", "root", "todo_list");

	$update = false;
	$task = "";
	$errors = "";

	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	// insert a quote if submit button is clicked
	if (isset($_POST['submit'])) {
		if (empty($_POST['task'])) {
			$errors = "Please enter a task to add it to the list.";
		} else {
			$task = test_input($_POST['task']);
			$sql = "INSERT INTO tasks (task) VALUES ('$task')";
			mysqli_query($db, $sql);
			$_SESSION['message'] = "Task added";

			// below is for returning the error when insert fails
			//or die('Query failed: ' . mysqli_error($db));
			header('location: todo-list.php');
		}
	} else if (isset($_POST['update'])) {
		$id = test_input($_POST['id']);
		$task = test_input($_POST['task']);

		mysqli_query($db, "UPDATE tasks SET task='$task' WHERE id=$id");
		$_SESSION['message'] = "Task successfully updated!";
		header('location: todo-list.php');
	}
?>