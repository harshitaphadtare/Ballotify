<?php

$candidate_id = $_SESSION['editId']; 

if ($candidate_id) {
    $query = "SELECT * FROM candidate_details WHERE id='$candidate_id'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $candidate = mysqli_fetch_assoc($result);

    $election_id = $candidate['election_id'];
    $candidate_name = $candidate['candidate_name'];
    $candidate_details = $candidate['candidate_details'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .boxit {
            border: 1px solid #0096FF;
            border-radius: 20px;
            padding: 30px;
            height: 420px; 
            margin-top: 80px;
            margin-bottom: 60px;
            margin-left: 550px;
            background-color: #2C3A47;
        }
        #box-header{
            color: white;
        }
        .form-group {
            margin-bottom: 15px;
        }
        
    </style>
</head>
<body>
    <div class="col-3 boxit shadow">
        <h4 class="h4 mb-5" id="box-header">Update Candidate Details</h4>
        <form method="post" enctype="multipart/form-data"> <!-- enctype allows you to add files (image url) -->
            <div class="form-group">
                <select class="form-control" name="election_id" required>
                    <option value="">Select Election</option>
                    <?php
                        $fetchingElections = mysqli_query($db, "SELECT * FROM elections") OR die(mysqli_error($db));
                        $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
                        if ($isAnyElectionAdded > 0) {
                            while ($row = mysqli_fetch_assoc($fetchingElections)) {
                                $election_id_option = $row['id'];
                                $election_name = $row['election_topic'];
                                $allowed_candidates = $row['no_of_candidates'];

                                // Checking number of candidates added in an election
                                $fetchingCandidate = mysqli_query($db, "SELECT * FROM candidate_details WHERE election_id ='".$election_id_option."'") or die(mysqli_error($db));
                                $added_candidates = mysqli_num_rows($fetchingCandidate);

                                if ($added_candidates < $allowed_candidates) {
                                    ?>
                                    <option value="<?php echo $election_id_option; ?>" <?php if($election_id_option == $election_id) echo 'selected'; ?>><?php echo $election_name; ?></option>
                                    <?php
                                }
                            }
                        } else {
                            ?>
                            <option value="">Please Add Elections</option>
                            <?php
                        }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="candidate_name" name="candidate_name" placeholder="Candidate Name" value="<?php echo htmlspecialchars($candidate_name); ?>" required>
            </div>
            <div class="form-group">
                <input type="file" class="form-control" name="candidate_photo">
            </div>
            <div class="form-group mb-5">
                <input type="text" class="form-control" id="candidate_details" name="candidate_details" placeholder="Candidate Details" value="<?php echo htmlspecialchars($candidate_details); ?>" required>
            </div>
            <input type="submit" value="Update Details" class="btn btn-info" id="box-btn" name="updateDetailsBtn">
        </form>
    </div>   
</body>
</html>

<?php
if (isset($_POST['updateDetailsBtn'])) {
    $election_id = mysqli_real_escape_string($db, $_POST['election_id']);
    $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
    $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
    $inserted_by = $_SESSION['fullName'];
    $inserted_on = date('Y-m-d');

    // Photo logic
    $targetted_photo ='../assets/candidate_photo/';
    $candidate_photo = $targetted_photo . rand(1111111111, 9999999999999) . "_" . rand(1111111111, 9999999999999) . $_FILES['candidate_photo']['name'];
    $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
    $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
    $allowed_types = array("jpg", "png", "jpeg");
    $image_size = $_FILES['candidate_photo']['size'];

    if ($image_size < 2000000) { // 2MB
        if (in_array($candidate_photo_type, $allowed_types)) {
            if (move_uploaded_file($candidate_photo_tmp_name, $candidate_photo)) {
                mysqli_query($db, "UPDATE candidate_details 
                    SET election_id='$election_id', 
                        candidate_name='$candidate_name',
                        candidate_details='$candidate_details',
                        candidate_photo='$candidate_photo',
                        inserted_by='$inserted_by',
                        inserted_on='$inserted_on'
                    WHERE id='$candidate_id'") or die(mysqli_error($db));
                
                echo "<script> location.assign('index.php?addCandidatePage=1&updated=1'); </script>";
            } else {
                echo "<script> location.assign('index.php?addCandidatePage=1&failed=1'); </script>";
            }
        } else {
            echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1'); </script>";
        }
    } else {
        echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1'); </script>";
    }
}
?>
