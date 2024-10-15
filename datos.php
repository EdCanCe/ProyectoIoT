<?php
include("database.php");
$text = $_GET['text'];

$query = "INSERT INTO mydata(datatest) VALUES ('$text');";
$result = mysqli_query($connection, $query);

$query = "SELECT datatest FROM mydata";
$result = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<p>".$row["datatest"]."</p>";
} ?>