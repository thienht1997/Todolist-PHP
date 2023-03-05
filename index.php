<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="css/index.css" />
	<link href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css' rel='stylesheet' />
	<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1" />
</head>
<?php
session_start();

if (isset($_SESSION['errors'])) {
	$errors = $_SESSION['errors'];
	$task = $_SESSION['task'];
	$start_date = $_SESSION['start_date'];
	$end_date = $_SESSION['end_date'];
	$status = $_SESSION['status'];
	$taskId = $_SESSION['errors']['task_id'];
	unset($_SESSION['errors']);
}

if (isset($_SESSION['success'])) {
	$success = $_SESSION['success'];
	unset($_SESSION['success']);
}

?>

<body>
	<div class="col-md-3"></div>
	<div class="col-md-6 well">
		<div class="header">
			<h3 class="text-primary text-center font-weight-bold">To Do List</h3>
		</div>
		<hr style="border-top:1px dotted #ccc;" />
		<div id='calendar'></div>
		<hr style="border-top:1px dotted #ccc;" />
		<?php if (isset($success)) : ?>
			<div class="alert alert-success message">
				<p><?php echo $success ?></p>
			</div>
		<?php endif ?>
		<table class="table" style="z-index: 999">
			<thead>
				<tr>
					<th>#</th>
					<th>Task</th>
					<th width="120">Starting Date</th>
					<th width="100">Ending Date</th>
					<th width="80">Status</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				require 'conn.php';
				$query = $conn->query("SELECT * FROM `task` ORDER BY `id` ASC");
				$count = 1;
				while ($fetch = $query->fetch_array()) {
				?>
					<tr class="<?php if ($fetch['status'] === "Complete") : ?> bg-success<?php endif; ?>">
						<td><?php echo $count++ ?></td>
						<td><?php echo $fetch['task'] ?></td>
						<td><?php echo date('d/m/Y', strtotime($fetch['start_date'])) ?></td>
						<td><?php echo date('d/m/Y', strtotime($fetch['end_date'])) ?></td>
						<td><?php echo $fetch['status'] ?></td>
						<td colspan="2">
							<a href="delete_query.php?task_id=<?php echo $fetch['id'] ?>" class="btn btn-danger custom-btn"><span class="glyphicon glyphicon-remove"></span></a>
							<?php if ($fetch['status'] != "Complete") : ?>
								<button type="button" class="btn btn-success custom-btn" data-toggle="modal" data-target="#updateModal<?php echo $fetch['id'] ?>"><span class="glyphicon glyphicon-check"></span></button>
							<?php endif; ?>
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<hr style="border-top:1px dotted #ccc;" />
		<div class="create-container">
			<div class="col-md-2"></div>
			<div class="col-md-12">
				<div id="addTaskForm">
					<form method="POST" class="form-inline" action="add_query.php">
						<div class="form-group">
							<label for="task">Task:  <span class="text-red"> *</span></label>
							<input type="text" class="form-control" id="task" name="task" value="<?php echo isset($task) ? $task : ''; ?>">
						</div>
						<div class="form-group">
							<label for="start_date">Start Date:  <span class="text-red"> *</span></label>
							<input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($start_date) ? $start_date : ''; ?>">
						</div>
						<div class="form-group">
							<label for="end_date">End Date:  <span class="text-red"> *</span></label>
							<input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo isset($end_date) ? $end_date : ''; ?>">
						</div>
						<div>
							<button type="submit" class="btn btn-primary" name="add">Create  +</button>
						</div>
					</form>
					<div style="margin-top:10px; height: 100px">
						<?php if (isset($errors)) : ?>
							<div class="message">
								<?php foreach ($errors as $type => $error) : ?>
									<?php if ($type != 'task_id') : ?>
										<p style="color: red"><?php echo $error ?></p>
									<?php endif ?>
								<?php endforeach ?>
							</div>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	$query = $conn->query("SELECT * FROM `task` ORDER BY `id` ASC");
	while ($fetch = $query->fetch_array()) {
	?>
		<!-- Update Modal -->
		<div class="modal fade" id="updateModal<?php echo $fetch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel<?php echo $fetch['id']; ?>">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="updateModalLabel<?php echo $fetch['id']; ?>">Update Task</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="update_task.php" method="POST">
							<input type="hidden" name="task_id" value="<?php echo $fetch['id'] ?>">
							<div class="form-group">
								<label for="taskName">Task Name  <span class="text-red"> *</span></label>
								<input type="text" class="form-control" id="taskName" name="task" value="<?php echo isset($task) ? $task : $fetch['task'] ?>">
							</div>
							<div class="form-group">
								<label for="startDate">Start Date  <span class="text-red"> *</span></label>
								<input type="date" class="form-control" id="startDate" name="start_date" value="<?php echo date('Y-m-d', strtotime(isset($start_date) ? $start_date : $fetch['start_date'])); ?>">
							</div>
							<div class="form-group">
								<label for="endDate">End Date  <span class="text-red"> *</span></label>
								<input type="date" class="form-control" id="endDate" name="end_date" value="<?php echo date('Y-m-d', strtotime(isset($end_date) ? $end_date : $fetch['end_date'])) ?>">
							</div>
							<div class="form-group">
								<label for="status">Status  <span class="text-red"> *</span></label>
								<select name="status" class="form-control" id="status">
									<option value="Planning" <?php if ($status ? ($status  === "Planning") : ($fetch['status'] === "Planning")) echo "selected"; ?>>Planning</option>
									<option value="Doing" <?php if ($status ? ($status  === "Doing") : $fetch['status'] === "Doing") echo "selected"; ?>>Doing</option>
									<option value="Complete" <?php if ($status ? ($status  === "Complete") : $fetch['status'] === "Complete") echo "selected"; ?>>Complete</option>
								</select>
							</div>
							<?php if (isset($errors)) : ?>
								<div class="alert message">
									<?php foreach ($errors as $type => $error) : ?>
										<?php if ($type != 'task_id') : ?>
											<p style="color: red"><?php echo $error ?></p>
										<?php endif ?>
									<?php endforeach ?>
								</div>
							<?php endif ?>
							<div class="justify-center text-center align-center">
								<button type="submit" name="update" class="btn btn-primary text-center d- mx-auto">Update</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<input type="hidden" id="task_id" value="<?php echo $taskId; ?>">
		<input type="hidden" id="errors" value="<?php echo $errors; ?>">
	<?php
	}
	?>
	<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js'></script>
	<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js'></script>
	<script>
		const messages = document.querySelectorAll('.message');

		messages.forEach(message => {
			setTimeout(() => {
				message.classList.add('hide');
				setTimeout(() => message.remove(), 1000);
			}, 3000);
		});
	</script>'
	<script>
		const taskId = $('#task_id').val();
		const errors = $('#errors').val();
		
		if (taskId !== '') {
			$('#updateModal' + taskId).modal('show');
		};

		$('#updateModal' + taskId).on('hidden.bs.modal', function () {
			$.ajax({
				url: 'unset_session.php',
				type: 'POST',
				data: {unset: true},
				success: function(response) {
					window.location.reload();
				},
				error: function(xhr, status, error) {
					console.log(error);
				}
			});
		});

		$(document).ready(function() {
			$('#calendar').fullCalendar({
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				customButtons: {
					myButton: {
						text: 'My Button',
						click: function() {
							console.log('Button clicked!');
						}
					}
				}
			});

		});

		if (errors && !taskId) {
			const $element = $('.create-container');
			const offset = $element.offset().top + 200;

			$('html, body').animate({
			scrollTop: offset
			}, 1000);
		};


		$('#calendar').fullCalendar({
			defaultView: 'month',
			events: [
				<?php
				require 'conn.php';
				$query = $conn->query("SELECT * FROM `task` WHERE `status` != 'Complete' ORDER BY `id` ASC");
				while ($fetch = $query->fetch_array()) {
					$start_date = date('Y-m-d', strtotime($fetch['start_date']));
					$end_date = date('Y-m-d', strtotime($fetch['end_date']));
				?> {
						title: '<?php echo $fetch['task'] ?>',
						start: '<?php echo $start_date ?>',
						end: '<?php echo $end_date ?>',
						color: '<?php echo ($fetch['status'] == "Complete") ? "#378006" : "#337ab7" ?>'
					},
				<?php
				}
				?>
			]
		});
	</script>
</body>

</html>