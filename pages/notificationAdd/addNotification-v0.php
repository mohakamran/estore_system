<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Notification</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Notification</li>
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
              <h3 class="card-title">Notification Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="notificationForm">
              <div class="card-body">
                <div class="form-group">
                  <label for="notificationTitle">Notification Title</label>
                  <input type="text" class="form-control" id="notificationTitle" name="notificationTitle" placeholder="Enter Notification Title">
                </div>
                <!-- textarea -->
                <div class="form-group">
                  <label>Notification Description</label>
                  <textarea class="form-control" rows="3" id="notificationDescription" name="notificationDescription" placeholder="Enter Notification Description"></textarea>
                </div>
                <!-- attachments -->
                <div class="form-group">
                  <label>Attachments</label>
                  <input type="file" name="files[]" id="filer_input" multiple="multiple">
                </div>
              </div>

              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary float-right">Submit</button>
              </div>
            </form>
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
