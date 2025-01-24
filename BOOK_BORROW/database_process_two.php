<?php
  $searchBook= trim($_POST['search-book']); 
  $searchBookTwo = strtolower(str_replace(' ', '', $searchBook));
  $track=false;
  $errors=[];
  if (empty($searchBookTwo)) {
    
    $track=true;
    $errors[]="PLEASE ENTER A BOOK NAME";
}
if( $track==true)
{
    echo "<div style='border: 2px solid red; background-color: rgb(223, 212, 212); padding: 10px; margin-bottom: 10px; text-align: center;'>";
        echo "<h2 style='color: red; margin: 0;'>INVALID SEARCH</h2>";
        echo "</div>";
        echo "<ul style='list-style-type: none; border: 2px solid red; background-color: rgb(255, 245, 245); padding: 15px; margin: 0; border-radius: 10px;'>";
           foreach ($errors as $val)
            {
                 echo "<li style='color: red; font-weight: bold; margin-bottom: 10px;'>";
                 echo "&#x26A0; $val"; 
                 echo "</li>";
            }
         echo "</ul>";
}
else{
    $conn=mysqli_connect("localhost","root","","bookborrow");
if($conn==false)
{
    die("ERROR".mysqli_connect_error());
}
$sql="SELECT * FROM bookdetails WHERE LOWER(REPLACE(TRIM(bname),' ','')) = '$searchBookTwo'";
$result=mysqli_query($conn,$sql);

/*if (mysqli_num_rows($result) > 0) {
    echo "<div style='border: 2px solid green; padding: 10px; margin: 10px;'>";
    echo "<h3 style='color: green;'>BOOK FOUND</h3>";
    echo "<ul style='list-style-type: none; padding: 0;'>";

    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li style='border: 1px solid black; padding: 10px; margin: 5px;'>";
        echo "<strong>Book Name:</strong> " . htmlspecialchars($row['bname']) . "<br>";
        echo "<strong>Author Name:</strong> " . htmlspecialchars($row['aname']) . "<br>";
        echo "<strong>ISBN:</strong> " . htmlspecialchars($row['isbn']) . "<br>";
        echo "<strong>Published Date:</strong> " . htmlspecialchars($row['pdate']) . "<br>";
        echo "<strong>Price:</strong>" . htmlspecialchars($row['price']) . " Tk<br>";
        echo "</li>";
    }

    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='border: 2px solid red; padding: 10px; margin: 10px;'>";
    echo "<p style='color: red;'>GIVEN BOOK <strong>" . htmlspecialchars($searchBook) . "</strong> IS NOT FOUND.</p>";
    echo "</div>";
}*/
if (mysqli_num_rows($result) > 0) {
    echo "<div style='border: 2px solid green; padding: 10px; margin: 10px;'>";
    echo "<h3 style='color: green;'>BOOK FOUND:</h3>";
    echo "<table border='1' style='width: 100%; text-align: center; border-collapse: collapse;'>";
    echo "<thead>";
    echo "<tr style='background-color: #f2f2f2;'>";
    echo "<th>Book Name</th>";
    echo "<th>Author Name</th>";
    echo "<th>ISBN</th>";
    echo "<th>Published Date</th>";
    echo "<th>Price</th>";
    echo "<th>OPERATIONS</th>"; 
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['bname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['aname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
        echo "<td>" . htmlspecialchars($row['pdate']) . "</td>";
        echo "<td>$" . htmlspecialchars($row['price']) . "</td>";
        echo "<td style='display: flex; justify-content: center; gap: 10px;'>";

        
        echo "<form action='edit_book.php' method='GET' style='display: inline;'>";
        echo "<input type='hidden' name='bid' value='" . htmlspecialchars($row['bid']) . "'>";
        echo "<button type='submit' style='background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;'>EDIT</button>";
        echo "</form>";

     
        echo "<form action='delete_book.php' method='POST' style='display: inline;' onsubmit='return confirm(\"Are you sure you want to delete this book?\");'>";
        echo "<input type='hidden' name='bid' value='" . htmlspecialchars($row['bid']) . "'>";
        echo "<button type='submit' style='background-color: #F44336; color: white; padding: 5px 10px; border: none; border-radius: 5px; cursor: pointer;'>DELETE</button>";
        echo "</form>";

        echo "</td>";
        echo "</tr>";
    }


    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<div style='border: 2px solid red; padding: 10px; margin: 10px;'>";
    echo "<p style='color: red;'>No matching books found for: <strong>" . htmlspecialchars($searchBook) . "</strong>.</p>";
    echo "</div>";
}


}

?>