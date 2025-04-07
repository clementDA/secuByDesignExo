
<?php
session_start();

require_once 'config/database.php';

if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'user'; 
}

if ($_SESSION['role'] == 'admin') {
    echo "<h1>Bienvenue, administrateur!</h1>";
    echo "<p>Voici les outils d'administration.</p>";
} else {
    echo "<script>
    alert('Accès refusé. Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
    window.location.href = 'index.php';
  </script>";

}
$query = "SELECT id,username,email,role FROM users"; 
$stmt = $db->prepare($query);
$stmt->execute();

// Afficher les infos
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin</title>
    <style>
table, th, td {
  border: 1px solid black;
  border-radius: 10px;
}
</style
</head>

<h1>Liste des emails des utilisateurs</h1>
    <table style="width:80%; margin-left: 10%">
    <tr style="background-color:red">
      <th scope="col">Username</th>
      <th scope="col">email</th>
      <th scope="col">role</th>
      <th scope="col">Grand admin privileges</th>
    </tr>
        <?php
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            
            echo '<tr><th>'.htmlspecialchars($row['username']) .'</th><th>'.htmlspecialchars($row['email']) .'</th><th>'.htmlspecialchars($row['role']) .'</th><th>';
            if ($row['role'] !== 'admin') {
                echo '<a href="promote_user.php?id=' . $row['id'] . '" class="btn-promote">Promouvoir en Admin</a>';
            } else {
                echo '<span>(Déjà admin)</span>';
            }         
             echo '</th></tr>';
        }
        ?>
    </table>
    
</body>
</html