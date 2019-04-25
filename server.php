<?php
session_start();

// initializing variables
$fname = "";
$lname    = "";
$gender="";
$hed="";
$year="";
$speciality="";
$job="";
$place="";
$std_ID="";
$email="";
$phone_no="";

$errors = array(); 

// connect to the database
$db = mysqli_connect('localhost', 'imc_nmc', 'imc.nmc2018', 'conference_Register');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $fname = mysqli_real_escape_string($db, $_POST['fname']);
  $lname = mysqli_real_escape_string($db, $_POST['lname']);
  $gender = mysqli_real_escape_string($db, $_POST['gn']);
  $hed = mysqli_real_escape_string($db, $_POST['HED']);
  $year = mysqli_real_escape_string($db, $_POST['year']);
  $speciality = mysqli_real_escape_string($db, $_POST['speciality']);
  $job = mysqli_real_escape_string($db, $_POST['job']);
  $place = mysqli_real_escape_string($db, $_POST['place']);
  $std_ID = mysqli_real_escape_string($db, $_POST['std_ID']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($fname)) { array_push($errors, "frist name is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($lname)) { array_push($errors, "last Name is required"); }


  // first check the database to make sure 
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM registers WHERE email='$email' OR mobile_no='$phone_no' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['mobile_no'] === $phone_no) {
      array_push($errors, "phone no already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$query = "INSERT INTO registers (fName, lName, gender, edu_degree, year, specialty, job, place, std_ID, email, mobile_no ) ".
  			 " VALUES('$fname', '$lname', '$gender', '$hed', '$year', '$speciality', '$job', '$place', '$std_ID', '$email', '$phone_no')";
  	mysqli_query($db, $query);
  	$_SESSION['email'] = $email;
  	$_SESSION['success'] =  "Thanks for your registration, we will call you soon!";
  	header('location: thanks.html');
  }
}

// ... ?>
<?php  if (count($errors) > 0) : ?>
  <div class="error">
  	<?php foreach ($errors as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>