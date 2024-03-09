<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Client's Documents</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Client's Documents</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Folders</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="modal" data-target="#myModal">
                  <i class="fas fa-plus"></i>
                </button>
                <!-- The Modal -->
                <div class="modal" id="myModal">
                  <div class="modal-dialog">
                    <div class="modal-content">

                      <!-- Modal Header -->
                      <div class="modal-header">
                        <h4 class="modal-title" style="color: black">Add New Folder</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>

                      <!-- Modal body -->
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="folderName" style="color: black">Folder Name</label>
                          <input type="text" class="form-control folderName" name="folderName" placeholder="Enter folder name">
                        </div>
                      </div>

                      <!-- Modal footer -->
                      <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="addFolder()">ADD</button>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <div class="card-body" style="min-height: 60vh">

              <div class="row">

                <?php

                include_once '../../assets/php/connection.php';

                $result = mysqli_query($con, "SELECT * FROM directory ORDER BY folderName ASC")
                  or die('An error occurred! Unable to process this request. ' . mysqli_error($con));

                if (mysqli_num_rows($result) > 0) {
                  // output data of each row
                  while ($row = mysqli_fetch_array($result)) {
                ?>
                    <div class="col-md-1 col-sm-6 folderContainer">
                      <a href="viewDirectory.php?folderID=<?= $row['id'] ?>" target="_blank">

                        <img src="../../assets/images/folder.png" alt="folderImage" class="img-responsive folderImage">
                        <center><span><?= $row['folderName'] ?></span></center>
                      </a>

                    </div>
                <?php
                  }
                }

                ?>

              </div>

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<style media="screen">
  .folderContainer {
    padding: 20px;
    cursor: pointer;
  }

  a {
    text-decoration: none;
    color: black;
  }

  .folderImage {
    position: relative;
    width: 100%;
  }
</style>