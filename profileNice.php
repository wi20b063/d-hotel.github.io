<?php include "components/session.php";

if (isset($_POST["submit"])) {
	//specifies the path to the session file
	$target_dir ="res/img/img profile";
	//specifies the path to the session file
	$target_file = $target_dir . basename($_FILES["profilePicture"]["name"]);
	//is not used yet (will be used later)
	$uploadOk = 1;
	//holds the file extension of the file
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	// Check if image file is a actual image or fake image
	if(isset($_POST["submit"])) {
		$check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
		if($check !== false) {
			echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}

	// Check if file already exists
	if (file_exists($target_file)) {
		echo "Sorry, file already exists.";
		$uploadOk = 0;
	}

	// Check if the file size is below the maximum limit
	if ($_FILES["profilePicture"]["size"] > 5000000) { ?>
		<p class="red">Sorry, your file is too large, max. 50 MB allowed!</p>
		<?php $uploadOk = 0;
	}

	// If everything is OK, upload the file
	if ($uploadOk == 1) {
		if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
			?>
			<p class="green">The file <?php echo htmlspecialchars( basename( $_FILES["profilePicture"]["name"])); ?> has been uploaded.</p>
		<?php } else { ?>
			header('Refresh: 0; URL = ../profile.php');
			<p class="red">Sorry, there was an error uploading your file.</p>
		<?php }
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include "components/head.php";?>
    <title>Distant Hotel | Profile</title>
</head>

<body>
    <nav>
        <?php include "components/navbar.php";?>
    </nav>

    <main>

        <div class="content">
            <div class="container">
            <div class="row">
		<div class="col-12">
			<!-- Page title -->
			<div class="my-5">
				<h1 class="headline">My Profile</h1>
				<hr>
			</div>
			<!-- Form START -->
			<form class="file-upload" action="upload.php" method="post" enctype="multipart/form-data">
				<div class="row mb-5 gx-5">

					<!-- Contact detail -->
					<div class="col-xxl-8 mb-5 mb-xxl-0">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row g-3">
								<h4 class="mb-4 mt-0">Contact detail</h4>
								<!-- First Name -->
								<div class="col-md-6">
                                    <!-- <p><strong>Vorname:</strong></p>
                                    <p>Abcdefg</p> -->
                                    <!-- <?php echo $firstName;?> -->
									<label class="form-label">First Name *</label>
									<input type="text" class="form-control" placeholder="" aria-label="First name" value="Scaralet">
								</div>
								<!-- Last name -->
								<div class="col-md-6">
									<label class="form-label">Last Name *</label>
									<input type="text" class="form-control" placeholder="" aria-label="Last name" value="Doe">
								</div>
								<!-- Phone number -->
								<div class="col-md-6">
									<label class="form-label">Phone number *</label>
									<input type="text" class="form-control" placeholder="" aria-label="Phone number" value="(333) 000 555">
								</div>
								<!-- Mobile number -->
								<div class="col-md-6">
									<label class="form-label">Mobile number *</label>
									<input type="text" class="form-control" placeholder="" aria-label="Phone number" value="+91 9852 8855 252">
								</div>
								<!-- Email -->
								<div class="col-md-6">
									<label for="inputEmail4" class="form-label">Email *</label>
									<input type="email" class="form-control" id="inputEmail4" value="example@homerealty.com">
								</div>
								<!-- Skype -->
								<div class="col-md-6">
									<label class="form-label">Skype *</label>
									<input type="text" class="form-control" placeholder="" aria-label="Phone number" value="Scaralet D">
								</div>
							</div> <!-- Row END -->
						</div>
					</div>


					<!-- Profile picture -->
					<div class="col-xxl-4">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row g-3">
								<h4 class="mb-4 mt-0">Profile picture</h4>
								<!-- Profile picture upload -->
								<div class="square position-relative display-2 mb-3">
									<img src="assets/img/profile-pic.jpg" alt="profile picture">
								</div>
								<!-- Upload button only image files are allowed with "accept"-->
								<div class="upload-btn-wrapper">
									<button class="btn">Upload a file</button>
									<input type="file" name="profilePicture" id="profilePicture" accept="image/*">	
								</div>
							</div> <!-- Row END -->
						</div>
					</div>
				</div> <!-- Row END -->
				<!-- Save button -->
				<!-- <div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div> -->
	

					<!-- Upload profile photo-->
					<div class="col-xxl-4">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row g-3">
								<h4 class="mb-4 mt-0">Upload your profile photo</h4>
								<div class="text-center">
									<!-- Image upload -->
									<div class="square position-relative display-2 mb-3">
										<i class="fas fa-fw fa-user position-absolute top-50 start-50 translate-middle text-secondary"></i>
									</div>
									<!-- Button, only image files are allowed: accept-->
									<input type="file" id="profilePicture" name="profilePicture" hidden="" accept="image/*">
									<label class="btn btn-block" for="profilePicture">Hochladen</label>
									<!-- <button type="button" class="btn">Löschen</button> -->
									<!-- Content -->
									<p class="text-muted mt-3 mb-0"><span class="me-1">Note:</span>Max. Größe: 50 MB</p>
								</div>
							</div>
						</div>
					</div>
				</div> <!-- Row END -->

				
					<!-- change password -->
					<div class="col-xxl-6">
						<div class="bg-secondary-soft px-4 py-5 rounded">
							<div class="row g-3">
								<h4 class="my-4">Change Password</h4>
								<!-- Old password -->
								<div class="col-md-6">
									<label for="exampleInputPassword1" class="form-label">Old password *</label>
									<input type="password" class="form-control" id="exampleInputPassword1">
								</div>
								<!-- New password -->
								<div class="col-md-6">
									<label for="exampleInputPassword2" class="form-label">New password *</label>
									<input type="password" class="form-control" id="exampleInputPassword2">
								</div>
								<!-- Confirm password -->
								<div class="col-md-12">
									<label for="exampleInputPassword3" class="form-label">Confirm Password *</label>
									<input type="password" class="form-control" id="exampleInputPassword3">
								</div>
							</div>
						</div>
					</div>
				</div> <!-- Row END -->
				<!-- button -->
				<div class="gap-3 d-md-flex justify-content-md-end text-center">
					<button type="button" class="btn btn-danger btn-lg">Delete profile</button>
					<button type="button" class="btn btn-primary btn-lg">Update profile</button>
				</div>
			</form> <!-- Form END -->
		</div>
	</div>                
            </div>
        </div>



    </main>

    <footer class="footer sticky-bottom">
        <?php include "components/footer.php";?>
    </footer>

</body>

</html>