<?php
   //assume nothing is suspect
   $suspect = false;
   //create a pattern to locate suspect phrases
   $pattern = '/Content-Type:|Bcc:|Cc:/i';
   //function to check for suspect phrases
   function isSuspect($val, $pattern, &$suspect) {
     // if the variable is an array, loop through each element
     // and pass it recursively back to the same function
     if (is_array($val)) {
       foreach ($val as $item) {
         isSuspect($item, $pattern, $suspect);
       }
     } else {
       // if one of the suspect phrases is found, set Boolean to true.
       if(preg_match($pattern, $val)) {
         $suspect = true;
       }
     }
   }
   //Check the $_POST array and any subarrays for suspect content
   isSuspect($_POST, $pattern, $suspect);
if(!$suspect) {
  foreach ($_POST as $key => $value) {
    //assign to temporary variable and strip whitespace if not an Array
    $temp = is_array($value) ? $value : trim($value);
    //if empty and required, add to $missing Array
    if (empty($temp) && in_array($key, $required)) {
      $missing[] = $key;
      ${$key} = '';
    } elseif (in_array($key, $expected)) {
      //otherwise, assign to a variable of the same name as $key
      ${$key} = $temp;
    }
  }
}
// validate the user's email
if (!$suspect && !empty($email)) {
    $validemail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$validemail) {
        $errors['email'] = true;
      }
    if ($validemail) {
            $query = $conn->prepare("SELECT * FROM userdata WHERE email = '$validemail' ");
            $query->execute();
            $query->store_result();
            $rowinfo = $query->num_rows;
          }
          if ($rowinfo > 0 ) {
              $errors['duplicate'] = true;
          } else  {
              // flag initialized
              $mailSent = false;
              // Go ahead only if not suspect, all required fields OK, and no errors
              if (!$suspect && !$missing && !$errors) {
                 $headers = "From: Jukebox the Ghost<newsletter@discography.com>\r\n";
                 $headers .= 'Content-Type: text/plain; charset=utf-8';
                 $to = $validemail;
                 //create the $message variable
                 $message = "Thank you for signing up for our newsletter.\r\n We hope that we can bring you even a small fraction of the happiness you have brought us.\r\n";
                 $subject = 'Jukebox the Ghost - Newsletter';
                 // limit line length to 70 characters
                 $mailSent = mail($to, $subject, $message, $headers);
                  if (!$mailSent) {
                    $errors['mailfail'] = true;}
                  }
              }
}
