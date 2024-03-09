<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Add Poster</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Poster</li>
          </ol>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <form role="form" id="propertyForm">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Report Details</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">

                <div class="row asin-container">
                  <div class="col-md-12 asin-input">
                    <div class="form-group">
                      <label>ASIN 1</label>
                      <input type="text" name="asin" value="" class="form-control">
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <button type="button" name="button" class="btn btn-primary add-asin">ADD</button>
                    <button type="button" name="button" class="btn btn-danger remove-asin">REMOVE</button>
                    <br><br>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>ASIN Details</label>
                      <textarea name="ASINDetails" rows="5" id="ASINDetails" class="form-control"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Supporting Image (Primary)</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button id="pictureCard1" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" id="propertyPicturePrimary-list" hidden>
                      <input type="file" name="files[]" class="propertyPicturePrimary" id="propertyPicturePrimary" multiple="false">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Supporting Images (Secondary)</h3>
                <div class="card-tools" style="position: relative; top: 10px;">
                  <button id="pictureCard2" type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="text" id="propertyPictureSecondary-list" hidden>
                      <input type="file" name="files[]" class="propertyPictureSecondary" id="propertyPictureSecondary" multiple="multiple">
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-body -->
            </div><br>
            <!-- /.card -->


            <button type="submit" class="btn btn-primary float-right">Generate Poster</button>

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
