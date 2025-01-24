<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Borrow Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <section class="container">
        
        <div class="leftcolumn">
        <label>USED TOKENS:</label>
        <ul>
                <?php
                $transfer_file1 = 'token_info.json';
                $tokens = []; 
                
                
                if (file_exists($transfer_file1)) {
                   
                    $jsondata = file_get_contents($transfer_file1);
                    $tokenUsed = json_decode($jsondata, true);  
                    
                    if (isset($tokenUsed['token_used']) && is_array($tokenUsed['token_used'])) {
                        $tokens = $tokenUsed['token_used'];  
                    }
                }
                
                if (!empty($tokens)) {
                    foreach ($tokens as $token) {
                        echo "<li>{$token}</li>";
                    }
                } else {
                    echo "<li>No tokens used yet.</li>";
                }
                ?>
            </ul>
           
        </div>

        <div class="middle">
            <div class="top">
                <div class="box1">
                 <div class="form_second">
                    <form action="database_process.php" method="POST">
                        <div class="form-group">
                        <label for="book-add">ENTER BOOK NAME </label>
                        <input type="text" name="book-add"  id="book-add">

                        </div>
                        <div class="form-group">
                        <label for="author-name">AUTHOR NAME </label>
                        <input type="text" name="author-name" id="author-name">

                        </div>
                        <div class="form-group">
                        <label for="isbn">ISBN</label>
                        <input type="text" name="isbn" id="isbn">



                        </div>
                        <div class="form-group">
                            <label for="published-date">Published Date:</label>
                           <input type="date" name="published-date" id="published-date">
                        </div>
                        <div class="form-group">
                        <label for="book-price">PRICE</label>
                        <input type="text" name="book-price" id="book-price">

                        </div>
                        
                        <div class="form-group">
                            <input type="submit" name= "submit" value="Submit" class="sbt">
                        </div>
                    </form>

                  </div>
            


            

                </div>
                <div class="box1">
                <form action="database_process_two.php" method="POST">
                    <div class="form-group">
                    <label for="search-book">SEARCH A BOOK</label>
                    <input type="text" name="search-book"  id="search-book">

                    </div>
                       
                        
                        <div class="form-group">
                            <input type="submit" name= "submit" value="SEARCH" class="sbt">
                        </div>
                    </form>
                
                  
                </div>
                <div class="box1">
                  <h3 style="text-align: center; color: rgb(17, 15, 15);">AVAILABLE BOOKS</h3>
                  <?php
   
                    $conn=mysqli_connect("localhost","root","","bookborrow");

    
                  if ($conn==false)
                    {
                        die("Connection failed: " . mysqli_connect_error());
                    }

    
                   $sql = "SELECT * FROM bookdetails";
                   $result = mysqli_query($conn, $sql);

    
    if (mysqli_num_rows($result) > 0) 
    {
        echo "<table border='1' style='width: 100%; text-align: center; border-collapse: collapse;'>";
        echo "<thead>";
        echo "<tr style='background-color: #f2f2f2;'>";
        echo "<th>BOOK NAME</th>";
        echo "<th>AUTHOR NAME</th>";
        echo "<th>ISBN</th>";
        echo "<th>PUBLISHED DATE</th>";
        echo "<th>PRICE</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

       
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['bname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['aname']) . "</td>";
            echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
            echo "<td>" . htmlspecialchars($row['pdate']) . "</td>";
            echo "<td>" . htmlspecialchars($row['price']) . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } 
    else 
    {
       
        echo "<p style='text-align: center; color: red;'>NO AVAILABLE BOOKS ARE PRESENT.</p>";
    }

   
    ?>



     </div>
    </div>

            <div class="middlethree">
                <div class="box2">


                <img src="images/image1.jfif" alt="NEURAL NETWORK" style="width: 100%; height: auto;">
                 <p style="text-align: center;">NEURAL NETWORK</p>
                </div>
                <div class="box2">
                <img src="images/image2.jfif" alt="HOW TO THINK" style="width: 100%; height: auto;">
                <p style="text-align: center;">HOW TO THINK</p>

                </div>
                <div class="box2">

                <img src="images/image3.jfif" alt="THE WEALTH OF NATIONS" style="width: 100%; height: auto;">
                <p style="text-align: center;">THE WEALTH OF NATIONS</p>
                </div>
            </div>

            <div class="bottom">
                
                <div class="box3type1">
                    <form action="process.php" method="POST">
                        <div class="form-group">
                            <label for="student-name">ENTER NAME:</label>
                            <input type="text" name="student-name" id="student-name" size="50" placeholder="ENTER NAME">
                        </div>

                        <div class="form-group">
                            <label for="student-id">ENTER ID:</label>
                            <input type="text" name="student-id" id="student-id" size="50" placeholder="ENTER ID" >
                        </div>
                        <div class="form-group">
                            <label for="student-email">ENTER EMAIL:</label>
                            <input type="text" name="student-email" id="student-email" size="50" placeholder="ENTER EMAIL" >
                        </div>

                        <div class="form-group">
                            <label for="booklist">CHOOSE BOOK YOU WANT:</label>
                            <select name="booklist" id="book">
                            <option value="" disabled selected>SELECT A BOOK</option>
                                <?php
                                   $conn=mysqli_connect("localhost","root","","bookborrow");
                                   if($conn==false)
                                   {
                                    die("ERROR".mysqli_connect_error());
                                   }
                                   $sql = "SELECT bname FROM bookdetails";
                                   $result = mysqli_query($conn, $sql);


                                   if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        
                                        echo '<option value="'.htmlspecialchars($row['bname']).'">'.htmlspecialchars($row['bname']).'</option>';
                                    }
                                } 
                                else{
                                    echo '<option value="" disabled>NO AVAILABLE BOOKS</option>';
                                }
                               
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="borrow-date">BORROW DATE:</label>
                            <input type="date" name="borrow-date" id="borrow-date">
                        </div>

                        <div class="form-group">
                            <label for="return-date">RETURN DATE:</label>
                            <input type="date" name="return-date" id="return-date">
                        </div>
                        <div>
                            <label for="token">TOKEN FOR EXTENDING BORROW DATE:</label>
                            <input type="text" name="token" id="token" placeholder="ENTER TOKEN">
                        </div>

                        <div class="form-group">
                            <input type="submit" name= "submit" value="Submit" class="sbt">
                        </div>
                    </form>
                </div>

                <div class="box3type2">
                    <label>AVAILABLE TOKENS:</label>
                 <?php
                   $jsonfile='token.json';
                   if(file_exists($jsonfile))
                   {

                      $jsondata=file_get_contents($jsonfile);
                      $tokens=json_decode($jsondata,true);
                      if(!empty($tokens['tokens']))
                      {
                        foreach($tokens['tokens'] as $token)
                        {
                            echo "<li>{$token}</li>";
                        }
                      }


                   }




                 ?>
                </div>
            </div>
        </div>

        
        <div class="rightcolumn">
        <h3 style="text-align: center; color: rgb(17, 15, 15); margin-bottom: 20px;">BOOK BORROW MANAGEMENT SYSTEM</h3>
         <div style="text-align: center;">
        <p style="font-size: 18px; color:rgb(17, 15, 15); font-weight: bold; margin-bottom: 10px;">NAME: MD MAHMUDUR RAHMAN</p>
        <p style="font-size: 18px; color: rgb(17, 15, 15); font-weight: bold; margin-bottom: 10px;">ID: 22-46363-1</p>
        
         </div>
     </section>
</body>
</html>
