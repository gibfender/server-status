<?php

/*TODO When a new mission is uploaded, get php to generate a 4 character alphanumeric code. It can behave like a "password" for that file.(edited)
And if they want to overwrite it they just enter the code. */

  if(isset($_FILES['file'])) {
    $file = $_FILES['file'];

    //File Properties
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];

    //Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));

    //specify which extensions are allowed
    $allowed = array('pbo');

    //check that the file should be uploaded
    if (in_array($file_ext, $allowed)) {
      if ($file_error == 0) {
        if ($file_size <= 1000000) {
          $file_destination = $missionsdir;
          //move the file from temp location to MPMissions folder
          if(move_uploaded_file($file_tmp, $file_destination.$file_name)) {
              echo "File Uploaded";
          }
        } else {
          echo "Your filesize was too big!";
        }
      } else {
        echo "There was an error with your upload";
      }
    } else {
      echo "Extension not allowed!";
    }

  }

 ?>
