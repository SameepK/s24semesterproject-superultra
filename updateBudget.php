<?php

#Databse Connection#
$db = new mysqli('oceanus.cse.buffalo.edu', 'schen277', '50396261', 'cse442_2024_spring_team_aa_db');

#Create table for sql#
$query = "SELECT GoldsName, TotalAmount, CurrentBudget 
          FROM newGoal ORDER BY updateTime DESC LIMIT 3";
$result = $db->query($query);


#assign the value to these registers#
$goalsName = $_POST['GoldsName'] ?? '';
$totalAmount = $_POST['TotalAmount'] ?? '';
$currentBudget = $_POST['CurrentBudget'] ?? '';


$stmt = $db->prepare("INSERT INTO newGoal (GoldsName, TotalAmount, CurrentBudget) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $GoldsName, $TotalAmount, $CurrentBudget);
$stmt->execute();
$stmt->close();


?>