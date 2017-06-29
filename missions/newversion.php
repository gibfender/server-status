<?php
        require '../settings.php';

        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        function updateversion() {

          $dsn = "mysql:host=$servername;dbname=$dbname;";
          $opt = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
            ];
          $pdo = new PDO($dsn, $username, $password, $opt);
          $sql = "UPDATE missions SET
                                      dateupdated = CURDATE(),
                                      version = ?,
                                      WHERE id = '$id'";
          $stmt = $pdo->prepare($sql)->execute([$version]);
          error_log($stmt);
          $stmt = null;

        };

        function addreleasenotes() {

          $id = $_POST['id'];
          $version = $_POST['version'];
          $notes = $_POST['notes'];

          $dsn = "mysql:host=$servername;dbname=$dbname;";
          $opt = [
              PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION
            ];
          $pdo = new PDO($dsn, $username, $password, $opt);
          $sql = "INSERT INTO releasenotes(version,notes,date,id)
                  VALUES (?,?,CURDATE(),?)";
          $stmt=$pdo->prepare($sql)->execute([$version,$notes,$id]);
          error_log($stmt);
          $stmt=null;
        };



            $file_name=   $_FILES['file']['name'];
            $tmpName  =   $_FILES['file']['tmp_name'];
            $error    =   $_FILES['file']['error'];
            $size     =   $_FILES['file']['size'];
            $ext      =   strtolower(pathinfo($name, PATHINFO_EXTENSION));

            switch ($error) {
                case UPLOAD_ERR_OK:
                    $valid = true;
                    //validate file extensions
                    if ( !in_array($ext, array('pbo')) ) {
                        $valid = false;
                        $response = 'Invalid file extension.';
                    }
                    //validate file size
                    if ( $size/10240/10240 > 2 ) {
                        $valid = false;
                        $response = 'File size is exceeding maximum allowed size.';
                    }
                    //upload file
                    if ($valid) {
                      updateversion();
                      addreleasenotes();
                        move_uploaded_file($tmpName,$missionsdir.$file_name);
                        header( 'Location: index.php' ) ;
                        exit;
                    }
                    break;
                case UPLOAD_ERR_INI_SIZE:
                    $response = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
                    break;
                case UPLOAD_ERR_FORM_SIZE:
                    $response = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
                    break;
                case UPLOAD_ERR_PARTIAL:
                    $response = 'The uploaded file was only partially uploaded.';
                    break;
                case UPLOAD_ERR_NO_FILE:
                    $response = 'No file was uploaded.';
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    $response = 'Missing a temporary folder. Introduced in PHP 4.3.10 and PHP 5.0.3.';
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    $response = 'Failed to write file to disk. Introduced in PHP 5.1.0.';
                    break;
                case UPLOAD_ERR_EXTENSION:
                    $response = 'File upload stopped by extension. Introduced in PHP 5.2.0.';
                    break;
                default:
                    $response = 'Unknown error';
                break;
            }

            echo $response;
        }

 ?>
