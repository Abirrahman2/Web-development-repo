<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "bookborrow"; 

if (isset($_POST['id'])) {
    $bookId = intval($_GET['id']); 


    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $sql = "SELECT * FROM bookdetails WHERE bid = $bookId";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $book = mysqli_fetch_assoc($result); 
    } else {
        echo "<p style='color: red;'>Book not found!</p>";
        exit;
    }

    mysqli_close($conn);
} else {
    echo "<p style='color: red;'>Invalid request! No book ID provided.</p>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $updatedName = trim($_POST['book-name']);
    $updatedAuthor = trim($_POST['author-name']);
    $updatedIsbn = trim($_POST['isbn']);
    $updatedPDate = $_POST['published-date'];
    $updatedPrice = trim($_POST['price']);
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "UPDATE bookdetails SET 
                bname = '$updatedName', 
                aname = '$updatedAuthor', 
                isbn = '$updatedIsbn', 
                pdate = '$updatedPDate', 
                price = '$updatedPrice' 
            WHERE bid = $bookId";

    if (mysqli_query($conn, $sql)) {
        echo "<p style='color: green;'>Book details updated successfully</p>";
        echo "<a href='index.php' style='color: blue;'>Go back to home</a>";
    } else {
        echo "<p style='color: red;'>Error updating book: " . mysqli_error($conn) . "</p>";
    }

    mysqli_close($conn);

    exit; 
}
?>