<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Récupérer les données des champs cachés
        $total = isset($_POST['total']) ? floatval($_POST['total']) : 0;
        $itemId = isset($_POST['item_id']) ? $_POST['item_id'] : '';

        // Vérifier que le total est un nombre valide et positif
        if (is_numeric($total) && $total > 0) {
            echo "<p>Le total à payer est : €" . number_format($total, 2) . "</p>";
        } else {
            echo "<p>Total invalide.</p>";
        }
    } else {
        echo "<p>Aucune donnée reçue.</p>";
    }
    ?>

    <a href="index.php">
        Valider paiement?
    </a>
</body>
</html>
