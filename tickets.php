<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
    header("Location:login.php");
}

$xmlUsers = simplexml_load_file("xml/users.xml");
$xmlTickets = simplexml_load_file("xml/tickets.xml");

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Support Ticket System</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
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
        <?php
            $userType = $userID = '';
            foreach($xmlUsers->user as $u){
                if($u->username == $_SESSION['loggedIn']){
                    $userType = $u['type'];
                    $userID = $u->id;
                }
            }
            if($userType == 'admin'){
        ?>
        <main class="main">
            <h1 class="h3 heading">Tickets</h1>
            <div class="table-responsive container">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Subject</th><th scope="col">ID</th><th scope="col">Date Issued</th><th scope="col">Status</th><th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($xmlTickets->ticket as $t){
                    ?>
                        <tr>
                            <td><?= $t->subject; ?></td>
                            <td><?= $t->ticketID; ?></td>
                            <td><?= $t->dateIssued; ?></td>
                            <td><?= $t['status']; ?></td>
                            <td>
                                <form method="post" action="details.php">
                                    <input type="hidden" name="id" value="<?= $t->ticketID; ?>">
                                    <input type="submit" value="View" class="btn btn-outline-primary">
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php }
            if($userType == 'client'){ ?>
        <main class="main">
            <h1>Tickets</h1>
            <div class="table-responsive container">
                <table class="table table-bordered table-hover">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Subject</th><th scope="col">ID</th><th scope="col">Date Issued</th><th scope="col">Status</th><th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($xmlTickets->ticket as $t){
                            if($t['author'] == (string) $userID){
                                $id = $t->ticketID;
                    ?>
                            <tr>
                                <td><?= $t->subject; ?></td>
                                <td><?= $id; ?></td>
                                <td><?= $t->dateIssued; ?></td>
                                <td><?= $t['status']; ?></td>
                                <td>
                                    <form method="post" action="details.php">
                                        <input type="hidden" name="id" value="<?= $id; ?>">
                                        <input type="submit" value="View" class="btn btn-outline-primary">
                                    </form>
                                </td>
                            </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div>
        </main>
        <?php } ?>
        <footer id="footer">

        </footer>
    </body>
</html>
