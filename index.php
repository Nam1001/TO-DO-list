<?php
$insert=false;
$update=false;
$delete=false;
$servername="localhost";
$username="root";
$password="";
$database="notes";
// CONNECT TO THE DATABASE
$conn=mysqli_connect($servername,$username,$password,$database);
if(isset($_GET['delete']))
{
  // delete records
  $sno=$_GET['delete'];
  $sql="DELETE FROM notes WHERE `notes`.`sno` = $sno";
  $result=mysqli_query($conn,$sql);
  $delete=true;
}
if($_SERVER['REQUEST_METHOD']=='POST')
{
    if(isset($_POST['snoEdit']))
    {
      // UPDATE THE RECORD
     $sno=$_POST["snoEdit"];
    $title=$_POST['titleEdit'];
    $description=$_POST['descriptionEdit'];
    $sql="UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = '$sno'";
    $result=mysqli_query($conn,$sql);
    if($result)
    {
      $update=true;
    }
      
    }
    else{

    // INSERTION OF RECORD
    $title=$_POST['title'];
    $description=$_POST['description'];
    $sql="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$description')";
    $result=mysqli_query($conn,$sql);
if($result)
{
    $insert=true;
}
else{
    echo "the data was not inserted successfully because of------>".mysqli_error($conn);
}

}
}


?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    
    
    
    <title>Project 1- php CRUD</title> 
  </head>
  <body>
  <!-- edit modal -->

<!-- Modal -->
<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditModalLabel">Edit this Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/CRUD/index.php" method="post">
          <input type="hidden" name="snoEdit" id="snoEdit">
      
          <div class="form-group">
            <label for="title"> Note Title</label>
            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
      
          </div>
          
          <div class="form-group">
            <label for="desc">Note Description !!</label>
            <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>
        
          <button type="submit" class="btn btn-primary">Update note</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form>
        
      </div>
      <div class="modal-footer">
       
       
      </div>
    </div>
  </div>
</div>
<!-- NAVIGATION BAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#"><img src="/CRUD/LOho.jpg" height="35px" alt=""></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About us</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Contact us</a>
          </li>
        
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form>
    </div>
  </nav>
  <?php
  if($insert)
  {
    echo" <div class='alert alert-success' role='alert'>
    Added To Your Note!
  </div>";
  }

  ?>
  <?php
  if($update)
  {
    echo" <div class='alert alert-success' role='alert'>
    Your Note Updated!!
  </div>";
  }

  ?>
  <?php
  if($delete)
  {
    echo" <div class='alert alert-success' role='alert'>
    Your Note Deleted!!
  </div>";
  }

  ?> 
 
  <div class="containers my-4 ">
    <h2> Add a Note</h2>
    <form action="/CRUD/index.php" method="post">
        <div class="form-group">
          <label for="title"> Note Title</label>
          <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
    
        </div>
        
        <div class="form-group">
          <label for="desc">Add your note here!!</label>
          <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
      
        <button type="submit" class="btn btn-primary">Add Note</button>
      </form>
  </div>
  <div class="containers my-4">
   

<table class="table table-dark" id="myTable">
  <thead>
    <tr>
      <th scope="col">Serial No</th>
      <th scope="col">Tile</th>
      <th scope="col">Description</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
  <?php
   $sql="SELECT * FROM `notes`";
   $result=mysqli_query($conn,$sql);
   $no=0;
   while($row=mysqli_fetch_assoc($result))
   {
      $no=$no+1;
       echo "<tr>
       <th scope='row'>".$no."</th>
       <td>". $row['title']."</td>
       <td>" . $row['description']."</td>
       <td> <button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button> <button class='delete btn btn-sm btn-primary' id=d".$row['sno'].">Delete</button>  </td>
     </tr>";
     
   }


    ?>
    
   
  </tbody>
</table>

</div>
<hr>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
    crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#myTable').DataTable();

    });
  </script>
  <script>
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        console.log(title, description);
        titleEdit.value = title;
        descriptionEdit.value = description;
        snoEdit.value = e.target.id;
        console.log(e.target.id)
        $('#EditModal').modal('toggle');
      })
    } )

    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
      element.addEventListener("click", (e) => {
        console.log("edit ");
        tr = e.target.parentNode.parentNode;
        title = tr.getElementsByTagName("td")[0].innerText;
        description = tr.getElementsByTagName("td")[1].innerText;
        sno=e.target.id.substr(1,);
        if(confirm("Press OK to confirm!!"))
        {
          console.log("yes")
          window.location=`/CRUD/index.php?delete=${sno}`;
        }
        else{
          console.log("no")
        }
    
      })
    } )
  </script>

  </body>
</html>