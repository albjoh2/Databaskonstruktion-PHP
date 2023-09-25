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

    <h1>Sök på startdatum</h1>
    <form action="./listaKampanjer.php" method="post">
        <input type="date" name="datum" value="2020-01-01">
        <input type="submit" value="sök" />
    </form>

        <table>

        <?php
        $pdo = new PDO(
            'mysql:dbname=a22albjo;host=localhost', 
            'a22albjoDesinformationsspridare', 
            'lösenord'
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        $data = [];
        
        if(isset($_POST['datum'])){
            $query = 'CALL hämtaKampanjerEfterDatum(:datum);';
            $stmt = $pdo->prepare($query);
            if(isset($_POST['datum'])){
                $stmt->bindParam(':datum', $_POST['datum']);
            }else{
                $stmt->bindParam(':datum', "2020-01-01");
            }
            $stmt->execute();
            $data = $stmt->fetchAll();
        }



        foreach(($data) AS $row){
            echo "<tr>";
            foreach($row AS $col=>$val){
                echo "<td>";
                echo($val);
                echo "</td>";
            }
            echo "</tr>";
        };
        
        ?>
        </table>
    </main>
</body>
</html>