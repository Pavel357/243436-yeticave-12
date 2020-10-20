<?php

  require_once('helpers.php');
  require_once('functions.php');

  $is_auth = rand(0, 1);

  $user_name = 'Павел';

  $title = 'Регистрация';

  $connect = db_connect();

  $categories = get_categories($connect);

  $email = '';
  $password = '';
  $first_name = '';
  $message = '';


  $errors = [];
  

  if (
    isset($_POST['email']) && 
    isset($_POST['password']) && 
    isset($_POST['name']) && 
    isset($_POST['message'])
  ) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $first_name = $_POST['name'];
    $message = $_POST['message'];


    $rules = [
      'email' => function() {
        return validateEmail('email');
      },
      'password' => function() {
        return validateFilled('password');
      },
      'name' => function() {
        return validateFilled('name');
      },
      'message' => function() {
        return validateFilled('message');
      }
    ];


    foreach ($_POST as $key => $value) {
      if (isset($rules[$key])) {
        $rule = $rules[$key];
        $errors[$key] = $rule();
      }
    }

    $errors = array_filter($errors);


    $sql_email = 'SELECT email FROM user';

    $result_email = mysqli_query($connect, $sql_email);

    if(!$result_email) {
        $error = mysqli_error($connect);
        echo 'Ошибка MySQL: '.$error;
    }

    $emails = mysqli_fetch_all($result_email, MYSQLI_ASSOC);

    foreach($emails as $value) {
      if($value['email'] == $_POST['email']) {
        $errors['email'] = 'Введите корректный email';
      }
    }


    $created_at = date('Y-m-d H:i:s', time());    

    

    if (empty($errors)) {
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      
      $data = [$created_at, $email, $first_name, $password, $message];
      
      $sql_user = "INSERT INTO user(created_at, email, name, password, contact) 
      VALUES(?, ?, ?, ?, ?)";

      $prepare = db_get_prepare_stmt($connect, $sql_user, $data);


      if(!mysqli_stmt_execute($prepare)) {
        $error = mysqli_error($connect);
        echo 'Ошибка MySQL: '.$error;
        die();
      };

      header("Location: index.php");
    }

  }



  $page_content = include_template('sign-up.php', ['categories' => $categories, 'errors' => $errors, 'email' => $email, 'password' => $password, 'first_name' => $first_name, 'message' => $message]);
  
  $layout_content = include_template('layout.php', ['content' => $page_content, 'categories' => $categories, 'title' => $title, 'is_auth' => $is_auth, 'user_name' => $user_name]);

  echo $layout_content;

?>