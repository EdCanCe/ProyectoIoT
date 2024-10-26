<?php require_once "src/config/db_connection.php" //Enlace al documento que se conecta a la base de datos

if (isset($_GET["text"])) {
    $text = $_GET["text"];

    $query = 'INSERT INTO mydata(datatest) VALUES ("$text");';
    $result = mysqli_query($connection, $query);

    $query = 'SELECT datatest FROM mydata';
    $result = mysqli_query($connection, $query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<p>'.$row['datatest'].'</p>';
    }
}else{?>
    <h1>Wowowow</h1>
<?php}