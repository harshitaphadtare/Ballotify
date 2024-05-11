<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    <h2 class="mt-5 h2 text-center" style="color: #2C3A47;">Hello <?php echo $_SESSION['fullName'];?>!</h2>
    <p class="lead text-center mb-5">Welcome to Ballotify...</p>

    <div class="row m-3">
        <div class="col-12">
            <h4 class="h4 mb-4">Elections</h4>
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
                                        <a href="index.php?viewResult=<?php echo $election_id; ?>" class="btn btn-sm btn-success">View Results</a>
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

