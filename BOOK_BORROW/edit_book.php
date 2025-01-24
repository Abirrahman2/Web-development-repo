<?php

if (isset($_GET['bid'])) {
    $bid = intval($_GET['bid']); 

    $conn = mysqli_connect("localhost", "root", "", "bookborrow");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }


    $sql = "SELECT * FROM bookdetails WHERE bid = $bid";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $book = mysqli_fetch_assoc($result);
    } else {
        echo "<p style='color: red; text-align: center;'>Book not found!</p>";
        exit;
    }

    mysqli_close($conn); 
} else {
    echo "<p style='color: red; text-align: center;'>Invalid request! No Book ID provided.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2 style="text-align: center;">Edit Book Details</h2>
    <form action="update_book.php" method="POST" style="width: 50%; margin: 0 auto; border: 1px solid #ccc; padding: 20px; border-radius: 10px;">

        <input type="hidden" name="bid" value="<?php echo htmlspecialchars($bid); ?>">

        <div class="form-group">
            <label for="book-name">Book Name:</label>
            <input type="text" name="book-name" id="book-name" value="<?php echo htmlspecialchars($book['bname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="author-name">Author Name:</label>
            <input type="text" name="author-name" id="author-name" value="<?php echo htmlspecialchars($book['aname']); ?>" required>
        </div>
        <div class="form-group">
            <label for="isbn">ISBN:</label>
            <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
        </div>
        <div class="form-group">
            <label for="published-date">Published Date:</label>
            <input type="date" name="published-date" id="published-date" value="<?php echo htmlspecialchars($book['pdate']); ?>" required>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" name="price" id="price" value="<?php echo htmlspecialchars($book['price']); ?>" required>
        </div>
        <div class="form-group" style="text-align: center;">
            <input type="submit" value="Update Book" style="padding: 10px 20px; background-color: green; color: white; border: none; border-radius: 5px; cursor: pointer;">
        </div>
    </form>
</body>
</html>
