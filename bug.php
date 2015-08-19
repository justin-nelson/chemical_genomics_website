<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8">
		<?php require("html/title.html");?>

		<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
		<script>
				function submitBug(){
					submitter = $('#submitter').val();
					description = $('#description').val();
					priority = $('#priority').val();

					$.ajax({
						url : 'php/AJAX_addBug.php',
						type : 'post',
						data : {
							submitter: submitter,
							description: description,
							priority: priority
						},
						success : function(answer){
							window.location.href=window.location.href;
						}
					});
				}
		</script>
	</head>
	<body>
		<button type="button" onclick="window.location.href='index.html'">Back to Home</button>
		<div id="bugSubmit">
			<b>Submitter: </b><input type="text" id="submitter" name="submitter"/> <b>Priority: </b><input type="text" id="priority" name="priority" size=40/>

			<br />
			<textarea id="description" rows="15" cols="200">Describe your feature or bug here!</textarea><br />
			<button type="button" onclick="submitBug()">Submit Bug or Feature!</button><br /><br />
		</div>
		<div id="bugList">
			<table id="bugTable" border="1">
				<tr>
					<th>ID</th>
					<th>Submitter</th>
					<th colspan=80>Description</th>
					<th>Status</th>
					<th>Priority</th>
					<th colspan=80>Justin's Notes</th>
				</tr>
				<?php
					$bugtrackFile = 'bugtracker/bugs.txt';
					#write the new bug into the file
					
					if(file_exists($bugtrackFile)){
						$bugFileHandle = fopen($bugtrackFile, 'r');
						while (($buffer = fgets($bugFileHandle, 4096)) !== false) {
							list ($id, $submitter, $description, $status, $priority, $notes) = explode("|", $buffer);
							echo "
								<tr>
									<td>".$id."</td>
									<td>".$submitter."</td>
									<td colspan=80>".$description."</td>
									<td>".$status."</td>
									<td>".$priority."</td>
									<td colspan=80>".$notes."</td>
								</tr>
							";
						}
						fclose($bugFileHandle);
					}
				?>
			</table> 
		</div>
	</body>
</html>
