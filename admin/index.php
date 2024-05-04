<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        .headerTop {
            padding: 10px;
        }
        .footerBottom {
            position: absolute;
            bottom: 0;
            width: 100%;
        }
        .content {
            margin-inline: 30px;
            min-height: calc(100vh - 2 * 10px); 
        }
    </style>
</head>
<body>
    <div class="headerTop">
        <?php require_once("inc/header.php"); ?>
    </div>
    <div class="content">
        <?php
            if(isset($_GET['homePage'])){
                require_once("inc/home.php");
            } else if(isset($_GET['addElectionPage'])){
                require_once("inc/election.php");
            } else if(isset($_GET['addCandidatePage'])){
                require_once("inc/candidate.php");
            }
        ?>
    </div>
    <div class="footerBottom">
        <?php require_once("inc/footer.php"); ?>
    </div>
</body>
</html>
