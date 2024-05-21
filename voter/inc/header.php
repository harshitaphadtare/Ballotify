<?php

    session_start();
    require_once("../admin/inc/config.php");

    if($_SESSION['key'] != "VoterKey"){
        ?>
        <script> location.assign('../admin/logout.php'); </script>
        <?php
        die;
        

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .navbar-nav .nav-item {
            margin-right: 10px; 
        }

        .navbar-nav .nav-link {
            padding: 10px 15px; 
            width: 100px; 
            text-align: center; 
        }
        .navbar-nav a:hover{
            color: #2C3A47;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .candidate-photo{
            width: 80px;
            height: 80px;
            border: 2px solid #58B19F;
            border-radius: 50%;
        }
        footer {
            bottom: 0;
            width: 99%;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
        <div class="m-1 container-fluid">
            <a class="navbar-brand d-flex" href="#">
                <img src="../assets/positive-vote.png" class="ms-2" alt="Ballotify" width="40" height="40"> 
                <h2 class="h2 mx-2">Ballotify</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="mx-2 collapse d-flex justify-content-end align-items-center navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            
        </div>
    </nav>

