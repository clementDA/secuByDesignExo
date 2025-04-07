<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
</head>
<body>
    <h1>Checkout</h1>

    <?php
    // Vérifie si le paramètre "total" est présent dans l'URL
    if (isset($_GET['total'])) {
        // Récupère le total et le formate en tant que nombre flottant
        $total = floatval($_GET['total']);
        echo "<p>Le total à payer est : €" . number_format($total, 2) . "</p>";
    } else {
        // Si le paramètre n'est pas trouvé, afficher un message d'erreur
        echo "<p>Aucun total n'a été trouvé.</p>";
    }
    ?>

<a href="index.php">
          Valider payement?
        </a>
</body>
</html>
