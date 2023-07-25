<?php
// Connexion Bdd
include 'db_connection.php'; 

// Variable
$productId = $updatedReference = $updatedDescription = $updatedPriceTaxIncl = $updatedPriceTaxExcl = $updatedQuantity = $updatedIdLang = "";
$referenceErr = $descriptionErr = $priceTaxInclErr = $priceTaxExclErr = $quantityErr = $idLangErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $productId = intval($_POST["productId"]);
    $updatedReference = sanitizeInput($_POST["updatedReference"]);
    $updatedDescription = sanitizeInput($_POST["updatedDescription"]);
    $updatedPriceTaxIncl = floatval($_POST["updatedPriceTaxIncl"]);
    $updatedPriceTaxExcl = floatval($_POST["updatedPriceTaxExcl"]);
    $updatedQuantity = intval($_POST["updatedQuantity"]);

    // Update si il n'y a pas d'erreur
    if (empty($referenceErr) && empty($descriptionErr) && empty($priceTaxInclErr) && empty($priceTaxExclErr) && empty($quantityErr) && empty($idLangErr)) {
        // Update des données
        $sql = "UPDATE products
                SET reference = '$updatedReference', description = '$updatedDescription', 
                priceTaxIncl = '$updatedPriceTaxIncl', priceTaxExcl = '$updatedPriceTaxExcl',
                quantity = '$updatedQuantity'
                WHERE idProduct = '$productId'";

        if ($conn->query($sql) === TRUE) {
            echo "Product updated successfully!";
        } else {
            echo "Error updating product: " . $conn->error;
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
<!-- Formulaire -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="productId">Product ID:</label>
    <input type="number" name="productId" id="productId" required>
    <input type="submit" value="Get Product Details">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($productId)) {
    $sql = "SELECT * FROM products WHERE idProduct = '$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $updatedReference = $row["reference"];
        $updatedDescription = $row["description"];
        $updatedPriceTaxIncl = $row["priceTaxIncl"];
        $updatedPriceTaxExcl = $row["priceTaxExcl"];
        $updatedQuantity = $row["quantity"];

        echo "<h2>Update Product</h2>";
        echo "<form method=\"post\" action=\"" . htmlspecialchars($_SERVER["PHP_SELF"]) . "\">";
        echo "<input type=\"hidden\" name=\"productId\" value=\"" . $productId . "\">";

        echo "<label class=\"form-label\" for=\"updatedReference\">Reference:</label>";
        echo "<input class=\"form-control\" type=\"text\" name=\"updatedReference\" id=\"updatedReference\" value=\"" . $updatedReference . "\" required>";
        echo "<span class=\"error\">" . $referenceErr . "</span>";
        echo "<br>";

        echo "<label class=\"form-label\" for=\"updatedDescription\">Description:</label>";
        echo "<textarea class=\"form-control\" name=\"updatedDescription\" id=\"updatedDescription\" required>" . $updatedDescription . "</textarea>";
        echo "<span class=\"error\">" . $descriptionErr . "</span>";
        echo "<br>";

        echo "<label class=\"form-label\" for=\"updatedPriceTaxIncl\">Price (Tax Inclusive):</label>";
        echo "<input class=\"form-control\" type=\"number\" step=\"0.01\" name=\"updatedPriceTaxIncl\" id=\"updatedPriceTaxIncl\" value=\"" . $updatedPriceTaxIncl . "\" required>";
        echo "<span class=\"error\">" . $priceTaxInclErr . "</span>";
        echo "<br>";

        echo "<label class=\"form-label\" for=\"updatedPriceTaxExcl\">Price (Tax Exclusive):</label>";
        echo "<input class=\"form-control\" type=\"number\" step=\"0.01\" name=\"updatedPriceTaxExcl\" id=\"updatedPriceTaxExcl\" value=\"" . $updatedPriceTaxExcl . "\" required>";
        echo "<span class=\"error\">" . $priceTaxExclErr . "</span>";
        echo "<br>";

        echo "<label class=\"form-label\" for=\"updatedQuantity\">Quantity:</label>";
        echo "<input class=\"form-control\" type=\"number\" name=\"updatedQuantity\" id=\"updatedQuantity\" value=\"" . $updatedQuantity . "\" required>";
        echo "<span class=\"error\">" . $quantityErr . "</span>";
        echo "<br>";

        echo "<input type=\"submit\" value=\"Update Product\">";
        echo "</form>";
    } else {
        echo "Product not found.";
    }
}
?>
</form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
