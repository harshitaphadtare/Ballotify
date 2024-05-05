<?php 
    if(isset($_GET['added'])){
    ?>
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            Candidate has been added Successfully!
            <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            document.querySelector(".close").addEventListener('click', () => {
                document.querySelector(".alert").style.visibility = 'hidden';
                window.location.href = 'index.php?addCandidatePage=1';
            });
        </script>
    <?php
    }else if(isset($_GET['largeFile'])){
    ?>
        <div class="alert alert-warning alert-dismissible fade show d-flex justify-content-between" role="alert">
            Image is too Large, please upload image that has size less than 2MB!
            <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            document.querySelector(".close").addEventListener('click', () => {
                document.querySelector(".alert").style.visibility = 'hidden';
                window.location.href = 'index.php?addCandidatePage=1';
            });
        </script>
    <?php 
    }else if(isset($_GET['invalidFile'])){
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                Invalid Image type: only .jpg, .jpeg and .png formated files are allowed!
                <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                document.querySelector(".close").addEventListener('click', () => {
                    document.querySelector(".alert").style.visibility = 'hidden';
                    window.location.href = 'index.php?addCandidatePage=1';
                });
            </script>
        <?php
    }else if(isset($_GET['failed'])){
        ?>
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                Image uploading failed, please try again.
                <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                document.querySelector(".close").addEventListener('click', () => {
                    document.querySelector(".alert").style.visibility = 'hidden';
                    window.location.href = 'index.php?addCandidatePage=1';
                });
            </script>
        <?php
    }else if(isset($_GET['added'])){
        ?>
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                Candidate details have been added Successfully!
                <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <script>
                document.querySelector(".close").addEventListener('click', () => {
                    document.querySelector(".alert").style.visibility = 'hidden';
                    window.location.href = 'index.php?addCandidatePage=1';
                });
            </script>
        <?php
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<style>
    .boxit{
        border: 1px solid #58B19F;
        border-radius: 20px;
        padding: 30px;
        margin-inline: 40px;
    }
    .form-group{
        margin-bottom: 15px;
    }
    .candidate-photo{
        width: 80px;
        height: 80px;
        border: 2px solid #58B19F;
        border-radius: 50%;
    }
</style>
<body>

    <div class="row m-3">
        <div class="col-3 boxit shadow">
            <h4 class="h4 mb-5">Add New Candidates</h4>
             <form method="post" enctype="multipart/form-data"> <!--enctype allows you to add files (image url) -->
                <div class="form-group">
                    <select class="form-control" name="election_id" required>
                        <option value="">Select Election</option>
                        <?php
                            $fetchingElections = mysqli_query($db,"SELECT * FROM elections") OR die(mysqli_error($db));
                            $isAnyElectionAdded = mysqli_num_rows($fetchingElections);
                            if($isAnyElectionAdded >0){
                                while($row = mysqli_fetch_assoc($fetchingElections)){

                                    $election_id = $row['id'];
                                    $election_name = $row['election_topic'];
                                    $allowed_candidates = $row['no_of_candidates'];

                                    //checking number of candidates added in en election
                                    $fetchingCandidate = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id ='".$election_id."' ") or die(mysqli_error($db));
                                    $added_candidates = mysqli_num_rows($fetchingCandidate);

                                    if($added_candidates < $allowed_candidates){
                                        ?>
                                        <option value="<?php echo $election_id; ?>"> <?php echo $election_name; ?></option>
                                        <?php
                                    }
                                }
                            }else{
                                ?>
                                <option value="">Please Add Elections</option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" name="candidate_name" placeholder="Candidate Name" required>
                </div>
                <div class="form-group">
                    <input type="file" class="form-control" name="candidate_photo" required>
                </div>
                <div class="form-group mb-5">
                    <input type="text" class="form-control" name="candidate_details" placeholder="Candidate Details" required>
                </div>
                <input type="submit" value="Add Candidate" class="btn btn-success" name="addCandidateBtn">
            </form>
        </div>   
        <div class="col-8">
            <h4 class="h4 mb-4">Candidate Details</h4>
            <table class="table table-hover border-top">
                <thead>
                    <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Photo</th>
                        <th scope="col">Name</th>
                        <th scope="col">Details</th>
                        <th scope="col">Election</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $fetchingData = mysqli_query($db,"SELECT * FROM candidate_details") or die(mysqli_error($db));

                        $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                        if($isAnyCandidateAdded > 0){
                            $sno=1;
                            while($row = mysqli_fetch_assoc($fetchingData)){
                                
                                $election_id = $row['election_id'];
                                $fetchingElectionName = mysqli_query($db,"SELECT * FROM elections WHERE id = '".$election_id."'") or die(mysqli_error($db));
                                $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName) ;
                                $election_name = $execFetchingElectionNameQuery['election_topic'];

                                $candidate_photo = $row['candidate_photo'];

                                ?>
                                <tr class="align-middle">
                                    <td><?php echo $sno++; ?></td>
                                    <td><img src="<?php echo $candidate_photo; ?>" alt="candidate photo" class="candidate-photo"></td>
                                    <td><?php echo $row["candidate_name"]; ?></td>
                                    <td><?php echo $row["candidate_details"]; ?></td>
                                    <td><?php echo $election_name; ?></td>
                                    <td>
                                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <?php
                            };
                        }else{
                            ?>
                                <tr>
                                    <td colspan="7"> No Candidates are added yet.</td>
                                </tr>
                            <?php
                        }
                    ?>
                </tbody>
                </table>
        </div>
    </div>

</body>
</html>

<?php
       
    if(isset($_POST['addCandidateBtn']))
    {
        
        $election_id = mysqli_real_escape_string($db,$_POST['election_id']);
        $candidate_name = mysqli_real_escape_string($db,$_POST['candidate_name']);
        $candidate_details = mysqli_real_escape_string($db,$_POST['candidate_details']);
        $inserted_by = $_SESSION['fullName'];
        $inserted_on = date('Y-m-d');

        // photo logic
        $targetted_photo ='../assets/candidate_photo/';
        $candidate_photo = $targetted_photo . rand(1111111111,9999999999999) . "_" . rand(1111111111,9999999999999) .  $_FILES['candidate_photo']['name'];
        $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
        $candidate_photo_type = strtolower(pathinfo($candidate_photo,PATHINFO_EXTENSION));
        $allowed_types = array("jpg","png","jpeg");
        $image_size = $_FILES['candidate_photo']['size'];

        if($image_size < 2000000){ //2MB

            if(in_array($candidate_photo_type,$allowed_types)){
                if(move_uploaded_file($candidate_photo_tmp_name,$candidate_photo)){

                    mysqli_query($db,"INSERT INTO candidate_details(election_id,candidate_name,candidate_details,candidate_photo,inserted_by,inserted_on) VALUES('".$election_id."','".$candidate_name."','".$candidate_details."','".$candidate_photo."','".$inserted_by."','".$inserted_on."')") or die(mysqli_error($db));

                    echo "<script> location.assign('index.php?addCandidatePage=1&added=1'); </script>";

                }else{
                    echo "<script> location.assign('index.php?addCandidatePage=1&failed=1'); </script>";
                }
            }else{
                echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1'); </script>";
            }

        }else{
            echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1'); </script>";
        }
        

    } 

?>