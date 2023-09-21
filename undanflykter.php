<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>PUCKO</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="skapaKampanj.php">Skapa kampanj</a>
                </li>
                <li>
                    <a href="listaKampanjer.php">Lista Kampanjer</a>
                </li>
                <li>
                    <a href="index.php">Aktiva Kampanjer</a>
                </li>
                <li>
                    <a href="undanflykter.php">Undanflykter</a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Undanflykter</h1>
        <table>
            <?php
            $pdo = new PDO(
                'mysql:dbname=a22albjo;host=localhost', 
                'a22albjoDesinformationsspridare', 
                'lösenord'
            );
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            

            echo "<tr>";
            foreach($pdo->query('DESCRIBE undanflykter;') AS $row){
                echo "<th>";
                echo $row['Field'];
                echo "</th>";
            }

            echo "</tr>";
            echo "<tr>";

            foreach($pdo->query('SELECT * FROM undanflykter' ) AS $row){
                foreach($row AS $col=>$val){
                    echo "<td>";
                    echo($val);
                    echo "</td>";
                }

                $halt = $row['halt'];

                echo "<td>";
                echo "<form style='flex-direction:row' method='POST' action='' >";
                echo "<input name='titel' type='hidden' value='". $row["titel"] ."' >";
                echo '<input name="halt" type="text" value="' . $halt . '" ><input type="submit" value="Ändra" />';
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            };

            if(isset($_POST['halt'])){
                $query = 'update undanflykter set halt = :halt where titel = :titel;';
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(':halt', $_POST['halt']); // Use $_POST for form data
                $stmt->bindParam(':titel', $_POST['titel']); // Use $_POST for form data

                $stmt->execute();

                $rowCount = $stmt->rowCount();

                if ($rowCount > 0) {
                    echo "$rowCount rader updaterade."; 
                    header("Refresh:0; url=undanflykter.php");
                } else {
                    echo "Ingen uppdaterad rad."; 
                }
            }
            
            ?>
        </table>
    </main>
</body>
</html>
