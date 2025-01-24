<?php
  $bookName = trim($_POST['book-add']);
  $authorName = trim($_POST['author-name']);
  $isbn = trim($_POST['isbn']);
  $publishedDate = trim($_POST['published-date']);
  $bookPrice = trim($_POST['book-price']);
  $errors = [];
  $track=false;
  if (empty($bookName)) {
    $track=true;
    $errors[] = "PLEASE ENTER VALID BOOK NAME";
}

if (empty($authorName)) {
    $track=true;
    $errors[] = "PLEASE ENTER AUTHOR NAME";
}

if (empty($isbn)) {
    $track=true;
    $errors[] = "PLEASE ENTER ISBN OF THIS BOOK";
} elseif (!preg_match("/^\d{13}$/", $isbn)) {
    $track=true;
    $errors[] = "ISBN DID NOT MAINTAIN THE FORMATION.PLEASE PROVIDE ISBN NOT MORE THAN 13 DIGITS";
}

if (empty($publishedDate)) {
    $track=true;
    $errors[] = "PLEASE PROVIDE PUBLISHED DATE OF THIS BOOK";
} 

if (empty($bookPrice)) {
    $track=true;
    $errors[] = "PLEASE ENTER THE PRICE OF THIS BOOK";
} elseif (!is_numeric($bookPrice) || $bookPrice <= 0) {
    $track=true;
    $errors[] ="BOOK PRICE IS NOT IN VALID FORM";
}

if( $track==true)
{
    echo "<div style='border: 2px solid red; background-color: rgb(223, 212, 212); padding: 10px; margin-bottom: 10px; text-align: center;'>";
        echo "<h2 style='color: red; margin: 0;'>INVALID SUBMISSION</h2>";
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
$sql="INSERT INTO bookdetails (bname,aname,isbn,pdate,price) VALUES ('$bookName', '$authorName', '$isbn', '$publishedDate', '$bookPrice')";
$result=mysqli_query($conn,$sql);

if($result)
{
    echo "<div style='border: 2px solid green; padding: 10px; margin: 10px;'>";
        echo "<p style='color: green;'>ALL THE INFORMATION ADDED IN DATABASE SUCCESSFULLY</p>";
        echo "</div>";
}
else{
    echo "<div style='border: 2px solid red; padding: 10px; margin: 10px;'>";
        echo "<p style='color: red;'>Error: " . mysqli_error($conn) . "</p>";
        echo "</div>";
}

}

?>