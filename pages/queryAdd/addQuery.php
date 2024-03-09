<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Query</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Query</li>
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
              <h3 class="card-title">Query Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="QueryForm">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="customerName">Customer Name</label>
                      <input type="text" class="form-control" id="customerName" name="customerName" placeholder="Enter customer name">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="customerContact">Customer Conatct</label>
                      <input type="number" class="form-control" id="customerContact" name="customerContact" placeholder="Enter customer contact number">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="customerEmail">Customer Email</label>
                      <input type="email" class="form-control" id="customerEmail" name="customerEmail" placeholder="Enter customer email">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="queryDate">Query Date</label>
                      <input type="date" class="form-control" id="queryDate" name="queryDate">
                    </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                      <label for="queryStatus">Query Status</label>
                      <select class="form-control custom-select pnrStatus" id="queryStatus" name="queryStatus">
                        <option value="1">Pending</option>
                        <option value="2">In Progress</option>
                        <option value="3">Resolved</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="queryDescription">Description</label>
                      <textarea class="form-control" id="queryDescription" name="queryDescription" placeholder="Enter description/ notes." rows="3"></textarea>
                    </div>
                  </div>
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