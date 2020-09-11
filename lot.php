<?php
  require_once('helpers.php');

  $is_auth = rand(0, 1);
  
  $user_name = 'Павел';

  if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id == '') {
      header("Location: http://243436-yeticave-12/pages/404.html");
    }
  } else {
    header("Location: http://243436-yeticave-12/pages/404.html");
  }

  $connect = mysqli_connect('localhost', 'root', 'root', 'yeticave');
  mysqli_set_charset($connect, 'utf8');

  if (!$connect) {
    echo 'Ошибка подключения: '.mysqli_connect_error();
  }

  $sql_lots = 'SELECT lot.rate_step, rate.lot_id, date_finish, description, category.name AS category, title, path, lot.cost, MAX(rate.cost) AS current_price
    FROM lot 
        JOIN category ON lot.category_id = category.id
        LEFT JOIN rate ON rate.lot_id = lot.id
            WHERE lot.id = '.$id.' 
            GROUP BY lot.id';

  $result_lots = mysqli_query($connect, $sql_lots);

  if(!$result_lots) {
      $error = mysqli_error($connect);
      echo 'Ошибка MySQL: '.$error;
  }

  $lots = mysqli_fetch_all($result_lots, MYSQLI_ASSOC);



  $sql_lots_id = 'SELECT id FROM lot WHERE id = '.$id;

  $result_lots_id = mysqli_query($connect, $sql_lots_id);

  if(!$result_lots_id) {
    $error = mysqli_error($connect);
    echo 'Ошибка MySQL: '.$error;
  }

  $count_lots_id = mysqli_num_rows($result_lots_id);

  if($count_lots_id == '') {
    header("Location: http://243436-yeticave-12/pages/404.html");
  }



  $sql_categories = 'SELECT name, code FROM category'; 

  $result_categories = mysqli_query($connect, $sql_categories);

  if(!$result_categories) {
      $error = mysqli_error($connect);
      echo 'Ошибка MySQL: '.$error;
  }

  $categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);



  function get_dt_range ($date) {
    $future_time = strtotime($date);
    $now_time = time();
    $result_time_hour = floor(($future_time - $now_time) / 3600);
    $result_time_min = floor((($future_time - $now_time) % 3600)/60);
  
    $result_time_min = str_pad($result_time_min, 2, "0", STR_PAD_LEFT);;
    $result_time_hour = str_pad($result_time_hour, 2, "0", STR_PAD_LEFT);;
  
    return [$result_time_hour, $result_time_min];
  };



  function get_sum ($cost) {
	
    ceil($cost);
  
    if ($cost >= 1000) {
      $cost = number_format($cost, 0, ',', ' ');
    }
    
    return $cost.' ₽';
  
  };


  $page_content = include_template('lots.php', ['categories' => $categories, 'lots' => $lots]);

  $layout_content = include_template('layout.php', ['content' => $page_content, 'categories' => $categories, 'title' => $user_name]);

  echo $layout_content;


?>