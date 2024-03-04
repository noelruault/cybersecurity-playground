<!doctype html>

<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<title>PHP Shells</title>
</head>

<body>
	<div class="container">
		<?php include("nav.html") ?>

		<div class="row">
			<h1>PHP Uploads</h1>
			<p>In this example we can upload a file.
				There is no input sanitisation here, so you can use
				this to try getting a reverse shell via file upload</p>

			<form action="upload.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="fileToUpload">File:</label>
					<input type="file" name="fileToUpload" id="fileToUpload" class="form-control-file">
				</div>

				<button type="submit" class="btn btn-primary" name="submit">Submit</button>
			</form>
		</div>

		<div class="row">
			<?php
			if (isset($_POST["submit"])) {
				$target_dir = "uploads/";
				$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
				$uploadOk = 1;

				// Check if $uploadOk is set to 0 by an error
				if ($uploadOk == 0) {
					echo "<div class='alert alert-warning'>Sorry, your file was not uploaded.</div>";
					// if everything is ok, try to upload file
				} else {
					if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
						echo "<div class='alert alert-success'>Upload of " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " success!</div>";
					} else {
						echo "<div class='alert alert-critical'>Sorry, there was an error uploading your file.</div>";
					}
				}
			}

			?>

		</div>
	</div>
</body>
