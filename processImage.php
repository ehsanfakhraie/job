<?php
/**
 * Created by PhpStorm.
 * User: Ehsan
 * Date: 10/20/2019
 * Time: 11:32 PM
 */
include "db.php";
  $msg = "";
  $msg_class = "";
  $error="";
  if (isset($_POST['save_avatar'])) {
      session_start();
      // for the database
      $id = $_SESSION['id'];
      $profileImageName = time() . '-' . $_FILES["avatar"]["name"];
      // For image upload
      $target_dir = "images/profiles/";
      $target_file = $target_dir . basename($profileImageName);
      // VALIDATION
      // validate image size. Size is calculated in Bytes
      if($_FILES['avatar']['size'] > 200000) {
          $msg = "Image size should not be greated than 200Kb";
          $msg_class = "alert-danger";
      }
      // check if file exists
      if(file_exists($target_file)) {
          $msg = "File already exists";
          $msg_class = "alert-danger";
      }
      // Upload image only if no errors
      if (empty($error)) {
          if(move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {

              $sql = "UPDATE users SET avatar='$profileImageName' WHERE id='$id'";
              if(mysqli_query($conn, $sql)){
                  $msg = "Image uploaded and saved in the Database";
                  $msg_class = "alert-success";
              } else {
                  $msg = "There was an error in the database";
                  $msg_class = "alert-danger";
              }
          } else {
              $error = "There was an erro uploading the file";
              $msg = "alert-danger";
          }
      }
  }
  echo $msg;
?>