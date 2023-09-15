<?php
    $insert = false;
    $update = false;
    $del = false;

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "noteapp";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if(!$conn){
        die("Sorry failed to connect: ". mysqli_connect_error());
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      if(isset($_POST['snoEdit'])){

        $sno =$_POST['snoEdit']; 
        $title =$_POST['titleEdit']; 
        $desc =$_POST['descriptionEdit']; 

        $sql = "UPDATE notes
                SET `title`='$title', `description`='$desc'
                WHERE `sno`=$sno";

        $result = mysqli_query($conn, $sql);
        
          if($result){
            $update = true;
          }

      }

      else if(isset($_POST['snoDelete'])){

        $sno = $_POST['snoDelete'];

        $sql = "DELETE FROM `notes`
                WHERE `sno`=$sno";

        $result = mysqli_query($conn, $sql);

        if($result){
          $del = true;
        }

      }

      else{

        $title = $_POST['title'];
        $desc = $_POST['description'];

        $sql ="INSERT INTO `notes` (`title`, `description`) VALUES ('$title', '$desc')";
        $result = mysqli_query($conn, $sql);

        if($result){
          
          $insert =true;
        }
      }
        
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <title>NoteApp - Notes made easy</title>

</head>
<body>
    <!-- Edit modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="index.php" method="POST">
                <input type="hidden" name="snoEdit" id="snoEdit" >
                <div class="mb-3">
                  <label for="titleEdit" class="form-label">Note Title</label>
                  <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="descriptionEdit" class="form-label">Note Description</label>
                    <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
                  </div>
                <button type="submit" class="btn btn-primary">Update Note</button>
              </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Delete modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Delete Note</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
              <form action="index.php" method="POST">
                  <input type="hidden" name="snoDelete" id="snoDelete" >
                  <div class="mb-3">
                    <label for="readOnly" class="form-label">Warning</label>
                    <input type="text" class="form-control" id="readOnly" name="readOnly" value="Do you want to delete this Note ?" readOnly>
                  </div>
                  <button type="submit" class="btn btn-primary">Detele Note</button>
              </form>
          </div>
        </div>
      </div>
    </div>

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">NOTEApp</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
                <a class="nav-link" href="#">Contact Us</a>
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
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your note has been added successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
                $insert = false;
          }

          else if($update){
            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your note has been updated successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
          }

          else if($del){
            echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
                    <strong>Success!</strong> Your note has been deleted successfully.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
          }

      ?>

      <!-- Notes form -->
      <div class="container mx-auto my-3">
        <h2>Add a Note</h2>
        <form action="index.php" method="POST">
            <div class="mb-3">
              <label for="title" class="form-label">Note Title</label>
              <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
              </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
          </form>
      </div>

      <div class="container my-4">
          <table class="table" id="myTable">
              <thead>
                <tr>
                  <th scope="col">S.No</th>
                  <th scope="col">Title</th>
                  <th scope="col">Description</th>
                  <th scope="col">Actions</th>
                </tr>
              </thead>
              <tbody>
                  <?php

                      $sql = "SELECT * FROM `notes`";

                      $result = mysqli_query($conn, $sql);
                      $num = mysqli_num_rows($result);

                      if($num > 0){
                        $i=1;
                        while($row = mysqli_fetch_assoc($result)){
                          echo "<tr>
                                  <th scope='row'>".$i++."</th>
                                  <td>".$row['title']."</td>
                                  <td>".$row['description']."</td>
                                  <td><button class='edit btn btn-sm btn-primary' id=".$row['sno'].">Edit</button>  <button class='deleteNote btn btn-sm btn-danger' id=d".$row['sno'].">Delete</button></td>
                                </tr>";
                        }
                      }
                      else{
                        echo "<p class='lead text-center my-5'>No Notes Added</p>";
                        echo "<br>";
                      }

                  ?>
                  
              </tbody>
          </table>
      </div>
      <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      let table = new DataTable('#myTable');
    </script>
    <script>

      // Edit handels
      let edit = document.getElementsByClassName("edit");

      Array.from(edit).forEach((element)=>{
        element.addEventListener('click',(e)=>{

          titleE = document.getElementById("titleEdit");
          descriptionE = document.getElementById("descriptionEdit");

          tr = e.target.parentNode.parentNode;
          title = tr.getElementsByTagName("td")[0].innerText;
          description = tr.getElementsByTagName("td")[1].innerText;

          titleE.value = title;
          descriptionE.value = description;
          snoEdit.value = e.target.id;

          $('#editModal').modal('toggle');
        })
      })

      // Delete handles
      let deleteNote = document.getElementsByClassName("deleteNote");

      Array.from(deleteNote).forEach((element)=>{
        element.addEventListener('click',(e)=>{
          // Id of dellete button of the node with 'd' attached
          deleteId = e.target.id;
          //removing 'd' to get onlt sno
          subDeleteId = deleteId.substr(1,);
          
          snoDelete.value = subDeleteId;
          $('#deleteModal').modal('toggle');
        })
      })

    </script>
</body>
</html>