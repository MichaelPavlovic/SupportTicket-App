<?php

session_start();

if(!isset($_SESSION['loggedIn'])){
    header("Location:login.php");
}

$ticketID = $_POST['ticketID'];
$status = $_POST['status'];

$xmlTickets = simplexml_load_file("xml/tickets.xml");

foreach($xmlTickets->ticket as $t){
    if((string) $t->ticketID == (string) $ticketID){
        $att = 'status';

        $t->attributes()->$att = $status;
        $xmlTickets->saveXML("xml/tickets.xml");
    }
}

header("Location:tickets.php");