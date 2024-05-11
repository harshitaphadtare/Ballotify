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
        }

        .footerBottom {
            bottom: 0;
            width: 99%;
        }

        .content {
            margin-inline: 30px;
            padding-bottom: 60px; /* Adjust padding to prevent content from being hidden under the footer */
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
            }else if(isset($_GET['viewResult'])){
                require_once("inc/viewResults.php");
            }
        ?>
    </div>
    <div class="footerBottom">
        <?php require_once("inc/footer.php"); ?>
    </div>
</body>
</html>
