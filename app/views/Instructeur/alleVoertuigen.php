<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= URLROOT; ?>/css/style.css">
    <title>Document</title>
</head>

<body>
    <h3><u><?= $data['title']; ?></u></h3>
    <table>
        <thead>
            <th>Type Voertuig</th>
            <th>Type</th>
            <th>Kenteken</th>
            <th>Bouwjaar</th>
            <th>Brandstof</th>
            <th>RijbewijsCategorie</th>
            <th>InstructeurNaam</th>
            <th>Verwijderen</th>
        </thead>
        <tbody>
            <?= $data['tableRows']; ?>
        </tbody>
    </table>

    <?php if (isset($data['deleteMessage'])) : ?>
        <div><?= $data['deleteMessage']; ?></div>
    <?php endif ?>

</body>

</html>