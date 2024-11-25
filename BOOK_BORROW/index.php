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
           
        </div>

        <div class="middle">
            <div class="top">
                <div class="box1">WILL BE ADDED</div>
                <div class="box1">WILL BE ADDED</div>
                <div class="box1">WILL BE ADDED</div>
            </div>

            <div class="middlethree">
                <div class="box2">WILL BE ADDED</div>
                <div class="box2">WILL BE ADDED</div>
                <div class="box2">WILL BE ADDED</div>
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
                                <option value="book1">Hands On Machine Learning</option>
                                <option value="book2">Machine Learning For Absolute Beginners</option>
                                <option value="book3">Neural Networks And Deep Learning</option>
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

                        <div class="form-group">
                            <input type="submit" name= "submit" value="Submit" class="sbt">
                        </div>
                    </form>
                </div>

                <div class="box3type2">
                    
                </div>
            </div>
        </div>

        
        <div class="rightcolumn">
           
         </div>
     </section>
</body>
</html>
