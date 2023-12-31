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
// FAIT PAR PAUL LE GOAT
class FormulaireData
{
    private BOOL $formSubmitted = false;
    private $data = [];

    public function __construct()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $this->data = [
                'firstname' => $_POST["firstname"],
                'lastname' => $_POST["lastname"],
                'password' => $_POST["password"],
                'email' => $_POST["email"],
                'phone' => $_POST["phone"],
                'birthday' => $_POST["birthday"],
                'description' => $_POST["description"]
            ];

            $this->VerificationFormulairePlein();
        }
    }

    public function VerificationFormulairePlein()
    {
        if ($this->FiltreFormulaire()) {
            $this->formSubmitted = $this->insertData();
        } else {
            echo '<div class="error-message message">Veuillez remplir correctement tous les champs du formulaire.</div>';
        }
    }

    public function FiltreFormulaire()
    {
        foreach ($this->data as $key => $value) {
            if (empty($value)) {
                return false;
            }
            $this->data[$key] = trim($value);
            $this->data[$key] = filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            if (empty($this->data[$key])) {
                return false;
            }
        }
        return true;
    }

    public function insertData()
    {
        $servername = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbname = "Php_Secure_Paul";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $checkStmt = $conn->prepare("SELECT * FROM formulaire_data WHERE email = ?");
            $checkStmt->execute([$this->data['email']]);
            $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

            if ($checkResult) {
                echo '<div class="error-message message">L\'email est déjà utilisé</div>';
            } else {
                $insertStmt = $conn->prepare("INSERT INTO formulaire_data (firstname, lastname, password, email, phone, birthday, description) VALUES (:firstname, :lastname, :password, :email, :phone, :birthday, :description)");                $insertStmt->bindParam(':firstname', $this->data['firstname']);
                
                $insertStmt->bindParam(':firstname', $this->data['firstname'], PDO::PARAM_STR);
                $insertStmt->bindParam(':lastname', $this->data['lastname'], PDO::PARAM_STR);
                $insertStmt->bindParam(':password', $this->data['password'], PDO::PARAM_STR);
                $insertStmt->bindParam(':email', $this->data['email'], PDO::PARAM_STR);
                $insertStmt->bindParam(':phone', $this->data['phone'], PDO::PARAM_STR);
                $insertStmt->bindParam(':birthday', $this->data['birthday'], PDO::PARAM_STR);
                $insertStmt->bindParam(':description', $this->data['description'], PDO::PARAM_STR);
            
                $insertStmt->execute();
            }
        } catch (PDOException $e) {
            echo '<div class="error-message message">Erreur de connexion à la base de données: ' . $e->getMessage() . '</div>';
        } finally {
            $conn = null;
        }

        return false;
    }

    public function displaySuccessMessage()
    {
        if ($this->formSubmitted) {
            echo '<div class="success-message message">Informations soumises avec succès !</div>';
        }
    }

    public function displaySubmittedData()
    {
        if ($this->formSubmitted) {
            echo '<div class="submitted-data">';
            echo '<h2>Données soumises :</h2>';
            foreach ($this->data as $key => $value) {
                echo "<p>$key : $value</p>";
            }
            echo '</div>';
        }
    }
}

$FormulaireData = new FormulaireData();

?>

    <form id="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <h2>Formulaire</h2>

        <div class="form-control">
            <label for="firstname">Prénom:</label>
            <input type="text" name="firstname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un prénom valide" required>
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="lastname">Nom:</label>
            <input type="text" name="lastname" pattern="[A-Za-zÀ-ÖØ-öø-ÿ\s]+" title="Veuillez entrer un nom valide" required>
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="password">Mot de passe:</label>
            <input type="password" name="password" pattern=".{5,}" title="Le mot de passe doit contenir au moins 8 caractères" required>
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="email">Email:</label>
            <input type="email" name="email" required>
            <small>Error message</small>
        </div>


        <div class="form-control">
            <label for="phone">Numéro de téléphone:</label>
            <input type="tel" name="phone" pattern="[0-9]{10}" title="Veuillez entrer un numéro de téléphone valide" required>
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="birthday">Date de naissance:</label>
            <input type="date" name="birthday" required>
            <small>Error message</small>
        </div>

        <div class="form-control">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" cols="50" required></textarea>
            <small>Error message</small>
        </div>

        <input type="submit" value="Soumettre">

    </form>

    <?php
    $FormulaireData->displaySuccessMessage();
    $FormulaireData->displaySubmittedData();
    ?>


</body>

</html>