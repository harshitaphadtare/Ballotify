<?php 
    $election_id = $_GET['viewResult'];
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    .candidate-photo{
        width: 80px;
        height: 80px;
        border: 2px solid #58B19F;
        border-radius: 50%;
    }
    </style>
</head>
<body>

<div class="container">
        <div class="my-5">
            <div class="col-12">
                <h3 class="mb-5">Election Results</h3>

                <?php
                    $fetchingActiveElections = mysqli_query($db,"SELECT * FROM elections WHERE id='".$election_id."' ") or die(mysqli_error($db));
                    $totalActiveElections = mysqli_num_rows($fetchingActiveElections);

                    if($totalActiveElections>0){
                        while($data = mysqli_fetch_assoc($fetchingActiveElections)){
                            $election_id = $data['id'];
                            $election_topic = $data['election_topic'];
                            ?>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="5" style="background-color:#2C3A47; color:#F8EFBA;">Election: <?php echo strtoupper($election_topic)?> </th>
                                    </tr>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Candidate Name</th>
                                        <th>Candidate Details</th>
                                        <th>No of Votes</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $fetchingCandidates = mysqli_query($db,"SELECT * FROM candidate_details WHERE election_id ='".$election_id."' ") or die(mysqli_error($db));
                                    
                                    while($candidateData = mysqli_fetch_assoc($fetchingCandidates)){
                                        $candidate_id = $candidateData['id'];
                                        $candidate_photo =$candidateData['candidate_photo'];
                                        
                                        //Fetching Candidate Votes 
                                        $fetchingVotes = mysqli_query($db,"SELECT * FROM votings WHERE candidate_id = '".$candidate_id."'") or die(mysqli_error($db));
                                        $totalVotes = mysqli_num_rows($fetchingVotes);
                                    ?>
                                    
                                        <tr class="align-middle">
                                            <td><img src="<?php echo $candidate_photo ?>" class="candidate-photo"></td>
                                            <td><?php echo "<b>". $candidateData['candidate_name'] ."</b>"?></td>
                                            <td><?php echo $candidateData['candidate_details'] ?></td>
                                            <td><?php echo $totalVotes ?></td>
                                            <td>
                                            <?php
                                                $date1 = date_create($curr_date);
                                                $date2 = date_create($starting_date);
                                                $diff = date_diff($date1,$date2);
                                                
                                                if((int)$diff->format("%R%a")==0){
                                                    // mysqli_query($db,"UPDATE elections SET status='Active' WHERE id = '".$election_id."'") OR die(mysqli_error($db));
                                                    
                                                }
                                            ?>
                                            </td>
                                        </tr>

                                    <?php
                                    };

                                    ?>
                                </tbody>
                            </table>

                        <?php
                        }
                    }else{
                        echo "No Elections are Active!";
                    }

                ?>

                
            </div>
        </div>
    </div>
</body>
</html>