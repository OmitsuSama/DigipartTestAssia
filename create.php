<?php
// Connexion à la bdd
include 'db_connection.php'; 

// Variables
$reference = $description = $priceTaxIncl = $priceTaxExcl = $quantity = $idLang = "";
$referenceErr = $descriptionErr = $priceTaxInclErr = $priceTaxExclErr = $quantityErr = $idLangErr = "";
$langSelect = "SELECT languages.* FROM languages;";
$langSelect = $conn->query($langSelect);



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fonction de nettoyage des données
    function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    // Validation des données envoyés
    $reference = sanitizeInput($_POST["reference"]);
    $description = sanitizeInput($_POST["description"]);
    $priceTaxIncl = floatval($_POST["priceTaxIncl"]);
    $priceTaxExcl = floatval($_POST["priceTaxExcl"]);
    $quantity = intval($_POST["quantity"]);
    $idLang = intval($_POST["idLang"]);


    // Insertion des données si il n'y a pas d'erreur
    if (empty($referenceErr) && empty($descriptionErr) && empty($priceTaxInclErr) && empty($priceTaxExclErr) && empty($quantityErr) && empty($idLangErr)) {
        // Insertion dans la table product
        $sql = "INSERT INTO products (reference, description, priceTaxIncl, priceTaxExcl, quantity, idLang)
                VALUES ('$reference', '$description', '$priceTaxIncl', '$priceTaxExcl', '$quantity', '$idLang')";

        if ($conn->query($sql) === TRUE) {
            echo "New product added successfully!";
            header("Location: index.php");
            exit;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
<!-- Formulaire HTML -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <div>
        <label class="form-label" for="reference">Reference:</label>
        <input class="form-control" type="text" name="reference" id="reference" required>
        <span class="error"><?php echo $referenceErr; ?></span>
    </div>
    

    <label class="form-label" for="description">Description:</label>
    <textarea class="form-control" name="description" id="description" required></textarea>
    <span class="error"><?php echo $descriptionErr; ?></span>
    <br>

    <label class="form-label" for="priceTaxIncl">Price (Tax Inclusive):</label>
    <input class="form-control" type="number" step="0.01" name="priceTaxIncl" id="priceTaxIncl" required>
    <span class="error"><?php echo $priceTaxInclErr; ?></span>
    <br>

    <label class="form-label" for="priceTaxExcl">Price (Tax Exclusive):</label>
    <input class="form-control" type="number" step="0.01" name="priceTaxExcl" id="priceTaxExcl" required>
    <span class="error"><?php echo $priceTaxExclErr; ?></span>
    <br>

    <label class="form-label" for="quantity">Quantity:</label>
    <input class="form-control" type="number" name="quantity" id="quantity" required>
    <span class="error"><?php echo $quantityErr; ?></span>
    <br>

    <label class="form-label" for="idLang">Language ID:</label>
    <select class="form-select" aria-label="Default select example" name="idLang">
        <option selected>Selectionner la langue</option>
        <?php
            foreach ($langSelect as $lang) {
                echo '<option value="'.$lang["idLang"].'">'.$lang["languages"].' '.$lang["codeISO"].'</option>';
            }
        ?>
    </select>
    <span class="error"><?php echo $idLangErr; ?></span>
    <br>

    <input type="submit" class="btn btn-primary" value="Add Product">
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
