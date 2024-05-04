<?php

    session_start();
    require_once("config.php");

    if($_SESSION['key'] != "AdminKey"){

        echo "<script> location.assign('logout.php'); </script>";
        die;

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
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
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <div class="m-3 container-fluid">
            <a class=" mx-2 navbar-brand d-flex" href="#">
                <img src="../assets/positive-vote.png" alt="Ballotify" width="40" height="40"> 
                <h2 class="h2 mx-2">Ballotify</h1>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="mx-2 collapse d-flex justify-content-end align-items-center navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?homePage=1">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?addElectionPage=1">Election</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?addCandidatePage=1">Candidate</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            
        </div>
    </nav>

