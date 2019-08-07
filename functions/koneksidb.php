<?php
try{
            $conn=new pdo("mysql:hostname=localhost;dbname=dbnilai","root",""
            ,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
             }catch(PDOException $e){
                echo($e->getMessage());
            }
?>
