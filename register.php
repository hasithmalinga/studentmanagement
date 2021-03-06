<?php 

	include('config/db_connection.php');

	//variable declaration
	$first_name = $last_name = $dob = $enrollment_date = $email = $home_phone = $mobile = '';
	$contact_name_1 = $contact_phone_1 = $contact_name_2 = $contact_phone_2 = $image = '';
	$year = 0;

	$id = 0;
	
	//errors list
	$errors = array('first_name' => '', 'last_name' => '', 'email' => '',  'dob' => '', 'enrollment_date' => '', 'year' => '',
				 'contact_name_1' => '', 'contact_name_2' => '', 'contact_phone_1' => '', 'contact_phone_2' => '',
				 'home_phone' => '', 'mobile' => '', 'image' => '');
	
	if (isset($_GET['id'])) {
		
		$id = mysqli_real_escape_string($conn, $_GET['id']);
		//build query
		$sql = "SELECT * FROM students WHERE id = $id";
		//get query result
		$result = mysqli_query($conn, $sql);
		//fetch result in an array
		$student = mysqli_fetch_assoc($result);

		mysqli_free_result($result);
		mysqli_close($conn); 

		$first_name = htmlspecialchars($student['first_name']);
		$last_name = htmlspecialchars($student['last_name']);
		$enrollment_date = htmlspecialchars($student['enrollment_date']);
		$dob = htmlspecialchars($student['dob']);
		$year = htmlspecialchars($student['year']);
		$home_phone = htmlspecialchars($student['home_phone']);
		$mobile = htmlspecialchars($student['mobile']);
		$email = htmlspecialchars($student['email']);
		$contact_phone_1 = htmlspecialchars($student['contact_phone_1']);
		$contact_name_1 = htmlspecialchars($student['contact_name_1']);
		$contact_name_2 = htmlspecialchars($student['contact_name_2']);
		$contact_phone_2 = htmlspecialchars($student['contact_phone_2']);
		$image = 'images/' . htmlspecialchars($student['image']);

	}

	if (isset($_POST['submit'])) {
		
		//check First Name
		if (empty($_POST['first_name'])) {
			$errors['first_name'] = 'Fist Name is required';
		}else{
			$first_name = $_POST['first_name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $first_name)){
				$errors['first_name'] = 'First Name must be letters and spaces only';
			}
		}

		//check Last Name
		if (empty($_POST['last_name'])) {
			$errors['last_name'] = 'Last Name is required';
		}else{
			$last_name = $_POST['last_name'];
			if(!preg_match('/^[a-zA-Z\s]+$/', $last_name)){
				$errors['last_name'] = 'Last Name must be letters and spaces only';
			}
		}

		//check Email
		if (empty($_POST['email'])) {
			$errors['email'] = 'Email is required';
		}else{
			$email = $_POST['email'];
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$errors['email'] = 'Email must be valid';
			}
		}

		//check DOB
		if (empty($_POST['dob'])) {
			$errors['dob'] = 'Date of Birth is required';
		}else{
			$dob = $_POST['dob'];			
		}

		//check Year
		if (empty($_POST['year'])) {
			$errors['year'] = 'Class Year is required';
		}else{
			$year = $_POST['year'];			
		}

		//check Enrollment Date
		if (empty($_POST['enrollment_date'])) {
			$errors['enrollment_date'] = 'Enrollment Date is required';
		}else{
			$enrollment_date = $_POST['enrollment_date'];			
		}

		//check Home Phone
		if (empty($_POST['home_phone'])) {
			$errors['home_phone'] = 'Home Phone is required';
		}else{
			$home_phone = $_POST['home_phone'];			
		}

		//check Mobile
		if (empty($_POST['mobile'])) {
			$errors['mobile'] = 'Mobile is required';
		}else{
			$mobile = $_POST['mobile'];			
		}

		//check First Contact Name
		if (empty($_POST['contact_name_1'])) {
			$errors['contact_name_1'] = 'First Contact Name is required';
		}else{
			$contact_name_1 = $_POST['contact_name_1'];			
		}

		//check First Contact Phone
		if (empty($_POST['contact_phone_1'])) {
			$errors['contact_phone_1'] = 'First Contact Phone is required';
		}else{
			$contact_phone_1 = $_POST['contact_phone_1'];			
		}

		//check Second Contact Name
		if (empty($_POST['contact_name_2'])) {
			$errors['contact_name_2'] = 'Second Contact Name is required';
		}else{
			$contact_name_2 = $_POST['contact_name_2'];			
		}

		//check Second Contact Phone
		if (empty($_POST['contact_phone_2'])) {
			$errors['contact_phone_2'] = 'Second Contact Phone is required';
		}else{
			$contact_phone_2 = $_POST['contact_phone_2'];			
		}

		//check correct image file types
		if (!empty($_FILES["image"]["name"])) {
			// File upload path
			$fileName = basename($_FILES["image"]["name"]);
			$fileType = pathinfo($fileName, PATHINFO_EXTENSION);
			//allowed file types
			$allowTypes = array('jpg','png','jpeg','gif');

			if(!in_array($fileType, $allowTypes)){
		        $errors['image'] = 'Only JPG, JPEG, PNG & GIF files are allowed';
		    }  
		}

		if (!array_filter($errors)) {

			$id = mysqli_real_escape_string($conn, $_POST['student_id']);
			$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
			$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
			$enrollment_date = mysqli_real_escape_string($conn, $_POST['enrollment_date']);
			$dob = mysqli_real_escape_string($conn, $_POST['dob']);
			$year = mysqli_real_escape_string($conn, $_POST['year']);
			$home_phone = mysqli_real_escape_string($conn, $_POST['home_phone']);
			$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
			$email = mysqli_real_escape_string($conn, $_POST['email']);
			$contact_phone_1 = mysqli_real_escape_string($conn, $_POST['contact_phone_1']);
			$contact_name_1 = mysqli_real_escape_string($conn, $_POST['contact_name_1']);
			$contact_name_2 = mysqli_real_escape_string($conn, $_POST['contact_name_2']);
			$contact_phone_2 = mysqli_real_escape_string($conn, $_POST['contact_phone_2']);			

			if (!empty($_FILES["image"]["name"])) {
				// File upload path				
				$fileName = basename($_FILES["image"]["name"]);
				$image = mysqli_real_escape_string($conn, $fileName);
			}

			$sql = '';

			if ($id > 0) {
				//update sql query
				$sql = "UPDATE students SET first_name = '$first_name' ,last_name = '$last_name',dob = '$dob',enrollment_date = '$enrollment_date'," .
					"year = '$year',home_phone = '$home_phone',mobile = '$mobile',email = '$email',contact_name_1 = '$contact_name_1'," .
					"contact_phone_1 = '$contact_phone_1',contact_name_2 = '$contact_name_2',contact_phone_2 = '$contact_phone_2',image = '$image' " .
					"WHERE id = '$id'";
			} else{
				//insert sql query
				$sql = "INSERT INTO students(first_name,last_name,dob,enrollment_date,year,home_phone,mobile,email," .
					"contact_name_1,contact_phone_1,contact_name_2,contact_phone_2,image) VALUES('$first_name', '$last_name', '$dob', '$enrollment_date'," . 
					" '$year', '$home_phone', '$mobile', '$email', '$contact_name_1', '$contact_phone_1', '$contact_name_2', '$contact_phone_2', '$image')";
			}
			
			//save to database
			if(mysqli_query($conn, $sql)){
				if (!empty($_FILES["image"]["name"])) {
					//move uploaded file
					move_uploaded_file($_FILES["image"]["tmp_name"], 'images/' . $_FILES["image"]["name"]);
				}
				//redirect to index
				header('Location: index.php');
			}else{
				echo 'Error saving data: ' . mysqli_error($conn);
			}			
		}
	}

 ?>

<!DOCTYPE html>
<html>

	<?php include('templates/header.php'); ?>

	<section class="container grey-text register-form-container">
		<h4 class="center header-text">Register New Student</h4>		
			<div class="row">
			    <form class="white col-s12 regiter-form" action="register.php" method="POST" enctype="multipart/form-data">
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="first_name" name="first_name" type="text" value="<?php echo htmlspecialchars($first_name); ?>" class="validate">
			          <label for="first_name">First Name</label>
			          <div class="red-text"><?php echo $errors['first_name']; ?></div>
			        </div>
			        <div class="input-field col s6">
			          <input id="last_name" name="last_name" type="text" value="<?php echo htmlspecialchars($last_name); ?>" class="validate">
			          <label for="last_name">Last Name</label>
			          <div class="red-text"><?php echo $errors['last_name']; ?></div>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s4">
			          <input id="dob" name="dob" type="date" value="<?php echo htmlspecialchars($dob); ?>" class="validate">
			          <label for="dob">Date of Birth</label>
			          <div class="red-text"><?php echo $errors['dob']; ?></div>
			        </div>
			        <div class="input-field col s4">
			          <input id="enrollment_date" name="enrollment_date" value="<?php echo htmlspecialchars($enrollment_date); ?>" type="date" class="validate">
			          <label for="enrollment_date">Date of Enrollment</label>
			          <div class="red-text"><?php echo $errors['enrollment_date']; ?></div>
			        </div>
			        <div class="input-field col s4">
			          <input id="year" name="year" type="number" value="<?php echo htmlspecialchars($year); ?>" class="validate">
			          <label for="year">Current School Year</label>
			          <div class="red-text"><?php echo $errors['year']; ?></div>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="home_phone" name="home_phone" type="text" value="<?php echo htmlspecialchars($home_phone); ?>" class="validate">
			          <label for="home_phone">Home Phone</label>
			          <div class="red-text"><?php echo $errors['home_phone']; ?></div>
			        </div>
			        <div class="input-field col s6">
			          <input id="mobile" name="mobile" type="text" value="<?php echo htmlspecialchars($mobile); ?>" class="validate">
			          <label for="mobile">Mobile</label>
			          <div class="red-text"><?php echo $errors['mobile']; ?></div>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s12">
			          <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($email); ?>" class="validate">
			          <label for="email">Email</label>
			          <div class="red-text"><?php echo $errors['email']; ?></div>
			        </div>			        
			      </div>
			      <div class="row">			        
			        <div class="input-field col s12">
			          <input type="file" name="image">			          
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="contact_name_1" name="contact_name_1" type="text" value="<?php echo htmlspecialchars($contact_name_1); ?>" class="validate">
			          <label for="contact_name_1">First Contact Name</label>
			          <div class="red-text"><?php echo $errors['contact_name_1']; ?></div>
			        </div>
			        <div class="input-field col s6">
			          <input id="contact_phone_1" name="contact_phone_1" type="text" value="<?php echo htmlspecialchars($contact_phone_1); ?>" class="validate">
			          <label for="contact_phone_1">First Contact Phone</label>
			          <div class="red-text"><?php echo $errors['contact_phone_1']; ?></div>
			        </div>
			      </div>
			      <div class="row">
			        <div class="input-field col s6">
			          <input id="contact_name_2" name="contact_name_2" type="text" value="<?php echo htmlspecialchars($contact_name_2); ?>" class="validate">
			          <label for="contact_name_2">Second Contact Name</label>
			          <div class="red-text"><?php echo $errors['contact_name_2']; ?></div>
			        </div>
			        <div class="input-field col s6">
			          <input id="contact_phone_2" name="contact_phone_2" type="text" value="<?php echo htmlspecialchars($contact_phone_2); ?>" class="validate">
			          <label for="contact_phone_2">Second Contact Phone</label>
			          <div class="red-text"><?php echo $errors['contact_phone_2']; ?></div>
			        </div>
			      </div>
			      <div class="row">
			      	<div class="input-field col s12">
			      	  <input type="hidden" name="student_id" value="<?php echo $id; ?>">
			          <input name="submit" type="submit" value="submit" class="btn">
			        </div>
			      </div>
			    </form>
  			</div>
	</section>

	<?php include('templates/footer.php'); ?>

</html>