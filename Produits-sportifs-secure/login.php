<?php
session_start();
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'config/database.php'; // Charger la connexion à la base de données

// Vérifier que la requête est bien POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier et sécuriser les champs du formulaire
    if (isset($_POST['email'])) {
        $email = $_POST['email']; // Récupérer le champ email sans sécurisation
    } else {
        $email = null; // Ou une valeur par défaut
    }

    if (isset($_POST['password'])) {
        $password = $_POST['password']; // Récupérer le champ password sans sécurisation
    } else {
        $password = null;
    }

    // Vérifier que les champs ne sont pas vides
    if ($email && $password) {
        try {
            // Rechercher l'utilisateur dans la base de données avec une requête vulnérable
            $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION['username'] = htmlspecialchars($user['username']);
                $_SESSION['role'] = htmlspecialchars($user['role']);

                header('Location: index.php');
            } else {
                echo "<a href='index.php'>Identifiants incorects</a>
";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
} else {
    echo "Requête invalide.";
}
?>
