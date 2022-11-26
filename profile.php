<?php include "components/session.php";

$target_file = NULL;

if (isset($_POST["submit"])) {
	//specifies the path to the session file
	$target_dir ="res/img/img profile/";
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
			<p>The file <?php echo htmlspecialchars(basename( $_FILES["profilePicture"]["name"])); ?> has been uploaded.</p>
		<?php } else { ?>
			header('Refresh: 0; URL = ../profile.php');
			<p>Sorry, there was an error uploading your file.</p>
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

	<!-- <?php echo $target_dir; ?> -->

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
							<div class="row g-3">
								<h4 class="mb-4 mt-0">Kontaktdaten</h4>
								<!-- First Name -->
								<div class="col-md-6">
                                    <p><strong>Vorname:</strong></p>
                                    <p>Test</p>                                    
								</div>
								<!-- Last name -->
								<div class="col-md-6">
									<p><strong>Nachname:</strong></p>
                                    <p>Tester</p>
								</div>
								<!-- Address -->								
								<div class="col-md-6">
									<p><strong>Straße:</strong></p>
									<p>Teststraße 1</p>
								</div>
								<div class="col-md-6">
									<p><strong>Hausnummer/Stiege/Tür:</strong></p>
									<p>1/1/</p>
								</div>									
								<div class="col-md-6">
									<p><strong>PLZ:</strong></p>
									<p>1111</p>
								</div>
								<div class="col-md-6">
									<p><strong>Stadt:</strong></p>
									<p>Testort</p>
								</div>
								<!-- Phone number -->
								<div class="col-md-6">
									<p><strong>Telefonnummer:</strong></p>
                                    <p>+43 664 123 45 67</p>
								</div>
								<!-- Email -->
								<div class="col-md-6">
									<p><strong>E-Mailadresse:</strong></p>
                                    <p>test.tester@gmx.at</p>
								</div>								
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
										if (file_exists($target_file)) { ?>
											<img src="<?php echo $target_file; ?>" class="img-fluid rounded-circle" alt="Mein Profilbild">
										<?php } else { ?>
											<img src="res\img\img profile\dummy-profile-picture.jpg" class="img-fluid rounded-circle" alt="Profilbild">
										<?php } ?>							
									</div>
									<!-- Upload form -->
									<form action="profile.php" method="post" enctype="multipart/form-data">
										<div class="mb-3">
											<input type="file" name="profilePicture" id="profilePicture" accept="image/*">
										</div>
										<div class="mb-3">										
											<input type="submit" value="Bild hochladen" name="submit" class="btn">
										</div>									
									</form>
								</div>
							</div> <!-- Row END -->
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