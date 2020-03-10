<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
    header("Location:login.php");
}

$xmlTickets = simplexml_load_file("xml/tickets.xml");

$id = $_POST['id'];

foreach($xmlTickets->ticket as $t){
    if((string) $t->ticketID == (string) $id){
        $date = $t->dateIssued;
        $subject = $t->subject;
    }
}

?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <title>Support Ticket System</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <header id="header">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
                <span class="navbar-brand">Support Tickets</span>
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item "><a href="tickets.php" class="nav-link">Tickets</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-link active">Welcome back, <?= $_SESSION['loggedIn']; ?></li>
                </ul>
                <a href="logout.php" class="btn btn-danger my-2 my-sm-0">Logout</a>
            </nav>
        </header>
        <h1 class="h3">Details for <?= $subject; ?></h1>
        <p>Ticket ID: <?= $id; ?></p>
        <p>Date Issued: <?= $date; ?></p>
    </body>
</html>
