<?php
require "config.php";
include "header.php";
?>
<div class="title">
    <br>
    <h2>Customer Information of the Sales Rep</h2>
    <br>
    <?php
    $num = ($_GET["id"]);
    $sql1 = "SELECT E.firstname,E.lastname, Sum(quantityOrdered*priceEach) as sales
FROM classicmodels.orders O, classicmodels.customers C,classicmodels.orderdetails OD,classicmodels.employees E
WHERE C.salesRepEmployeeNumber='" . $num . "' and C.customerNumber = O.customerNumber and O.orderNumber = OD.orderNumber and C.salesRepEmployeeNumber = E.employeeNumber
";
    $result1 = $conn->query($sql1);
    if ($result1->num_rows > 0) {
        while ($row = $result1->fetch_assoc()) {
            echo "<p>Sales Rep Name:&nbsp;" . $row["firstname"] . "&nbsp;" . $row["lastname"] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Sales of the Rep&nbsp;" . $row["sales"] . "</p>";
        }
    } else {
        echo "0 results about sales rep name and the total sales value by the rep";
    }
    ?>
</div>
<br>
<!-- overflow reference from w3school -->
<div class="table" style="overflow-x: auto;">
    <?php
    $sql = "SELECT C.customerNumber, C.customerName, C.addressLine1, C.addressLine2,C.city,C.state, C.country,C.creditLimit, Sum(distinct P.amount) as totalpayments,group_concat( distinct O.orderNumber Order by O.orderNumber asc separator ',') as ordernumber
FROM classicmodels.customers C, classicmodels.payments P, classicmodels.orders O
WHERE C.salesRepEmployeeNumber='" . $num . "' and C.customerNumber=P.customerNumber and  C.customerNumber=O.customerNumber
group by C.customerNumber";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "<table><tr><th>Customer Name</th><th>Address Line1</th><th>Address Line2</th><th>City</th><th>State</th><th>Country</th><th>Credit Limits</th><th>Total Payments</th><th>Order Number</th></tr>";
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row["customerName"] . "</td><td>" . $row["addressLine1"] . "</td><td>" . $row["addressLine2"] . "</td><td>" . $row["city"] . "</td><td>" . $row["state"] . "</td><td>" . $row["country"] . "</td><td>" . $row["creditLimit"] . "</td><td>" . $row["totalpayments"] . "</td><td max-width='100px'>" . $row["ordernumber"] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "0 results about a list of customers that the sales rep works";
    }
    $conn->close();
    ?>
</div>
<?php
include "footer.php";
?>