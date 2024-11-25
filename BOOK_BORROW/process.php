<?php 
    if(isset($_POST['submit']))
    {
        $track=false;
      $checkstudentname=trim($_POST['student-name']);
      $checkstudentid=trim($_POST['student-id']);
      $checkstudentemail=trim($_POST['student-email']);
      $booklist= $booklist = isset($_POST['booklist']) ? trim($_POST['booklist']) : '';
      $errors=[];
    if (!(preg_match("/^[a-zA-Z ]+$/", $checkstudentname))) 
    {

        $track=true;
        $errors[]="PROVIDED NAME IS INVALID";
    }
    if(!(preg_match("/^\d{2}-\d{5}-\d{1}$/", $checkstudentid)))
    {
         $track=true;
         $errors[]="PROVIDED ID IS INVALID";
    }
    if(!(preg_match("/^\d{2}-\d{5}-\d{1}+\@+(student)+\.+(aiub)+\.+(edu)/",$checkstudentemail)))
    {
        $track=true;
        $errors[]="PROVIDED EMAIL IS INVALID";
    }
    if (empty($booklist) || $booklist == "") {
        $track = true;
        $errors[] = "PLEASE SELECT A BOOK";
    }
    $checkborrowdate = $_POST["borrow-date"];
    $checkreturndate = $_POST["return-date"];
      
    if (empty($checkborrowdate) || empty($checkreturndate))
    {
        $track = true;
        $errors[] = "PLEASE PROVIDE DATES";
    } 
    else 
    {
        $borrowDateObj = new DateTime($checkborrowdate);
        $returnDateObj = new DateTime($checkreturndate);

        
        if ($returnDateObj <= $borrowDateObj) {
            $track = true;
            $errors[] = "BORROW DATE IS GREATER THAN RETURN DATE.PLEASE CORRECT IT";
        }

        
        $interval = $borrowDateObj->diff($returnDateObj)->days;
        if ($interval > 10)
        {
            $track = true;
            $errors[] = "YOU CAN NOT BORROW A BOOK MORE THAN 10 DAYS";
        }
      }
    
     if($track==true)
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
        echo "SUCCESSFULLY SUBMITTED";
        $all_data = [
            "student_name" => $checkstudentname,
            "student_id" => $checkstudentid,
            "student_email" => $checkstudentemail,
            "selected_book" => $booklist,
            "borrow_date" => $checkborrowdate,
            "return_date" => $checkreturndate
        ];

        $json_data = json_encode($all_data);

        $transfer_file = 'save_data.json'; 
        if (file_put_contents($transfer_file, $json_data))
         {
            echo "<div style='border: 2px solid green; background-color: rgb(230, 255, 230); padding: 10px; margin-bottom: 10px; text-align: center;'>";
            echo "<h2 style='color: green; margin: 0;'>SUCCESSFULLY SUBMITTED AND SAVED ALL THE INFORMATION IN save_data.json FILE</h2>";
            echo "</div>";



        } 
        else 
        {
            echo "<div style='border: 2px solid orange; background-color: rgb(255, 245, 200); padding: 10px; margin-bottom: 10px; text-align: center;'>";
            echo "<h2 style='color: orange; margin: 0;'>SUBMITTED BUT FAILED TO SAVE DATA DUE TO SOME TECHNICAL ERROR</h2>";
            echo "</div>";
        }

     }

    }
    
?>