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
  if ($validemail) {
    $headers .= "\r\nReply-To: $validemail";
  } else {
      $errors['email'] = true;
  }
}
// flag initialized
$mailSent = false;
// Go ahead only if not suspect, all required fields OK, and no errors
if (!$suspect && !$missing && !$errors) {
  //initialize the $message variable
   $message = '';
   // loop through the $expected Array
   foreach ($expected as $item) {
     //assign the value fo the current item to $val
     if (isset(${$item}) && !empty(${$item})) {
       $val = ${$item};
     } else {
       // if it has no value, assign 'Not Selected'
       $val = 'Not selected';
     }
     // if an array, expand as comma-separated string
     if (is_array($val)) {
       $val = implode(', ', $val);
     }
     // replace underscores and hyphens in the label with spaces
     $item = str_replace(['_', '-'], ' ', $item);
     // add label and value to the message body
     $message .= ucfirst($item).": $val\r\n\r\n";
   }
   // limit line length to 70 characters
   $message = wordwrap($message, 70);
   $mailSent = mail($to, $subject, $message, $headers);
    if (!$mailSent) {
      $errors['mailfail'] = true;
    }
}
