<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Digipart Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    <h2>Ecommerce App</h2>
    <h3>Product List</h3>
    <a href="create.php" class="btn btn-success">Ajouter un produit</a>
    <a class="btn btn-danger" href="delete.php"><i class="bi bi-trash-fill"></i></a>
    <a class="btn btn-primary" href="edit.php"><i class="bi bi-pencil-square"></i></a>
    <br>

    <div>
    <?php
        // Connexion à la bdd
        include 'db_connection.php'; 

        // Recupération des données
        $sql = "SELECT products.*, languages.codeISO FROM products JOIN languages ON products.idLang = languages.idLang";

        $result = $conn->query($sql);

        // Vérification d'existence de product à afficher
        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo "<tr>";
            echo '<th scope="col">ID</th>';
            echo '<th scope="col">Reference</th>';
            echo '<th scope="col">Description</th>';
            echo '<th scope="col">Price (Tax Inclusive)</th>';
            echo '<th scope="col">Price (Tax Exclusive)</th>';
            echo '<th scope="col">Quantity</th>';
            echo '<th scope="col">Language</th>';
            echo "</tr>";

            // Output data for each product
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo '<td scope="col">' . $row["idProduct"] . '</td>';
                echo "<td>" . $row["reference"] . "</td>";
                echo "<td>" . $row["description"] . "</td>";
                echo "<td>" . $row["priceTaxIncl"] . "</td>";
                echo "<td>" . $row["priceTaxExcl"] . "</td>";
                echo "<td>" . $row["quantity"] . "</td>";
                echo "<td>" . $row["codeISO"] . "</td>";

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No products found.";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>

