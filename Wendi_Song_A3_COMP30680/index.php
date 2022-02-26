<!--PHP Mysqli code reference from w3school-->
<?php
require "config.php";
include "header.php";
?>
<div class="main">
    <h1>Product Information</h1>
    <br>
    <p>You can only choose one option each time!</p>
    <br>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p>Option 1: Filter by product line, you can choose one or more product lines to display.</p>
        <?php
        $sql1 = "SELECT productLine FROM productlines";
        $result1 = $conn->query($sql1);
        if ($result1->num_rows > 0) {
            // output data of each row
            while ($row1 = $result1->fetch_assoc()) {
                echo "<input type='checkbox' name='productlines[]' value='" . $row1["productLine"] . "'>" . $row1["productLine"] . "&nbsp;&nbsp;&nbsp;&nbsp;";
            }
        } else {
            echo "No check box display";
        }
        ?>
        <input type="submit" name="submit" value="Submit">
        <br><br>
        <p>Option 2: Sort by Quantity In Stock:</p>
        <input type="radio" name="sort" value="increasing">Increasing&nbsp;&nbsp;
        <input type="radio" name="sort" value="decreasing">Decreasing
        <input type="submit" name="submit" value="Submit">
        <br><br>
        <p>Option 3: Filter products to only show those with less than an specified amount in stock.</p>
        Enter a Number of Stock Amounts Less Than: <input type="number" name="number">
        <input type="submit" name="submit" value="Submit">
    </form>
    <br><br>
    <?php
    // define variables and set to empty values
    $sort = $number = "";
    $productlines = [];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["sort"]) && empty($_POST["productlines"]) && empty($_POST["number"])) {
            echo "<p style='background-color:rgb(234, 229, 240); text-align:center'>You should not submit empty value.</p>";
        } else {
            $sort = ($_POST["sort"]);
            $productlines = ($_POST["productlines"]);
            $number = ($_POST["number"]);
        }
    }
    // <!--PHP Mysqli code reference from w3school-->
    $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products";
    if (empty($productlines)) {
        $check_select_num = 0;
    } else {
        $check_select_num = count($productlines);
    }
    #ensure checkbox is selected onece at least
    if ($check_select_num > 0 && empty($sort) && empty($number)) {
        if ($check_select_num == 1) {
            $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products where productLine='" . $productlines[0] . "'";
        } elseif ($check_select_num > 1) {
            $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products where productLine='" . $productlines[0] . "' ";
            for ($i = 1; $i < $check_select_num; $i++) {
                $sql .= "or '" . $productlines[$i] . "' ";
            }
        }
    }

    if (empty($number) && $sort == "increasing" && empty($check_select_num)) {
        $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products order by quantityInStock asc";
    } else if (empty($number) && $sort == "decreasing" && empty($check_select_num)) {
        $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP FROM products order by quantityInStock desc";
    }

    if ($number > 0 && empty($sort) && empty($check_select_num)) {
        $sql = "SELECT productName, productCode, productDescription, quantityInStock, MSRP  FROM products WHERE quantityInStock < " . $number;
    }
    #check the user wether choose only choose one option
    if ((!empty($check_select_num) && !empty($sort)) || (!empty($check_select_num) && !empty($number)) || (!empty($sort) && !empty($number))) {
        echo "<p style='background-color:rgb(234, 229, 240); text-align:center'>You can choose only one option each time!</p>";
    }
    ?>
</div>
<br>
<?PHP
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table><tr><th>Name</th><th>Product Code</th><th>Product Description</th><th>Quantity In Stock</th><th>MSRP</th></tr>";
    // output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["productName"] . "</td><td>" . $row["productCode"] . "</td><td>" . $row["productDescription"] . "</td><td>" . $row["quantityInStock"] . "</td><td>" . $row["MSRP"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
$conn->close();
?>

<?php
include "footer.php";
?>