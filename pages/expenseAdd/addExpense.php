<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Expense</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Expense</li>
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
              <h3 class="card-title">Expense Details</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" id="ExpenseForm">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6  col-sm-12">
                    <div class="form-group">
                      <label for="expenseAmount">Expense Amount (£)</label>
                      <input type="number" class="form-control" id="expenseAmount" name="expenseAmount" placeholder="Enter expense amount">
                    </div>
                  </div>
                  <div class="col-md-6  col-sm-12">
                    <div class="form-group">
                      <label for="expenseDate">Expense Date</label>
                      <input type="date" class="form-control" id="expenseDate" name="expenseDate">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="expenseDescription">Expense Description</label>
                      <textarea class="form-control" id="expenseDescription" name="expenseDescription" placeholder="Enter expense description/ notes." rows="3"></textarea>
                    </div>
                  </div>
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
