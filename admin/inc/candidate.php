<?php 
    if(isset($_GET['added'])){
    ?>
        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
            Election has been added Successfully!
            <button type="button" class="close border bg-transparent" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            document.querySelector(".close").addEventListener('click', () => {
                document.querySelector(".alert").style.visibility = 'hidden';
                window.location.href = 'index.php?addElectionPage=1';
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
                                    ?>
                                    <option value="<?php echo $election_id; ?>"> <?php echo $election_name; ?></option>
                                    <?php
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
                        <th scope="col">Election Name</th>
                        <th scope="col">Candidate</th>
                        <th scope="col">Starting Date</th>
                        <th scope="col">Ending Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $fetchingData = mysqli_query($db,"SELECT * FROM elections") or die(mysqli_error($db));

                        $isAnyElectionAdded = mysqli_num_rows($fetchingData);

                        if($isAnyElectionAdded > 0){
                            $sno=1;
                            while($row = mysqli_fetch_assoc($fetchingData)){
                                ?>
                                <tr>
                                    <td><?php echo $sno++; ?></td>
                                    <td><?php echo $row["election_topic"]; ?></td>
                                    <td><?php echo $row["no_of_candidates"]; ?></td>
                                    <td><?php echo $row["starting_date"]; ?></td>
                                    <td><?php echo $row["ending_date"]; ?></td>
                                    <td><?php echo $row["status"]; ?></td>
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
                                    <td colspan="7"> No Elections are added yet.</td>
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
        //               

        $election_id = mysqli_real_escape_string($db,$_POST['election_id']);
        $candidate_name = mysqli_real_escape_string($db,$_POST['candidate_name']);
        $candidate_details = mysqli_real_escape_string($db,$_POST['candidate_details']);
        $inserted_by = $_SESSION['fullName'];
        $inserted_on = date('Y-m-d');

        $candidate_photo = mysqli_real_escape_string($db,$_POST['candidate_photo']);

        

        //inserting into db
        mysqli_query($db,"INSERT INTO elections(election_topic,no_of_candidates,starting_date,ending_date,status,inserted_by,inserted_on) VALUES('".$election_topic."','".$no_of_candidates."','".$starting_date."','".$ending_date."','".$status."','".$inserted_by."','".$inserted_on."')") or die(mysqli_error($db));

        ?>
            <script>location.assign('index.php?addElectionPage=1&added=1')</script>
        <?php

    } 

?>