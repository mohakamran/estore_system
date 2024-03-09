<?php
include_once '../../assets/php/connection.php';

$result = mysqli_query($con, "SELECT DISTINCT id,reportType,projectName FROM reports")
or die('An error occurred! Unable to process this request. ' . mysqli_error($con));
$projects = [];
if (mysqli_num_rows($result) > 0) {
  while ($row = mysqli_fetch_array($result)) {
    array_push($projects, $row);
  }
}
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Report</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Report</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <form role="form" id="reportForm">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Client Details</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label for="projectType">Choose Project Type: </label>
                      <input type="radio" name="projectType" value="New"> New
                      <input type="radio" name="projectType" value="Existing"> Existing
                    </div>
                  </div>
                </div>
                <div class="row projectNew" hidden>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="projectName">Project Name</label>
                      <input type="text" class="form-control" id="projectName" name="projectName" placeholder="Enter Project Name">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="clientName">Client Name</label>
                      <input type="text" class="form-control" id="clientName" name="clientName" placeholder="Enter Client Name">
                    </div>
                  </div>
                </div>
                <div class="row projectExist" hidden>
                  <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                      <label for="projectName">Choose Project</label>
                      <div class="input-group mb-3">
                        <select class="custom-select" name="selectProject" id="selectProject">
                          <option value="" selected>Choose Project...</option>
                          <?php
                          foreach ($projects as $project) {
                            ?>
                            <option value="<?= $project[0] ?>" data-value="<?= $project[1] ?>"><?= $project[2] . " - " . $project[1] ?></option>
                            <?php
                          }
                          ?>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row projectNew" hidden>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group ">
                      <label for="productName">Product Name</label>
                      <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter Product Name">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="projectStartDate">Project Start Date</label>
                      <input type="date" class="form-control projectStartDate" name="projectStartDate" id="projectStartDate" placeholder="Enter Date">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="statsDatePeriod">Stats Date Period</label>
                      <input type="date" class="form-control statsDatePeriod" name="statsDatePeriod" id="statsDatePeriod" placeholder="dd-mm-yyyy">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="resourceName">Resource Name</label>
                      <input type="text" class="form-control" id="resourceName" name="resourceName" placeholder="Enter Resource Name">
                    </div>
                  </div>
                </div>


              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="form-group">
              <label for="reportType">Report Type: </label>
              <input type="radio" name="reportType" value="TASK"> Task
              <input type="radio" name="reportType" value="STATS"> Stats
            </div>

            <div class="card card-primary" id="taskData" hidden>
              <div class="card-header">
                <h3 class="card-title">Task Data</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button id="reportCard" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>

              <div class="card-body">
                <div class="row">
                  <div class="col-12" id="taskCardBody">
                  </div>
                </div>
              </div>

              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" class="btn btn-success float-right" onclick="addTaskCard();">ADD +</button>
              </div>

            </div>

            <div class="card card-primary" id="statsData" hidden>
              <div class="card-header">
                <h3 class="card-title">Stat Data</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button id="reportCard" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                  <div class="col-12" id="reportCardBody">

                  </div>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="button" class="btn btn-success float-right" onclick="addReportCard();">ADD +</button>
              </div>
            </div>
            <!-- /.card -->

            <button type="submit" class="btn btn-primary float-right">Add Report</button>

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </form>
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
