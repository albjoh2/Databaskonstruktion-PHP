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

        <h1>Aktiva kampanjer</h1>
        <table>

            <?php
        $pdo = new PDO(
            'mysql:dbname=a22albjo;host=localhost', 
            'a22albjoDesinformationsspridare', 
            'lösenord'
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        
        
        foreach($pdo->query('SELECT * FROM kampanj JOIN kampanjdetaljer ON kampanj.nr = kampanjdetaljer.kampanjNr JOIN kampanjUndanflykter ON kampanj.nr = kampanjUndanflykter.kampanj;' ) AS $row){
            echo "<tr>";
            foreach($row AS $col=>$val){
                echo "<td>";
                echo($val);
                echo "</td>";
            }
            echo "<td><a href='index.php?arkivera=".$row['nr']."'>arkivera</a></td>";
            echo "</tr>";
        };

        if(isset($_GET['arkivera'])){
            $query = 'CALL arkiveraKampanj(:kampanjNr);';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':kampanjNr', $_GET['arkivera']);
            $stmt->execute();
            header("Refresh:0; url=index.php");
        }
        ?>

        </table>
    </main>
</body>
</html>