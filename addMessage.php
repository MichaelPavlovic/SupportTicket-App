<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
    header("Location:login.php");
}

$user = $_SESSION['loggedIn'];
$userID = $_POST['userID'];
$tID = $_POST['ticketID'];
$content = $_POST['message'];

$xmlTickets = simplexml_load_file("xml/tickets.xml");

foreach($xmlTickets->ticket as $t){
    if((string) $t->ticketID == (string) $tID){
        date_default_timezone_set('America/Toronto');
        $date = date("h:iA - M d");

        $messages = $t->messages;
        $m = $messages->addChild("message");
        $m->addAttribute("author", "$userID");
        $m->addChild("username", "$user");
        $m->addChild("time", "$date");
        $m->addChild("content", "$content");
        $xmlTickets->saveXML("xml/tickets.xml");
    }
}

header("Location:tickets.php");