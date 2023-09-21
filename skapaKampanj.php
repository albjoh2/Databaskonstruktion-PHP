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
        <h1>Skapa kampanj</h1>
        <form action="skapaKampanj.php" method="post">
            <div>
                <label>
                    Kampanjnummer: <input type="number" name="kampanjNr" >
                </label>
            </div>
            <div>
                <label>
                    Slutdatum: <input type="date" name="slutdatum" >
                </label>
            </div>
            <div>
                <label>
                    Kommentar: <input type="text" name="kommentar" >
                </label>
            </div>
            <div>
                Undanflykt: <select name="undanflykt" >
                <?php
                $pdo = new PDO(
                    'mysql:dbname=a22albjo;host=localhost', 
                    'a22albjoDesinformationsspridare', 
                    'lösenord'
                );
                $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                
                foreach($pdo->query('SELECT * FROM undanflykter;') AS $row){
                    echo "<option>";
                        echo($row['titel']);
                    
                    echo "</option>";
                };
                
                ?>
                </select>
            </div>

            <input type="submit" value="Skapa kampanj">
        </form>

        <table>

            <?php
        $pdo = new PDO(
            'mysql:dbname=a22albjo;host=localhost', 
            'a22albjoDesinformationsspridare', 
            'lösenord'
        );
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        
        if(isset($_POST['kampanjNr'])){
            $query = 'CALL skapaKampanj(:slutdatum, :kampanjNr);';
            $stmt = $pdo->prepare($query);
            if(isset($_POST['slutdatum'])){
                $stmt->bindParam(':slutdatum', $_POST['slutdatum']);
            }else{
                $stmt->bindParam(':slutdatum', "");
            }
            $stmt->bindParam(':kampanjNr', $_POST['kampanjNr']);
            $stmt->execute();

            $query = 'insert into kampanjUndanflykter(undanflykt, kampanj) values (:undanflykt, :kampanjNr);';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':kampanjNr', $_POST['kampanjNr']);
            $stmt->bindParam(':undanflykt', $_POST['undanflykt']);
            $stmt->execute();


            $query = 'insert into kampanjdetaljer(kampanjNr, succesrate, kommentar) values (:kampanjNr, 0.0, :kommentar);';
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':kampanjNr', $_POST['kampanjNr']);
            $stmt->bindParam(':kommentar', $_POST['kommentar']);
            $stmt->execute();

        }
        
        ?>
        </table>
    </main>
</body>
</html>