<!-- connecting to data base -->
<?php
//INSERT INTO `notes` (`slno`, `title`, `decription`, `tstamp`) VALUES (NULL, 'iam karthik', 'complete python moduel.', current_timestamp());
$insert=false;
$update=false;
$delete=false;

$servername = "localhost";
$username = "root";
$password = "";
$database = "notes";

$conn = mysqli_connect($servername,$username,$password,$database);
if(!$conn){
    die("sorry we cannot connect to the data base ".mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno = $_GET['delete'];
 $delete=true;
  $sql="DELETE FROM `notes` WHERE `slno` = '$sno'";
$result = mysqli_query($conn,$sql);
}
if($_SERVER["REQUEST_METHOD"] == "POST")
{
  if(isset($_POST["snoedit"]))
  {
    $editsno = $_POST["snoedit"];
    $edittitle = $_POST["edittitle"];
    $editdecription = $_POST["editdecription"];
  
  $sql = "UPDATE `notes` SET `title` = '$edittitle', `decription` = '$editdecription' WHERE `notes`.`slno` = '$editsno'";
  $result = mysqli_query($conn,$sql);
  if(!$result){
    die( "connection failed .'($result)'.");
}
else{
  $update=true;
} 
  }
  else
  {
$title = $_POST["title"];
$decription = $_POST["decription"];
$sql = "INSERT INTO `notes`(`title`, `decription`) VALUES ('$title' ,'$decription')";
$result = mysqli_query($conn,$sql);

if(!$result){
    die( "connection failed .'($result)'.");
}
else{
  $insert=true;
} 
}
}
?>
<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

  <title>Diary</title>
  <link rel="stylesheet" href="//cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();
    });
  </script>
</head>
<body>
<!-- Button trigger modal -->
 <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Mdoal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit this note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="/crud/index.php?update=true" method="post">
        <input type="hidden" name="snoedit" id="snoedit">
      <div class="mb-3">
        <label for="edittitle" class="form-label">Note Title</label>
        <input type="text" class="form-control" name="edittitle" id="edittitle" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="editdecription" class="form-label">Note Description</label>
        <input type="textarea" class="form-control" name="editdecription" id="editdecription" aria-describedby="emailHelp">
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
      <div class="modal-footer">
      </div>
    </form>
      </div>
      
    </div>
  </div>
</div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="/crud/logo.jpg" height="30px"></img></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Diary</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact US</a>
          </li>
        </ul>
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
      </div>
    </div>
  </nav>
  
  <?php
  if($insert){
    echo "<svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
    <symbol id='info-fill' fill='currentColor' viewBox='0 0 16 16'>
    <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/>
  </symbol>
  </svg>
  <div class='alert alert-success d-flex align-items-center' role='alert'>
    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
    <div>
      Success! Your Note has been inserted succesfully
    </div>
  </div>";
  }
  ?>
  <?php
  if($update){
    echo "<svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
    <symbol id='info-fill' fill='currentColor' viewBox='0 0 16 16'>
    <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/>
  </symbol>
  </svg>
  <div class='alert alert-success d-flex align-items-center' role='alert'>
    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
    <div>
      Success! Your Note has been updated succesfully
    </div>
  </div>";
  }
  ?>

<?php
  if($delete){
    echo "<svg xmlns='http://www.w3.org/2000/svg' style='display: none;'>
    <symbol id='info-fill' fill='currentColor' viewBox='0 0 16 16'>
    <path d='M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z'/>
  </symbol>
  </svg>
  <div class='alert alert-success d-flex align-items-center' role='alert'>
    <svg class='bi flex-shrink-0 me-2' width='24' height='24' role='img' aria-label='Success:'><use xlink:href='#check-circle-fill'/></svg>
    <div>
      Success! Your Note has been deleted succesfully
    </div>
  </div>";
  }
  ?>


  <div class="container my-4 mx-6">
    <form action="/crud/index.php?update=true" method="post">
      <div class="mb-3">
        <label for="title" class="form-label">Note Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="decription" class="form-label">Note Description</label>
        <input type="textarea" class="form-control" name="decription" id="decription" aria-describedby="emailHelp">
      </div>
      <button type="submit" class="btn btn-primary">Add Note</button>
    </form>
  </div>
  <div class="container my-4">
    <table class="table" id="myTable">
      <thead>
        <tr>
          <th scope="col">SlNo</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php
         $sql="SELECT * FROM `notes`";
         $result = mysqli_query($conn,$sql);
         $sno=0;
         while($row=mysqli_fetch_assoc($result)){
           $sno+=1;
          echo  "<tr>
          <th scope='row'>".$sno."</th>
          <td>".$row['title']."</td>
          <td>".$row['decription']."</td>
          <td><button class='edit btn btn-sm btn-primary' id=".$row['slno'].">Edit</button>  <button class='delete btn btn-sm btn-primary' id=d".$row['slno'].">delete</button></td>
        </tr>";
       }
       ?>
      </tbody>
    </table>
    <br>
  </div>
  <br>



  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
    crossorigin="anonymous"></script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  <script>
    edits = document.getElementsByClassName("edit");
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log(edits,);
        tr=e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        decription = tr.getElementsByTagName("td")[1].innerText;
        console.log(title,decription);
        edittitle.value = title;
        editdecription.value = decription;
        snoedit.value=e.target.id;
        console.log(e.target.id);
        $("#editModal").modal("toggle");
    })
  })


  delets = document.getElementsByClassName("delete");
    Array.from(delets).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log(edits,);
        sno=e.target.id.substr(1,);
       if(confirm("are you sure?")){
         console.log("yes");
         window.location=`/crud/index.php?delete=${sno}`;
       }
       else{
         console.log("no");
       }
      })
  })
  </script>

</body>

</html>