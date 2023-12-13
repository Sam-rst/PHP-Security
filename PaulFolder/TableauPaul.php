<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire en PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column; /* Mettez en colonne les éléments à l'intérieur du body */
            align-items: center;
            height: 100vh;
            margin-top: 20px;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px; /* Ajout d'une marge en bas pour espacer le formulaire de la section suivante */
            margin-top : 20px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 12px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            resize: vertical;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: #008000;
            font-weight: bold;
            text-align: center;
        }

        .error-message {
            color: #FF0000;
            font-weight: bold;
            text-align: center;
        }

        .submitted-data {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
    </style>
</head>
<body>

<?php
// Initialiser la variable d'état du formulaire
$formSubmitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $firstname = validateInput($_POST["firstname"]);
    $lastname = validateInput($_POST["lastname"]);
    $password = validateInput($_POST["password"]);
    $email = validateInput($_POST["email"]);
    $phone = validateInput($_POST["phone"]);
    $birthday = validateInput($_POST["birthday"]);
    $description = validateInput($_POST["description"]);

    // Connexion à la base de données (remplacez les valeurs par celles de votre configuration)
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "Php_Secure_Paul";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbname);

    // Vérifier la connexion à la base de données
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Vérifier si l'email existe déjà dans la base de données
    $checkStmt = $conn->prepare("SELECT * FROM formulaire_data WHERE email = ?");
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // L'email existe déjà, afficher un message d'erreur
        echo '<div class="error-message">L\'email est déjà utilisé</div>';
    } else {
        // L'email n'existe pas, procéder à l'insertion
        // Préparer la requête d'insertion
        $insertStmt = $conn->prepare("INSERT INTO formulaire_data (firstname, lastname, password, email, phone, birthday, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssssss", $firstname, $lastname, $password, $email, $phone, $birthday, $description);

        // Exécuter la requête d'insertion
        if ($insertStmt->execute()) {
            $formSubmitted = true;
        } else {
            // Afficher un message d'erreur si l'insertion échoue
            echo '<div class="error-message">Erreur lors de l\'insertion des données dans la base de données.</div>';
        }

        // Fermer le statement d'insertion
        $insertStmt->close();
    }

    // Fermer le statement de vérification
    $checkStmt->close();

    // Fermer la connexion
    $conn->close();
}

// Fonction pour valider les entrées
function validateInput($data) {
    // Échapper les caractères spéciaux pour éviter les attaques XSS
    $data = htmlspecialchars($data);
    // Nettoyer les espaces inutiles
    $data = trim($data);
    // Supprimer les antislashs pour éviter les attaques par injection
    $data = stripslashes($data);
    return $data;
}

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h2>Formulaire</h2>
    
    <!-- Champ pour le prénom -->
    <!-- Prénom (Firstname):
        pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+": Ce pattern autorise uniquement des lettres (majuscules et minuscules), des espaces et des caractères accentués pour le prénom. -->
    <label for="firstname">Prénom:</label>
    <input type="text" name="firstname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un prénom valide" required>


    <!-- Champ pour le nom -->
    <!-- Nom (Lastname):
        pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+": Semblable au prénom, ce pattern autorise uniquement des lettres (majuscules et minuscules), des espaces et des caractères accentués pour le nom. -->
    <label for="lastname">Nom:</label>
    <input type="text" name="lastname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un nom valide" required>


    <!-- Champ pour le mot de passe -->
    <!-- Mot de passe (Password):
        pattern=".{8,}": Ce pattern spécifie que le mot de passe doit contenir au moins 8 caractères. -->
    <label for="password">Mot de passe:</label>
    <input type="password" name="password" pattern=".{5,}" title="Le mot de passe doit contenir au moins 8 caractères" required>


    <!-- Champ pour l'email -->
    <label for="email">Email:</label>
    <input type="email" name="email" required>


    <!-- Champ pour le numéro de téléphone -->
    <!-- Numéro de téléphone (Phone):
        type="tel": Utilisation du type d'entrée téléphone pour indiquer que le champ doit contenir un numéro de téléphone.
        pattern="[0-9]{10}": Ce pattern spécifie que le numéro de téléphone doit contenir exactement 10 chiffres. -->
    <label for="phone">Numéro de téléphone:</label>
    <input type="tel" name="phone" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide" required>

    <!-- Champ pour la date de naissance -->
    <label for="birthday">Date de naissance:</label>
    <input type="date" name="birthday" required>

    <!-- Champ pour la description -->
    <label for="description">Description:</label>
    <textarea name="description" rows="4" cols="50" required></textarea>

    <!-- Bouton de soumission du formulaire -->
    <input type="submit" value="Soumettre">
    
    <?php
    // Afficher le message de succès ou d'erreur en fonction de l'état du formulaire
    // Afficher le message de succès ou d'erreur en fonction de l'état du formulaire
    if ($formSubmitted) {
        echo '<div class="success-message">Informations soumises avec succès !</div>';
    } elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
        echo '<div class="error-message">Veuillez remplir le formulaire.</div>';
    }





    ?>
</form>

<!-- Section pour afficher les données soumises -->
<?php
if ($formSubmitted) {
    echo '<div class="submitted-data">';
    echo '<h2>Données soumises :</h2>';
    echo "<p>Prénom : $firstname</p>";
    echo "<p>Nom : $lastname</p>";
    echo "<p>Mot de passe : $password</p>";
    echo "<p>Email : $email</p>";
    echo "<p>Téléphone : $phone</p>";
    echo "<p>Date de naissance : $birthday</p>";
    echo "<p>Description : $description</p>";
    echo '</div>';
} else {}
    ?>


</body>
</html>


