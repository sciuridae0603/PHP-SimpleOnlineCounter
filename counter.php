<?php
session_start();
$session = session_id();
$time = (string)time();
$timeb = (int)$time - 30;
try{
    $db = new PDO("sqlite:counter.db");
}catch(PDOException $e){
    echo 'Error';
    exit();
}
$db->query('CREATE TABLE IF NOT EXISTS counter (session TEXT PRIMARY KEY UNIQUE, time TEXT);');

try{$delete = $db->prepare("DELETE FROM counter WHERE session = :session");$delete->bindParam( ':session' , $session );$delete->execute();}catch(Exception $e){}
$insert = $db->prepare('INSERT OR REPLACE INTO counter (session, time) VALUES ( :session, COALESCE((SELECT time FROM counter WHERE session = :session), :time));');
$insert->bindParam( ':session' , $session );
$insert->bindParam( ':time' , $time );
$insert->execute();   

$result = $db->query("SELECT * FROM counter");
foreach($result as $row){
    if((int)$row['time'] < $timeb){
        $delete = $db->prepare("DELETE FROM counter WHERE session = :session");$delete->bindParam( ':session' , $row['session'] );$delete->execute();
    }
}
$count 
= $db->query('select COUNT(*) from counter;');
echo($count->fetch()[0]);
