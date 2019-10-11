<?php
include("config.php");
if(isset($_POST['submit'])) {
	$check = getimagesize($_FILES["image"]["tmp_name"]);

	if($check !== false){
		$roll_no = $_POST['rollno'];
		$name = rand() . $roll_no;
		$img_ftype=str_replace("image/", "", $_FILES['image']['type']);
		$target_img_file = $target_img_dir . $name . "." . $img_ftype;
		$target_doc_file = $target_doc_dir . $name . ".pdf";

		$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
		if($db->connect_error){
			die("Connection failed: " . $db->connect_error);
		}

		$dataTime = date("Y-m-d H:i:s");

		$insert = $db->query("INSERT into client_data (rollno, image, document, created) VALUES (" . $roll_no . ", '" . $name . "." . $img_ftype . "', '" . $name . ".pdf', '" . $dataTime . "')");
		move_uploaded_file($_FILES['image']['tmp_name'], $target_img_file);
		move_uploaded_file($_FILES['document']['tmp_name'], $target_doc_file);

		if($insert){
			echo '<div class="alert alert-success"><strong>Success!</strong> Your response has been recorded. </div>';
		}else{
			echo '<div class="alert alert-danger"><strong>Something went wrong!</strong> Your response cannot be recorded. </div>';
		}
	}
	else{
		echo '<div class="alert alert-Warning"><strong>Warning!</strong> Please select an image file to upload. </div>';
		echo "Please select an image file to upload.";
	}
}

echo '<html>';

echo '<head>';
echo '<!-- Latest compiled and minified CSS -->';
echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">';
echo '';
echo '<!-- jQuery library -->';
echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>';
echo '';
echo '<!-- Popper JS -->';
echo '<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>';
echo '';
echo '<!-- Latest compiled JavaScript -->';
echo '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>	';
echo '</head>';

echo '<body>';

echo '<div class="container">';
echo '<h2 align="center">Enter your data</h2>';
echo '<form action="" method="post" enctype="multipart/form-data">';

echo '<div class="form-group">';
echo '<label for="rollno">Roll No.:</label>';
echo '<input type="number" name="rollno" id="rollno" class="form-control" placeholder="1715083" required>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="image">Image:</label>';
echo '<input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg" required>';
echo '</div>';

echo '<div class="form-group">';
echo '<label for="document">Document:</label>';
echo '<input type="file" name="document" id="document" class="form-control" accept="application/pdf" required><br><br>';
echo '</div>';

echo '<input type="submit" name="submit" value="Submit" class="btn btn-primary">';

echo '</form>';

echo '</div>';
echo '</body>';
echo '</html>';

?>