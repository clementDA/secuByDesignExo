<h1>SecuByDesign</h1>

Le repository est séparé en deux:
protuits-sportif,  le code non sécurisé du site.
produits-sportif-secure, la version sécurisé du code du site.

L'application est conçue avec les technologies PHP,nodejs, mysql.
La base de donnée comprend une unique table utilisateur.

L'application se présente sous la forme d'un site ecommerce de materiel et complément alimentaires sportifs.
Il posséde une page admin affichant tout les utilisateurs, une fonctionalité de panier et un champ de recherche.

Le déploiement des deux site de font par l'utilisation d'un serveur apache et le déploiement d'une base mysql.
Le dossier doit juste être déployé dans le dossier www
et le fichier /config/database.php reparamétré selon les paramètres de la nouvelle base de donnée.

(par manque de temps aucun déployement docker n'a pu être réalisé)



Une vidéo accompagne le dossier et ce readme, démontrant les quatres vulnérabilitées qui ont été ici exploité (et corrigées)

1: InjectionSQL

La page de Login, dans sa première version, fonctionne par une requête sql placé dans le code.
Elle n'est pas protégé, il est donc possible d'utiliser les champs de login pour bypasser la nécéssité de mot de passe ou réaliser d'autres requetes sql imprévues.

On peut donc entrer ce que l'on souhait dans l'input d'identifiant et  l'injeciton "' OR '1'='1" a la place du mot de passe pour se connecter automatiquement.

Afin de prevenir ceci, la requête est préparé a l'avance(ligne 29 a 32, module login.php)

--------
 $stmt = $db->prepare("SELECT * FROM users WHERE email = :email AND password = :password");
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
------

ainsi l'injection est impossible par cette voie.


2: XSS

Un champ de recherche est disponible sur la page principale (index.php)
Comme ce dernier affiche la recherche voulue, il est possible de l'utiliser pour appliquer un code javascript quelconque pouvait modifier la page.

Exemple: <script>     document.body.style.backgroundColor = 'red'; </script>
-----

Avec l'emploi de cette recherche, on peut modifier la couleur de fond de la page.

Afin de corriger cette vulnérabilité, on ajoute un traitement a l'entrée émise par l'utilisateur, nullifiant l'application sous form de script.(index.php, ligne 358)

    $searchTerm = htmlspecialchars($_GET['search'], ENT_QUOTES, 'UTF-8');

3-Bypass URL


le site contiens une page /admin acessible uniquement par les administrateurs.
Cependant, un utilisateur malveillant peut modifier l'url pour y accéder directement et avoir accès aux outils administrateurs.

Pour résoudre cette vulnérabilité, la connexion au site engendre une session et une variable session comprenant le role de l'utilisateur est retenue.
Si l'utilsiateur n'es pas un administrateur ou n'a pas de role, il est automatiquement éconduit.

session_start();  (ligne 2, idnex.php, lancement et récupération de session.)

 
 _SESSION['role'] = htmlspecialchars($user['role']);   (ligne36, login.php, enregistrement de la variable role)

 
if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'user'; 
}

if ($_SESSION['role'] == 'admin') {
    echo "<h1Bienvenue, administrateur!</h1 >";
    echo "<p>Voici les outils d'administration.</p>";
} else {
    echo "<script>
    alert('Accès refusé. Vous n\'avez pas les droits nécessaires pour accéder à cette page.');
    window.location.href = 'index.php';
  </script>";

}
(ligne 7 a 20, admin.php,  vérification de la variable role et applciation des actes en conséquences)



4-modification des variables url


Le panier, une foid validé, passe son prix total par un url, cependant cet url étant visible,il peut aussi être modifié aisément, permettant d'applique le prix que l'on souhaite.

Afin d'empecher ceci, le prix total est caché et passé en variable hidden, il n'es donc plus possible de modifier l'ur.

// Ajouter un champ caché pour le total
  const hiddenInputTotal = document.createElement('input');
  hiddenInputTotal.type = 'hidden';
  hiddenInputTotal.name = 'total';
  hiddenInputTotal.value = total.toFixed(2);
  form.appendChild(hiddenInputTotal);

  // Ajouter un bouton de soumission
  const submitButton = document.createElement('button');
  submitButton.type = 'submit';
  submitButton.className = 'btn btn-primary';
  submitButton.innerText = 'Checkout';
  form.appendChild(submitButton);


  (lignes 86 - 98 , cart.js)



  5-absent.

Suite à un défaut de temps, une 5éme vulnérabilité n'a pu être implémenté et démontré a temps.
le plan initial consistait a utiliser une falsification de demande intersite(CSRF), en créant un faux formulaire externe pour démontrer comment un utilisateur connecté a un site peux malgrè lui entreprendre une action en cliquant sur un lien ou un site frauduleux extérieur qui le renverrai vers le site normal mais en ayant valisé un achat ou une action quelconque avec a propre session.




