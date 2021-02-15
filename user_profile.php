<?php
require_once 'init.php';
$user = new User();
if (Input::exists('get')){
    $id = Input::get('id')??false;
    if ($id){
        $user->find(intval($id));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
  
  <?php include "templates/nav.php"; ?>

   <div class="container">
     <div class="row">
       <div class="col-md-12">
         <h1>Данные пользователя</h1>
         <table class="table">
           <thead>
             <th>ID</th>
             <th>Имя</th>
             <th>Дата регистрации</th>
             <th>Статус</th>
           </thead>

           <tbody>
             <tr>
               <td><?= isset($user->getData()->id)?$user->getData()->id:"" ?></td>
               <td><?= isset($user->getData()->username)?$user->getData()->username:"" ?></td>
               <td><?= isset($user->getData()->date)?$user->getData()->date:"" ?></td>
               <td><?= isset($user->getData()->status)?$user->getData()->status:"" ?></td>
             </tr>
           </tbody>
         </table>


       </div>
     </div>
   </div>
</body>
</html>