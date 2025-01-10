
<?php

// namespace
use Model\ToDoList; 
class controller{
  public function getData(){
    $model = new ToDoList();
    $allData = $model->getAll();
    return $allData;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>To Do List - UAP WEB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <div class="container">
      <div id="new-task">
        <input type="text" placeholder="Enter The Task Here..." />
        <button id="push">Add</button>
      </div>
      <?php
      $AllData = new controller();
      $AllData->getData();
      for ($i=0; $i <= $AllData; $i++) { 
        echo"Saya menyerah";
      }
      
      ?>
      <!-- <div id="tasks" style="display: inline-block">
        <div class="task" id="0">
          <span id="taskname">HTML</span>
          <button class="edit" style="visibility: visible">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button class="delete">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
        <div class="task" id="1">
          <span id="taskname">CSS</span>
          <button class="edit" style="visibility: visible">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button class="delete">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
        <div class="task" id="2">
          <span id="taskname">JAVASCRIPT</span>
          <button class="edit" style="visibility: visible">
            <i class="fa-solid fa-pen-to-square"></i>
          </button>
          <button class="delete">
            <i class="fa-solid fa-trash"></i>
          </button>
        </div>
      </div> -->
    </div>
  </body>
  <!-- <script src="script.js">

  </script> -->
</html>


