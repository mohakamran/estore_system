<div class="login-page">
<div class="login-box">

  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <h3>Change Password</h3><br><br>

      <form id="signin-form">
        <div class="form-group">
          <label for="username">Username</label>
          <div class="input-group">
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleInputEmail1">Registered email</label>
          <div class="input-group">
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter registered email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="otp">OTP</label>
          <div class="input-group">
            <input id="otp" type="password" class="form-control" placeholder="Enter OTP" name="otp">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" style="display: none;" id="newPasswordGroup">
          <label for="newPassword">New password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group" style="display: none;" id="confirmPasswordGroup">
          <label for="exampleInputEmail1">Confirm Password</label>
          <div class="input-group">
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
        </div>
        <span id="incorrectCredentials"></span><br><br>
        <div class="row" id="ButtonSet1">
          <div class="col-6">
          <button type="button" class="btn btn-primary btn-block" id="sendOTPButton">Send OTP</button>
          </div>
          <!-- /.col -->
          <div class="col-6">
            <button type="button" class="btn btn-success btn-block" id="submitButton">Validate</button>
          </div>
          <!-- /.col -->
        </div>
        <div class="row" id="ButtonSet2" style="display: none;">
          <div class="col-12">
          <button type="button" class="btn btn-primary btn-block" id="changePasswordButton">Change Password</button>
          </div>
        </div>
      </form><br><br>


      <p class="mb-1">
        <a href="../login/">Back to login</a>
      </p>

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->
</div>
