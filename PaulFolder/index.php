<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire en PHP</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php
    $formSubmitted = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = [
            'firstname' => $_POST["firstname"],
            'lastname' => $_POST["lastname"],
            'password' => $_POST["password"],
            'email' => $_POST["email"],
            'phone' => $_POST["phone"],
            'birthday' => $_POST["birthday"],
            'description' => $_POST["description"]
        ];

        // Validation des données du formulaire
        if (validateFormData($data)) {
            // Insertion des données dans la base de données
            $formSubmitted = insertData($data);
        } else {
            echo '<div class="error-message message">Veuillez remplir correctement tous les champs du formulaire.</div>';
        }
    }

function validateFormData($data) {
    // Validation de chaque champ
    foreach ($data as $value) {
        if (empty($value)) {
            return false;
        }
        $value = trim($value);
        $value = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (empty($value)) {
            return false;
        }
    }
    return true;
}

    function insertData($data)
    {
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "Php_Secure_Paul";

        try {
            // Connexion à la base de données
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Vérification si l'email existe déjà
            $checkStmt = $conn->prepare("SELECT * FROM formulaire_data WHERE email = ?");
            $checkStmt->execute([$data['email']]);
            $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($checkResult) {
                echo '<div class="error-message message">L\'email est déjà utilisé</div>';
            } else {
                // Insertion des données dans la base de données
                $insertStmt = $conn->prepare("INSERT INTO formulaire_data (firstname, lastname, password, email, phone, birthday, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $insertStmt->execute([$data['firstname'], $data['lastname'], $data['password'], $data['email'], $data['phone'], $data['birthday'], $data['description']]);
                return true;
            }
        } catch (PDOException $e) {
            echo '<div class="error-message message">Erreur de connexion à la base de données: ' . $e->getMessage() . '</div>';
        } finally {
            // Fermeture de la connexion
            $conn = null;
        }

        return false;
    }
    ?>

<form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Formulaire</h2>

        <div class="form-control">
            <label for="firstname">Prénom:</label>
            <input type="text" name="firstname" id="firstname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un prénom valide">
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="lastname">Nom:</label>
            <input type="text" name="lastname" id="lastname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un nom valide">
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" id="password" pattern=".{5,}" title="Le mot de passe doit contenir au moins 8 caractères">
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email">
            <small>Error message</small>
        </div>


        <div class="form-control">
            <label for="phone">Numéro de téléphone:</label>
            <input type="tel" name="phone" id="phone" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide">
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="birthday">Date de naissance:</label>
            <input type="date" name="birthday" id="birthday">
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="description">Description:</label>
            <textarea id="description" name="description" id="description" rows="4" cols="50"></textarea>
            <small>Error message</small>
        </div>

        <input type="submit" value="Soumettre">

        <?php
        // Affichage du message de succès
        if ($formSubmitted) {
            echo '<div class="success-message message">Informations soumises avec succès !</div>';
        }
        ?>

    </form>

    <?php
    // Affichage des données soumises
    if ($formSubmitted) {
        echo '<div class="submitted-data">';
        echo '<h2>Données soumises :</h2>';
        foreach ($data as $key => $value) {
            echo "<p>$key : $value</p>";
        }
        echo '</div>';
    }
    ?>

</body>
<script src="validation-form.js"></script>

</html>