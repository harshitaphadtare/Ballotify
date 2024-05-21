<?php

$election_id = $_SESSION['election_edit_id']; 

if ($election_id) {
    $query = "SELECT * FROM elections WHERE id='$election_id'";
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    $election = mysqli_fetch_assoc($result);

    $election_topic = $election['election_topic'];
    $no_of_candidates = $election['no_of_candidates'];
    $starting_date = $election['starting_date'];
    $ending_date = $election['ending_date'];
} else {
    // Initialize variables if no election ID is set
    $election_topic = '';
    $no_of_candidates = '';
    $starting_date = '';
    $ending_date = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
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
    #box-header {
        color: white;
    }
    .form-group {
        margin-bottom: 15px;
    }
</style>
</head>
<body>
    <div class="col-3 boxit shadow">
        <h4 class="h4 mb-5" id="box-header">Update Election Details</h4>
        <form method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="election_topic" placeholder="Election Topic" value="<?php echo htmlspecialchars($election_topic); ?>" required>
            </div>
            <div class="form-group">
                <input type="number" class="form-control" name="no_of_candidates" placeholder="No of Candidates" value="<?php echo htmlspecialchars($no_of_candidates); ?>" required>
            </div>
            <div class="form-group">
                <input type="text" onfocus="this.type='Date'" class="form-control" name="starting_date" placeholder="Starting Date" value="<?php echo htmlspecialchars($starting_date); ?>" required>
            </div>
            <div class="form-group mb-5">
                <input type="text" onfocus="this.type='Date'" class="form-control" name="ending_date" placeholder="Ending Date" value="<?php echo htmlspecialchars($ending_date); ?>" required>
            </div>
            <input type="submit" id="box-btn" value="Update Election" class="btn btn-info" name="updateElectionBtn">
        </form>
    </div>
</body>
</html>

<?php
if (isset($_POST['updateElectionBtn'])) {
    $election_id = $_SESSION['election_edit_id'];
    $election_topic = mysqli_real_escape_string($db, $_POST['election_topic']);
    $no_of_candidates = mysqli_real_escape_string($db, $_POST['no_of_candidates']);
    $starting_date = mysqli_real_escape_string($db, $_POST['starting_date']);
    $ending_date = mysqli_real_escape_string($db, $_POST['ending_date']);
    $inserted_by = $_SESSION['fullName'];
    $inserted_on = date('Y-m-d');

    $date1 = date_create($inserted_on);
    $date2 = date_create($starting_date);
    $diff = date_diff($date1, $date2);

    if ($diff->format("%R%a") > 0) {
        $status = "Inactive";
    } else {
        $status = "Active";
    }

    // Updating the database
    mysqli_query($db, "UPDATE elections 
        SET election_topic='$election_topic',
            no_of_candidates='$no_of_candidates',
            starting_date='$starting_date',
            ending_date='$ending_date',
            status='$status',
            inserted_by='$inserted_by',
            inserted_on='$inserted_on'
        WHERE id='$election_id'") or die(mysqli_error($db));

    ?>
    <script>location.assign('index.php?addElectionPage=1&updated=1');</script>
    <?php
}
?>
