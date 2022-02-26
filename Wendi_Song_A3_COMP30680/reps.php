<!--PHP Mysqli code reference from w3school-->
<?php
require "config.php";
include "header.php";
?>
<div class="main">
    <h2>Sales Reps Information</h2>
    <br>
    <?php
    $sql = "SELECT Distinct E1.employeeNumber, E1.firstname, E1.lastname, E1.email, O.addressLine1, O.addressLine2,O.state,O.country, E2.firstname as ManagerFirst, E2.lastname as ManagerLast
FROM classicmodels.customers C, classicmodels.employees E1, classicmodels.employees E2, classicmodels.offices O 
WHERE E1.officeCode=O.officeCode and E1.reportsTo = E2.employeeNumber and E1.employeeNumber = C.salesRepEmployeeNumber";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>First Name</th><th>Last Name</th><th>More Information</th><th>Email</th><th>Office Address Line1</th><th>Office Address Line2</th><th>State</th><th>Country</th><th>Sales Manager First Name</th><th>Sales Manager First Name</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["firstname"] . "</td><td>" . $row["lastname"] . "</td><td><a href='repsinformation.php?id=" . $row["employeeNumber"] . "' class = 'button' >More Information</a></td><td>" . $row["email"] . "</td><td>" . $row["addressLine1"] . "</td><td>" . $row["addressLine2"] . "</td><td>" . $row["state"] . "</td><td>" . $row["country"] . "</td><td>" . $row["ManagerFirst"] . "</td><td>" . $row["ManagerLast"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results about products";
    }
    $conn->close();
    ?>
</div>
<?php
include "footer.php";
?>