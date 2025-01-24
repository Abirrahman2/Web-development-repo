<?php 

    if(isset($_POST['submit']))
    {
        $track=false;
        $track2=false;
      $checkstudentname=trim($_POST['student-name']);
      $checkstudentid=trim($_POST['student-id']);
      $checkstudentemail=trim($_POST['student-email']);
       $booklist = isset($_POST['booklist']) ? trim($_POST['booklist']) : '';
       $tokenlist=isset($_POST['token']) ? trim($_POST['token']): '';
      $errors=[];
      $booklist=str_replace(' ','_',$booklist);
      if(isset($_COOKIE[$booklist]))
      {
        $track=true;
        $track2=true;
        $errors[]="THE SELECTED BOOK IS CURRENTLY UNAVAILABLE";
      }
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
    if(!(preg_match("/^\d{2}-\d{5}-\d{1}\@(student)\.(aiub)\.(edu)$/",$checkstudentemail)))
    {
        $track=true;
        $errors[]="PROVIDED EMAIL IS INVALID";
    }
    $emailvarification=explode("@",$checkstudentemail);
    $emailfirstpart=$emailvarification[0];
    if($emailfirstpart!=$checkstudentid)
    {
        $track=true;
        $errors[]="STUDENT ID AND EMAIL'S FIRST PART IS NOT SAME".$emailfirstpart;
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
           
            $jsonfile = 'token.json';
            $tokens = [];
            $transfer_file1='token_info.json';
            if($tokenlist=='')
            {
                $track=true;
              $errors[]="YOUR RETURN DATE IS MORE THAN 10 DAYS AND YOU DID NOT SELECT ANY TOKEN YET.PLEASE SELECT A TOKEN FIRST.";
            }
            else{
                $isValidToken=true;

                if(file_exists($transfer_file1))
                {
                   $data=file_get_contents($transfer_file1);
                   $tokenUsed=json_decode($data,true);
                   if (in_array($tokenlist, $tokenUsed['token_used'])) {
                       
                       $track = true;
                       $isValidToken=false;
                       $errors[] = "THE TOKEN '$tokenlist' ALREADY SELECTED. PLEASE CHOOSE DIFFERENT TOKEN";
                   } else if($track2==false) {
                      
                       $tokenUsed['token_used'][] = $tokenlist;
                       $tokenencoded = json_encode($tokenUsed, JSON_PRETTY_PRINT);
                   
                      
                       if (file_put_contents($transfer_file1, $tokenencoded)) {
                           echo "TOKEN IS SAVED";
                       } else {
                           echo "TOKEN IS NOT SAVED";
                           $isValidToken=false;
                       }
                   }
                   else if($track2==true)
                   {
                    echo "TOKEN IS NOT SAVED";
                   }
                   
                  /* $tokenUsed['token_used'][] = $tokenlist;
                   $tokenencoded=json_encode($tokenUsed);
                   if(file_put_contents($transfer_file1,$tokenencoded))
                   {
                       echo "TOKEN IS SAVED";
                   }
                   else{
                       echo "TOKEN IS NOT SAVED";
                   }*/
    
                }
                else{
                   $tokenUsed=[
                       "token_used"=>[$tokenlist]
      
                     ];
                     $tokenencoded=json_encode($tokenUsed);
                   if(file_put_contents($transfer_file1,$tokenencoded))
                   {
                       echo "TOKEN IS SAVED";
                   }
                   else{
                       echo "TOKEN IS NOT SAVED";
                   }
    
                }
               /* if (file_exists($jsonfile)) {
                    $jsondata = file_get_contents($jsonfile);
                    $tokens = json_decode($jsondata, true);
                }
            
                $isValidToken = false;
            
               
                if (!empty($tokens['tokens'])) {
                    foreach ($tokens['tokens'] as $token) {
                        if ($token == $tokenlist) {
                            $isValidToken = true; 
                            break;
                        }
                    }
                }*/
                if($isValidToken==false)
                {
                    $errors[] = "DIFFERENCE BETWEEN BORROW DATE AND RETURN DATE IS MORE THAN 10 DAYS AND YOU SELECTED THE WRONG TOKEN.PLEASE SELECT A VALID TOKEN.";
                    $track=true;
                }




            }
           

            
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
     else
     {
        $book_info = [
            'student_name'=>$checkstudentname,
            'student_id' => $checkstudentid,
            'borrow_date' => $checkborrowdate,
            'return_date' =>$checkreturndate
        ];
        $booklist=str_replace(' ','_',$booklist);
          if(isset($_COOKIE[$booklist]))
          {
           
           $user_info_cookie=json_decode($_COOKIE[$booklist],true);
           if($user_info_cookie['student_name']!=$checkstudentname)
           {
            echo "THE BOOK YOU SELECT CURRENTLY IS NOT AVAILABLE. AND IT WILL BE AVAILABLE AFTER  ";
            echo $user_info_cookie['return_date'];
           }
           else{
    
            echo "<div style='border: 2px solid green; background-color: rgb(230, 255, 230); padding: 10px; margin-bottom: 10px; text-align: center;'>";
            echo "<h2 style='color: green; margin: 0;'>YOU ALREADY BORROWED THIS BOOK</h2>";
            echo "</div>";
           }
          // header("Location:../book_borrow/warning.php");
               
          }
          else{
            $booklist=str_replace(' ','_',$booklist);
            //echo "SUCCESSFULLY SUBMITTED";
           
            //echo $_POST['booklist'];
                $all_data = [
                    "student_name" => $checkstudentname,
                    "student_id" => $checkstudentid,
                    "student_email" => $checkstudentemail,
                    "selected_book" => $booklist,
                    "borrow_date" => $checkborrowdate,
                    "return_date" => $checkreturndate,
                    "token"=>$tokenlist
                ];
                
                $json_data = json_encode($all_data);
                
                $transfer_file = 'save_data.json'; 
               
                  
            
            
                
                if (file_put_contents($transfer_file, $json_data))
                 {
                    echo "<div style='border: 2px solid green; background-color: rgb(230, 255, 230); padding: 10px; margin-bottom: 10px; text-align: center;'>";
                    echo "<h2 style='color: green; margin: 0;'>SUCCESSFULLY SUBMITTED AND SAVED ALL THE INFORMATION IN save_data.json FILE</h2>";
                    echo "</div>";

                    $receipt_generat="STUDENT NAME: $checkstudentname<br>"."ID: $checkstudentid<br>"."EMAIL: $checkstudentemail<br>"."SELECTED BOOK: $booklist<br>"."RETURN DATE: $checkreturndate<br>"."TOKEN: $tokenlist<br>";
                    echo $receipt_generat;
                    
                    
                    
                    
        
                } 
                else 
                {
                    echo "<div style='border: 2px solid orange; background-color: rgb(255, 245, 200); padding: 10px; margin-bottom: 10px; text-align: center;'>";
                    echo "<h2 style='color: orange; margin: 0;'>SUBMITTED BUT FAILED TO SAVE DATA DUE TO SOME TECHNICAL ERROR</h2>";
                    echo "</div>";
                }
    
                $booklist=str_replace(' ','_',$booklist);
                setcookie($booklist,json_encode($book_info),time()+30,"/");
            
            
          }
       

     }

    }
    
?>