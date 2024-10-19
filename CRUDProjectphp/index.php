<?php
//connect to the database
$insert=false;
$update=false;
$delete=false;

$servername="localhost";
$username="root";
$password="";
$database="notes";
//create a connection
$conn=mysqli_connect($servername,$username,$password,$database,$insert);

//Die if connection was not Successful
if(!$conn){
    die("Sorry we failed to connect".mysqli_connect_error());
}
//How to receive request from the server as POST method
// exit();
if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
  $delete = true;
  $sql = "DELETE FROM `text` WHERE `sno` = $sno";
  $result = mysqli_query($conn,$sql);
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {  
  if(isset($_POST['snoEdit'])){
  $sno =$_POST["snoEdit"];
  $title = $_POST['titleEdit'];
  $description = $_POST['descriptionEdit'];
  
  $sql="UPDATE `text` SET `title` = '$title' , `description` = '$description'  WHERE `text`.`sno` = $sno";  
  $result = mysqli_query($conn,$sql);
  if($result){
    //  echo"The Db Created sucessfully";
    $update=true;
    }else{
      echo"We cannot Updated the record Successfully".mysqli_error($conn);
    }
    
  }
  else{
  $title = $_POST['title'];
  $description = $_POST['description'];

$sql="INSERT INTO `text` (`title`,`description`) VALUES ( '$title', '$description')";  
$result = mysqli_query($conn,$sql);

if($result){
//  echo"The Db Created sucessfully";
$insert=true;
}else{
  echo"The database not created sucessfully because of this error---->".mysqli_error($conn);
}
}
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>i-Notes Note Taking Made Easy</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script
      src="https://code.jquery.com/jquery-3.7.1.js"
      integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
      crossorigin="anonymous"></script>
     
  
</head>

<body>
<!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!--Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit this Notes</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/CRUDProjectphp/index.php" method="POST">
      <div class="modal-body"> 
        <input type="hidden" name="snoEdit" id="snoEdit">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby=" emailHelp">
        <div id="emailHelp" class="form-text"></div>
      </div>

      <div class="mb-3">
        <label for="desc">Note Description</label>
        <textarea class="form-control" placeholder="" id="descriptionEdit" name="descriptionEdit"></textarea>
      </div>
      </div>
      <div class="modal-footer d-block mr-auto">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>




  <!-- This is Nav Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="/CRUDProjectphp/logo2.svg" height="28px" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
        </ul>
        <form class="d-flex" role="search">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>

  <?php

if($insert){
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Success!</strong> You note has been inserted Successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
  ?>
  <?php

if($delete){
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Successful!</strong> You note has been deleated Successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
  ?>
  <?php

if($update){
  echo"<div class='alert alert-success alert-dismissible fade show' role='alert'>
  <strong>Successful!</strong> You note has been Updated Successfully.
  <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
}
  ?>

  <!-- This is Form  -->
  <div class="container my-4">
    <h3>Add your Notes</h3>
    <form action="/CRUDProjectphp/index.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" id="title" name="title" aria-describedby=" emailHelp">
        <div id="emailHelp" class="form-text"></div>
      </div>

      <div class="mb-3">
        <label for="desc">Note Description</label>
        <textarea class="form-control" placeholder="" id="description" name="description"></textarea>

      </div>

      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>


  <!-- Here We Added the php to sve the notes Inserted From the user -->
  <div class="container">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">S.No</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>

        <?php
    $sql="SELECT * FROM `text`";
    $result = mysqli_query($conn,$sql);
    $sno=0;     //sno will not come from database it will use the lopp
    while($row = mysqli_fetch_assoc($result)){
      $sno=$sno +1;
      // echo var_dump($row);
      echo" <tr>
          <th scope='row'>".$sno."</th>
          <td>" .$row['title'] . "</td>
          <td>" .$row['description'] . "</td>
          <td><button class='edit btn btn-sn btn-primary' id=".$row['sno'] .">Edit</button> <button class='delete btn btn-sn btn-primary' id=d".$row['sno'] .">Delete</button></td>
        </tr>";
        
        
  }
  ?>
      </tbody>
    </table>
  </div>

  <div class="container">
    <table class="table" id="myTable"></table>
  </div>
  <hr>







  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
    crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script>
  $(document).ready(function() {
    $('#myTable').DataTable();
  });
</script>

<!-- This script is for the edit button working -->
<script>
        edits=document.getElementsByClassName('edit');
        Array.from(edits).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("Edit Clicked");
            tr = e.target.parentNode.parentNode;
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log("Title:",title,"Description:", description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            snoEdit.value = e.target.id;
             console.log(e.target.id);
            $('#editModal').modal('toggle');
          });
        });

        deletes=document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element)=>{
          element.addEventListener("click",(e)=>{
            console.log("Edit Clicked");
            sno = e.target.id.substr(1,);

            if(confirm("Press a button!")){
              console.log("yes");
              window.location = `/CRUDProjectphp/index.php?delete=${sno}`
            }else{
              console.log("no");
            }
          });
        });
      </script>

   
</body>

</html>