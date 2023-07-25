<?php
// Connexion BDD
include 'db_connection.php'; 

$productId = "";
$productIdErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function sanitizeInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $productId = intval($_POST["productId"]);


    if (empty($productIdErr)) {
        // Delete du produit
        $sql = "DELETE FROM products WHERE idProduct = '$productId'";

        if ($conn->query($sql) === TRUE) {
            echo "Product deleted successfully!";
            header("Location: index.php");
            exit;
        } else {
            echo "Error deleting product: " . $conn->error;
        }
    }
}
?>

<!--Formulaire -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <label for="productId">Product ID:</label>
    <input type="number" name="productId" id="productId" required>
    <input type="submit" value="Delete Product">
</form>
