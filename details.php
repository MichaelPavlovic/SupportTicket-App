<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
    header("Location:login.php");
}

$xmlTickets = simplexml_load_file("xml/tickets.xml");
$xmlUsers = simplexml_load_file("xml/users.xml");

$id = $_POST['id'];

foreach($xmlTickets->ticket as $t){
    if((string) $t->ticketID == (string) $id){
        $date = $t->dateIssued;
        $subject = $t->subject;
        $status = $t['status'];
        $authorID = $t['author'];
        $messages = $t->messages;
    }
}

$userID = '';
foreach($xmlUsers->user as $u){
    if($u->username == $_SESSION['loggedIn']){
        $userID = $u->id;
    }
}
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8">
        <title>Support Ticket System</title>
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script>

        </script>
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
        <h1 class="h3 heading">Details for <?= $subject; ?></h1>
        <div class="ticket-info">
            <p>Ticket ID: <?= $id; ?></p>
            <p>Date Issued: <?= $date; ?></p>
            <p>Status: <?= $status; ?></p>
            <form action="updateStatus.php" method="post">
                <input type="hidden" name="ticketID" value="<?= $id; ?>">
                <input type="hidden" name="status" value="<?php if($status=='Open'){ echo 'Closed'; } else{ echo 'Open'; } ?>">
                <?php
                    if($status == 'Open'){
                        echo '<input type="submit" value="Close Ticket" class="btn btn-outline-danger">';
                    }else{
                        echo '<input type="submit" value="Open Ticket" class="btn btn-outline-primary">';
                    }
                ?>

            </form>
        </div>
        <div class="chat">
            <?php
                foreach($messages->message as $m){
                    if($m['author'] == (string) $userID) {
                        echo '<div class="client"><p>' . $m->username . ' ' . $m->time . '</p><div class="msg-green">' . $m->content . '</div></div>';
                    } else{
                        echo '<div class="notClient"><p>' . $m->username . ' ' . $m->time . '</p><div class="msg-blue">' . $m->content . '</div></div>';
                    }
                }
            ?>
        </div>
        <div class="chat-form">
            <form action="addMessage.php" method="post" id="chatForm" autocomplete="off">
                <input type="hidden" id="userID" name="userID" value="<?= $userID; ?>">
                <input type="hidden" id="ticketID" name="ticketID" value="<?= $id ?>">
                <input type="text" id="message" name="message" placeholder="Enter a message..." class="form-control" <?php if($status == 'Closed'){ echo 'disabled'; } ?>>
                <input type="submit" id="send" name="send" value="Send" class="btn btn-success btn-block" <?php if($status == 'Closed'){ echo 'disabled'; } ?>>
            </form>
        </div>
        <footer id="footer">

        </footer>
    </body>
</html>
