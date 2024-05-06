<?php
     
    require_once("inc/header.php");
    
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
                <h3 class="mb-5">Voters Area</h3>

                <?php
                    $fetchingActiveElections = mysqli_query($db,"SELECT * FROM elections WHERE status = 'Active' ") or die(mysqli_error($db));
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
                                        <th>Action</th>
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
                                                $checkIfVoteCasted = mysqli_query($db,"SELECT * FROM votings WHERE voters_id='".$_SESSION['user_id']."' AND election_id= '".$election_id."'") or die(mysqli_error($db)); 
                                                $isVoteCasted = mysqli_num_rows($checkIfVoteCasted);
                                                if($isVoteCasted > 0){

                                                    $voteCastedData = mysqli_fetch_assoc($checkIfVoteCasted);
                                                    $voteCastedToCandidate = $voteCastedData['candidate_id'];
                                                    if($voteCastedToCandidate == $candidate_id){
                                                        ?><img src="../assets/voted.png" height="70px" alt="">
                                                        <?php
                                                    }

                                                    ?>
                                                    <?php 
                                                }else{
                                                ?>
                                                    <button class="btn btn-md btn-success px-4" onclick="CastVote(<?php echo $election_id; ?>, <?php echo $candidate_id; ?>,<?php echo $_SESSION['user_id']; ?>)">Vote</button>
                                                <?php 
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
<script>
            
    const CastVote = (election_id,candidate_id,voter_id) => {
        $.ajax({
            type: "POST",
            url: "inc/ajaxCalls.php",
            data: "e_id=" + election_id + "&c_id=" + candidate_id + "&v_id="+voter_id,
            success: function(response){
                if(response == "Success"){
                    location.assign("index.php?voteCasted=1");
                }else{
                    location.assign("index.php?voteNotCasted=1");
                }
            }
        });        
    };

</script>

<?php

    require_once("inc/footer.php");

?> 