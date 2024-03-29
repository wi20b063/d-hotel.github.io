<?php

require(dirname(__FILE__, 1) . "\components\session.php");
require(dirname(__FILE__, 1) . "\config\dbaccess.php");
require(dirname(__FILE__, 1) . "\components\inputValidation.php");
if (!isset($_SESSION["username"], $_SESSION["role"])) {
	header('location:../index.php');
	exit;
}
query_UserData($_SESSION["username"], $_SESSION["password"]);
enum p_status
{ //Set states of profile
	case PROFILE_SHOW;
	case PROFILE_MODIFY;
}
$profile_status = p_status::PROFILE_SHOW;
$salutationErr = $firstNameErr = $lastNameErr = $emailErr = $usernameErr = $oldPasswordErr = $newPasswordErr = $newPasswordRepeatedErr = "";

// if update profile STEP-1: allow editing of contact OR image OR pwd
if (isset($_POST["edit_profile"]) && (!isset($_SESSION["update_profile"]))) {
	$profile_status = p_status::PROFILE_MODIFY;
	// reset validation errors if still set
	$_SESSION["transactNotice"] = false;
	$_SESSION["transactInfoType"] = "";
	$_SESSION["transactFeedback"] = "";
	// ----------change profile STEP-2: -----------> picture 
} elseif ((isset($_POST["submitImg"]))) {
	$_SESSION["transactNotice"] = true;
	$_SESSION["transactInfoType"] = "";
	$_SESSION["transactFeedback"] = "";
	// creating unique filename for image upload
	$providedFilename = $_FILES["file-input"]["name"];
	$providedFile_extension = strtolower(pathinfo($providedFilename, PATHINFO_EXTENSION));
	$uniqueFileName = uniqid();
	$newTarget_file = $profile_target_dir . $uniqueFileName . "." . $providedFile_extension;
	$uploadOK = check_img($newTarget_file);
	// upload img file and update image in Database
	if ($uploadOK && upload_img($newTarget_file)) {
		if (update_profile()) {
			// Upload and DB update ok. nothing else to do. Feedback and err values set in function and displayed on reload.
		} else {
			//DB update not ok. nothing else to do. Feedback and err values set in function and displayed on reload.
		}
	}
	// ---------- change profile STEP-2 -----------> contact data change
} elseif (isset($_POST["apply_profile"])) {
	$readyForSubmit = true;
	$_SESSION["transactNotice"] = true;
	$readyForSubmit = $readyForSubmit & genericValidation($emailErr, $_POST["email"]);

	if ($readyForSubmit) { // form validation was successful, now trying to update the profile
		if (update_profile()) {
			$_SESSION["transactInfoType"] = "Info";
			// DB update ok. nothing else to do. Feedback and err values set in function and displayed on reload.
		} else {
			//DB update not ok. nothing else to do. Feedback and err values set in function and displayed on reload.
		}
		// read updated values from Database for updated profile view
		query_UserData($_SESSION["username"], ($_SESSION["password"]));
	} else { // form validation was not successful
		if (strlen($emailErr) > 0) {
			$_SESSION["transactInfoType"] = "Error";
			$_SESSION["transactFeedback"] = "email " . $emailErr;
		}
	}
	// ---------- change profile STEP-2: -----------> password
} elseif (isset($_POST["update_password"])) {
	// validate old and new passwords
	$_SESSION["transactNotice"] = true;
	$_SESSION["transactInfoType"] = "Error";

	if (!empty($_POST["current-password"]) && !empty($_POST["new-password"]) && !empty($_POST["new-passwordRepeated"])) {

		if (pwd_equalValidation($_POST["new-password"], $_POST["new-passwordRepeated"], $newPasswordRepeatedErr)) {

			if (pwd_verifyNewPwd($_POST["current-password"], $_POST["new-password"], $newPasswordErr)) {
				// update pwd in DB
				if (update_pwd(md5($_POST["new-password"]), $_SESSION["personID"])) { // send md5(password) hash to update statement
					$_SESSION["transactFeedback"] = "Password geändert";
					$_SESSION["transactInfoType"] = "Info";
				}
			}
		}
	}
	if ($_SESSION["transactInfoType"] == "Error") {
		$_SESSION["transactFeedback"] = $newPasswordErr . $newPasswordRepeatedErr . " Passwortänderung fehlgeschlagen. ";
	}
} else {
	$_SESSION["transactNotice"] = false;
	$_SESSION["transactInfoType"] = "";
	$_SESSION["transactFeedback"] = "";
}

// ----------  generic result notice for all profile update  features
if ($_SESSION["transactNotice"] == true) {
	if ($_SESSION["transactInfoType"] == "Error") {
		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . "+Profil NICHT aktualisiert+";
	} else {
		$_SESSION["transactFeedback"] = " <<Profil aktualisiert!>>";

	}

}


function check_img($newTarget_file)
{ //Todo: uniqueID filename for image upload to Server...
	global $profile_target_dir;
	$_SESSION["transactNotice"] = true; // set false by default. if all ok, set it right again
	$_SESSION["transactInfoType"] = "Error";

	// Validate file input to check if provided file exists
	if (!file_exists($_FILES["file-input"]["tmp_name"])) {

		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . "Invalid image file provided.\n";
		return false;
	}
	// validate if file is within allowed image type file-extension
	$file_extension = strtolower(pathinfo($newTarget_file, PATHINFO_EXTENSION));
	$allowed_image_extension = array(
		"png",
		"jpg",
		"jpeg"
	);
	if (!in_array($file_extension, $allowed_image_extension)) {
		$_SESSION["transactFeedback"] = "Only PNG and JPEG/JPG are allowed. ";
		return false;
	} // Validate image file size, 3Mb in our case
	if (($_FILES["file-input"]["size"] > 3000000)) {
		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . "Image size exceeds 3MB. ";
		return false;
	}
	// Check if file already exists in target directory
	if (is_file($_SERVER['DOCUMENT_ROOT'] . "/" . $profile_target_dir . $newTarget_file)) {
		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . "Filename conflict, please try uploding again. ";
		return false;
	}
	// image is valid:
	$_SESSION["transactNotice"] = false;
	$_SESSION["transactInfoType"] = "";
	return true;
}

function upload_img($newTarget_file)
{ // all tests passed. try to upload image file to the server
	global $profile_target_dir;
	$_SESSION["transactFeedback"] = "";
	if (@move_uploaded_file($_FILES["file-input"]["tmp_name"], $newTarget_file)) {
		$_SESSION["transactNotice"] = true;
		$_SESSION["transactInfoType"] = "Info";
		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . "File upload OK";

		// check if old profile picture exists and delete it
		if (!empty($_SESSION["target_file"])) {
			$delete_target = $profile_target_dir . $_SESSION["target_file"];
			if (is_file($delete_target)) {
				delete_profile_image($delete_target);
			}
		}


		//setting filename in $_Session variable for DB entry. 
		$_SESSION["target_file"] = basename($newTarget_file); //only uniquefilename & fileextension stored in DB
		return true;
	} else {
		$_SESSION["transactNotice"] = true;
		$_SESSION["transactInfoType"] = "Error";
		$_SESSION["transactFeedback"] = $_SESSION["transactFeedback"] . " File upload nicht erfolgreich";
	}
	return false;
}

function update_profile() //used for both, update of profile picture and profile info in DATABASE

{
	global $con;
	global $mysqli_tbl_u_profile;

	if (isset($_POST["submitImg"])) { //only update profile picture
		$target = mysqli_real_escape_string($con, $_SESSION["target_file"]); //probably not needed...
		$SQLupdate = "UPDATE $mysqli_tbl_u_profile SET target_file = ? WHERE personID = ?";
		$stmt = $con->prepare($SQLupdate);
		$stmt->bind_param("si", $target, $_SESSION["personID"]);

	} else if (isset($_POST["apply_profile"])) { //only update profile info
		$email = test_input($_POST["email"]);
		$address = test_input($_POST["address"]);
		$PLZ = test_input($_POST["zipcode"]);
		$address2 = test_input($_POST["address2"]);
		$tel = test_input($_POST["tel"]);
		$city = test_input($_POST["city"]);
		$SQLupdate = "UPDATE  $mysqli_tbl_u_profile 
		SET  email = ?, address= ?, zipcode= ?, address2=? , tel=? , city=? WHERE personID = ?";
		$stmt = $con->prepare($SQLupdate);
		$stmt->bind_param("ssssssi", $email, $address, $address2, $PLZ, $tel, $city, $_SESSION["personID"]);
	}

	$stmt->execute();
	$result = mysqli_stmt_get_result($stmt);
	return $result;
}


function delete_profile_image($oldTargetFile)
{
	if (is_file($oldTargetFile)) { //there might not be a profile picture
		//delete old image file
		if (!unlink($oldTargetFile)) {
			$_SESSION["transactInfoType"] = "Info";
			$_SESSION["transactFeedback"] = " Profile image file deletion failed.";
		}
	}
}

function query_UserData($username, $password)
{
	global $mysqli_tbl_login, $mysqli_tbl_u_profile, $con;
	$SQLquery = "SELECT * FROM ($mysqli_tbl_login t  JOIN $mysqli_tbl_u_profile u ON t.id=u.personID)  WHERE username= ? and t.password= ?";
	$stmt = $con->prepare($SQLquery);
	$stmt->bind_param("ss", $_SESSION["username"], $_SESSION["password"]);
	$stmt->execute();
	$result = mysqli_stmt_get_result($stmt);
	if ($result->num_rows == 1) {
		// if we have 1 row as result, the user login was successful
		// getting data into SESSION variable for later. 
		$row = mysqli_fetch_array($result);
		$_SESSION["role"] = $row["role"];
		$_SESSION["username"] = $row["username"];
		$_SESSION["firstName"] = $row["firstName"];
		$_SESSION["lastName"] = $row["lastName"];
		$_SESSION["email"] = $row["email"];
		$_SESSION["zipcode"] = $row["zipcode"];
		$_SESSION["city"] = $row["city"];
		$_SESSION["address"] = $row["address"];
		$_SESSION["address2"] = $row["address2"];
		$_SESSION["target_file"] = $row["target_file"];
		$_SESSION["password"] = $row["password"];
		$_SESSION["salutation"] = $row["salutation"];
		$_SESSION["tel"] = $row["tel"];
		$_SESSION["personID"] = $row["personID"];
	} else {
		echo "<div class='row col-8'>
            <H2> Username/Password is incorrect.</H2>
            </div>";
	}
}

function test_input($data)
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function update_pwd($newPassword, $idPerson)
{
	global $mysqli_tbl_login, $con;
	$SQLquery = "UPDATE $mysqli_tbl_login SET password = ? WHERE ID = ?";
	$stmt = $con->prepare($SQLquery);
	$stmt->bind_param("ss", $newPassword, $idPerson);
	$stmt->execute();

	if ($stmt->affected_rows == 1) { // we want to make sure that exactly 1 row was affected(updated)
		$_SESSION["password"] = $newPassword;
		return true;
	} else
		return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include "components/head.php"; ?>
	<title>Distant Hotel in Kreta | Ihr Profil beim Hotel direkt am Meer</title>
</head>

<body>
	<nav>
		<?php include "components/navbar.php"; ?>
	</nav>

	<main>


		<div class="content">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- Page title -->
						<div class="my-5">
							<h1 class="headline">Mein Profil</h1>
							<hr>
						</div>
						<!-- Form START -->

						<div class="row mb-5 gx-5">

							<!-- Contact detail -->
							<div class="col-xxl-8 mb-5 mb-xxl-0">
								<div class="bg-secondary-soft px-4 py-5 rounded">
									<form class="data-form" method="post" autocomplete="on"
										action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
										<div class="row g-3">
										<?php if ($profile_status != p_status::PROFILE_MODIFY) {
											echo "<h4 class='mb-4 mt-0'>Kontaktdaten</h4>";
										} else {
											echo "<h4 class='mb-4 mt-0'>Kontaktdaten bearbeiten:</h4>";
										} ?>
											<!-- First Name -->
											<div class="col-md-6">
												<p><strong>Vorname:</strong></p>
												<p>
													<?php echo $_SESSION["firstName"]; ?>

												</p>
											</div>
											<!-- Last name -->
											<div class="col-md-6">
												<p><strong>Nachname:</strong></p>
												<p>
													<?php echo $_SESSION["lastName"]; ?>
												</p>
											</div>
											<!-- Address -->
											<div class="col-md-6">
												<label for="address" class="form-label"><strong>Straße:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["address"];
													} else { ?>
														<input type="text" id="address" name="address" class="form-control"
															autocomplete="address" value=<?php echo $_SESSION["address"]
																?>>
														<span style="color:red; font-size:small">
														<?php } ?>
												</p>
											</div>
											<div class="col-md-6">
												<label for="address2" class="form-label"><strong>Hausnummer/Stiege/Tür:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["address2"];
													} else { ?>
														<input type="text" id="address2" name="address2"
															class="form-control" autocomplete="given-name" value=<?php echo
																$_SESSION["address2"] ?>>
														<span style="color:red; font-size:small">
														<?php } ?>
												</p>
											</div>
											<div class="col-md-6">
												<label for="zipcode" class="form-label"><strong>PLZ:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["zipcode"];
													} else { ?>
														<input type="text" id="zipcode" name="zipcode" class="form-control"
															autocomplete="given-name" value=<?php echo $_SESSION["zipcode"]
																?>>
														<span style="color:red; font-size:small">
														<?php } ?>
												</p>
											</div>
											<div class="col-md-6">
												<label for="city" class="form-label"><strong>Stadt:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["city"];
													} else { ?>
														<input type="text" id="city" name="city" class="form-control"
															autocomplete="given-name" value=<?php echo $_SESSION["city"] ?>>
														<span style="color:red; font-size:small">
														<?php } ?>
												</p>
											</div>
											<!-- Phone number -->
											<div class="col-md-6">
												<label for="tel" class="form-label"><strong>Telefonnummer:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["tel"];
													} else { ?>
														<input type="text" id="tel" name="tel" class="form-control"
															autocomplete="given-name" value=<?php echo $_SESSION["tel"] ?>>
														<span style="color:red; font-size:small">
														<?php } ?>
												</p>
											</div>
											<!-- Email -->
											<div class="col-md-6">
												<label for="email" class="form-label"><strong>E-Mailadresse:</strong></label>
												<p>
													<?php
													if ($profile_status != p_status::PROFILE_MODIFY) {
														echo $_SESSION["email"];
													} else { ?>
														<input type="text" id="email" name="email" class="form-control"
															autocomplete="given-name" value=<?php echo $_SESSION["email"]
																?>>
														<span style="color:red; font-size:small">
															<?php echo $emailErr; ?>
														<?php } ?>
												</p>

											</div>
											<div class="text-center">
												<?php
												if ($profile_status == p_status::PROFILE_MODIFY) { ?>
													<button type="submit" name="apply_profile" class="btn btn-blue">Speichern</button>
													<button type="submit" name="back" class="btn btn-grey">Abbrechen</button>
												<?php } ?>
											</div>

									</form>
								</div> <!-- Row END -->
							</div>
						</div>


						<!-- Profile picture -->
						<div class="col-xxl-4">
							<div class="bg-secondary-soft px-4 py-5 rounded">
								<div class="row g-3">
									<h4 class="mb-4 mt-0">Mein Profilbild</h4>
									<div class="text-center">
										<!-- Image upload -->
										<div class="square position-relative display-2 mb-3">
											<?php
											// Check if the user has a profile picture
											$dB_profileImg = $profile_target_dir . $_SESSION["target_file"];
											if (is_file($dB_profileImg)) {

												echo "<img src= '$dB_profileImg' class=\"img-fluid rounded-circle\" alt=\"Mein Profilbild\" >";
											} else {
												$dummy_profileImg = $profile_target_dir . "dummy-profile-picture.jpg";
												echo "<img src= '$dummy_profileImg' class=\"img-fluid rounded-circle\" alt=\"Mein Profilbild\" >";
												?>
												<p>
													<span style="color:black; font-size:medium"> Du hast noch kein
														Profilbild
														hochgeladen </span>
												</p>
											<?php } ?>
										</div>
										<!-- Upload form -->
										<?php
										if ($profile_status == p_status::PROFILE_MODIFY) {
											echo '<form action="profile.php" method="post" enctype="multipart/form-data">
												<div class="mb-3">
													<input type="file" name="file-input" id="file-input"
														accept="image/*">
												</div>
												<div class="mb-3">
													<input type="submit" value="Bild hochladen" name="submitImg"
														class="btn btn-blue">
												</div>
											</form>';
										} ?>
									</div>
								</div> <!-- Row END -->
							</div>
						</div>
					</div> <!-- Row END -->


					<!-- change password -->
					<span style="color:red; font-size:small">
						<?php

						if (isset($_SESSION["transactNotice"]) && $_SESSION["transactNotice"] == true) {

							echo $_SESSION["transactInfoType"] . ": " . $_SESSION["transactFeedback"];
						}
						?>
					</span>
					<?php


					if ($profile_status == p_status::PROFILE_MODIFY) { ?>
						<div class="col-xxl-6">
							<div class="bg-secondary-soft px-4 py-5 rounded">
								<div class="row g-3">
									<h4 class="my-4">Passwort ändern:</h4>
									<form action="profile.php" method="post" enctype="multipart/form-data">

										<div class="row">										
											<!-- Old password -->
											<div class="col-md-6 mb-4">
												<label for="exampleInputPassword1" class="form-label">Altes Passwort *</label>
												<input type="password" class="form-control" name="current-password" id="exampleInputPassword1">
											</div>
										</div>

										<div class="row">
											<!-- New password -->
											<div class="col-md-6 mb-4">
												<label for="new-password" class="form-label">Neues Passwort *</label>
												<input type="password" class="form-control" id="new-password" name="new-password">
											</div>									

											<!-- Confirm password -->
											<div class="col-md-6 mb-4">
												<label for="new-passwordRepeated" class="form-label">Neues Passwort bestätigen *</label>
												<input type="password" class="form-control" id="new-passwordRepeated" name="new-passwordRepeated">
											</div>

										</div>

										<div class="row">
											<div class="text-center">
												<button type="submit" name="update_password" class="btn btn-blue">Speichern</button>
												<button type="submit" name="back" class="btn btn-grey">Abbrechen</button>
											</div>										
										</div>

									</form>
								</div>
							</div>
						</div>

					<?php }

					?>
				</div> <!-- Row END -->
				
				<!-- button show for main view-->
				<?php
				if ($profile_status == p_status::PROFILE_SHOW) { ?>
					<form action="profile.php" method="post" enctype="multipart/form-data">
						<div class="gap-3 d-md-flex justify-content-md-end text-center">
							<button type="submit" name="edit_profile" class="btn btn-red">Profil bearbeiten</button>
						</div>
					</form>
					<?php
				}

				?>
			</div>
		</div>
		</div>
		</div>



	</main>

	<footer class="footer sticky-bottom">
		<?php include "components/footer.php"; ?>
	</footer>

</body>

</html>