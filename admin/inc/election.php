
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
    }else if(isset($_GET['delete_id'])){
        mysqli_query($db,"DELETE FROM elections WHERE id = '".$_GET['delete_id']."'") or die(mysqli_error($db));
        mysqli_query($db,"DELETE FROM candidate_details WHERE election_id = '".$_GET['delete_id']."'") or die(mysqli_error($db));

        ?>
        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
            Election has been deleted Successfully!
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
    .main-box{
        margin-top: 100px !important;
    }
    .boxit{
        border: 1px solid #58B19F;
        border-radius: 20px;
        padding: 30px;
        margin-left: 30px;
        margin-right: 60px;
    }
    .form-group{
        margin-bottom: 12px;
    }
</style>
<body>

    <div class="row m-5 main-box">
        <div class="col-3 boxit shadow">
            <h4 class="h4 mb-5">Add New Election</h4>
             <form method="post">
                <div class="form-group">
                    <input type="text" class="form-control" name="election_topic" placeholder="Election Topic" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-control" name="no_of_candidates" placeholder="No of Candidates" required>
                </div>
                <div class="form-group">
                    <input type="text" onfocus="this.type='Date'" class="form-control" name="starting_date" placeholder="Starting Date" required>
                </div>
                <div class="form-group mb-5">
                    <input type="text" onfocus="this.type='Date'" class="form-control" name="ending_date" placeholder="Ending Date" required>
                </div>
                <input type="submit" value="Add Election" class="btn btn-success" name="addElectionBtn">
            </form>
        </div>
        <div class="col-8">
            <h4 class="h4 mb-4">Upcoming Election</h4>
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
                                $election_id = $row['id'];
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
                                        <button class="btn btn-danger btn-sm" onclick="DeleteData(<?php echo $election_id;?>)">Delete</button>
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

<script>
    const DeleteData = (e_id) =>{
        let c = confirm("Do you really want to Delete it?");
        if(c==true){
            location.assign("index.php?addElectionPage=1&delete_id="+e_id);
        }
    }
</script>

<?php
       
    if(isset($_POST['addElectionBtn']))
    {

        $election_topic = mysqli_real_escape_string($db,$_POST['election_topic']);
        $no_of_candidates = mysqli_real_escape_string($db,$_POST['no_of_candidates']);
        $starting_date = mysqli_real_escape_string($db,$_POST['starting_date']);
        $ending_date = mysqli_real_escape_string($db,$_POST['ending_date']);
        $inserted_by = $_SESSION['fullName'];
        $inserted_on = date('Y-m-d');

        $date1 = date_create($inserted_on);
        $date2 = date_create($starting_date);
        $diff = date_diff($date1,$date2);
        
        if($diff->format("%R%a")>0){
            $status = "Inactive";
        }else{
            $status = "Active";
        }

        //inserting into db
        mysqli_query($db,"INSERT INTO elections(election_topic,no_of_candidates,starting_date,ending_date,status,inserted_by,inserted_on) VALUES('".$election_topic."','".$no_of_candidates."','".$starting_date."','".$ending_date."','".$status."','".$inserted_by."','".$inserted_on."')") or die(mysqli_error($db));

        ?>
            <script>location.assign('index.php?addElectionPage=1&added=1')</script>
        <?php

    } 

?>