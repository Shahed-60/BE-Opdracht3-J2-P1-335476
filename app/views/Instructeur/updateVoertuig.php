<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    // echo $data['title'];
    // var_dump($data['voertuigInfo']);
    // var_dump($data['voertuigInfo'][0]->Brandstof);
    // 
    ?>
    <!-- <?php
            // echo $data['voertuigId'];
            ?> -->
    <form action="<?= URLROOT ?>/instructeur/updateVoertuigSave/<?= $data['instructeurId'] ?>/<?= $data['voertuigId'] ?>" method="POST">
        <u>
            <h2>Wijzegen vortuiggegevens</h2>
        </u><br>
        <!-- <label for="instructeur">Instructeur</label><br>
        <select name="instructeur" id="instructeur">
            <?php foreach ($data['instructeurs'] as $instructeur) :
            ?>
                <option value="<?php $instructeur->Id ?>"> <?php echo $instructeur->Voornaam . " " .  $instructeur->Tussenvoegsel . " " .  $instructeur->Achternaam ?></option>
            <?php endforeach ?>
        </select><br><br> -->
        <label for="instructeur">instructeur:</label>
        <select name="instructeur" id="instructeur">
            <option value="5" <?= $data['instructeurId'] == 5 ? "Selected" : "" ?>>Mohammed El Yassidi </option>
            <option value="4" <?= $data['instructeurId'] == 4 ? "Selected" : "" ?>>Bert van Sali</option>
            <option value="1" <?= $data['instructeurId'] == 1 ? "Selected" : "" ?>>Li Zhan</option>
            <option value="3" <?= $data['instructeurId'] == 3 ? "Selected" : "" ?>>Yoeri van Veen</option>
            <option value="2" <?= $data['instructeurId'] == 2 ? "Selected" : "" ?>>Leroy Boerhaven</option>
        </select><br><br>

        <label for="typevoertuig">Type Voertuig:</label><br>
        <select name="typevoertuig" id="typevoertuig">
            <option value="Personenauto">Personenauto</option>
            <option value="Vrachtwagen">Vrachtwagen</option>
            <option value="Bus">Bus</option>
            <option value="Bromfiets">Bromfiets</option>
        </select><br><br>


        <label for="type">Type:</label><br>
        <input type="text" name="type" id="type" value="<?php echo $data['voertuigInfo'][0]->Type ?>"><br><br>

        <label for="Bouwjaar">Bouwjaar:</label><br>
        <input readonly type="date" name="Bouwjaar" value="<?= $data['voertuigInfo'][0]->Bouwjaar ?>"><br><br>

        <label for="brandstof">Brandstof:</label><br>
        <!-- <input type="text" name="brandstof" id="brandstof" value="<?php echo $data['voertuigInfo'][0]->Brandstof ?>"><br><br> -->
        <select name="brandstof" id="brandstof">
            <option value="Benzine" <?= $data['voertuigInfo'][0]->Brandstof == "Benzine" ? "Selected" : "" ?>>Benzine</option>
            <option value="Diesel" <?= $data['voertuigInfo'][0]->Brandstof == "Diesel" ? "Selected" : "" ?>>Diesel</option>
            <option value="Elektrisch" <?= $data['voertuigInfo'][0]->Brandstof == "Elektrisch" ? "Selected" : "" ?>>Elektrisch</option>
        </select><br><br>
        <label for="kenteken">Kenteken:</label><br>
        <input type="text" name="kenteken" id="kenteken" value="<?php echo $data['voertuigInfo'][0]->Kenteken ?>"><br><br>

        <button type="submit">Wijzeg</button>
    </form>
</body>

</html>