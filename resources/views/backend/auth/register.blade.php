<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMS | Registration </title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('')}}assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('')}}assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('')}}assets/dist/css/adminlte.min.css">
</head>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="#" class="h1"><b>SM-System</b></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Register a new User</p>

        @if($errors->any())
        <div class="alert alert-danger">
          @foreach($errors->all() as $err)
          <li>{{$err}}</li>
          @endforeach
        </div>
        @endif

        <form action="{{ route('register') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="Full name" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <select class="form-control" name="user_type" required>
              <option value="" disabled {{ old('user_type') ? '' : 'selected' }}>Choose one</option>
              <option value="1" {{ old('user_type') == 1 ? 'selected' : '' }}>Super Admin</option>
              <option value="2" {{ old('user_type') == 2 ? 'selected' : '' }}>Admin</option>
              <option value="3" {{ old('user_type') == 3 ? 'selected' : '' }}>Normal User</option>
            </select>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user-tie"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
          </div>
        </form>


        <a href="{{route('login')}}" class="text-center">Sign?</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->

  <!-- jQuery -->
  <script src="{{asset('')}}assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('')}}assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('')}}assets/dist/js/adminlte.min.js"></script>
</body>

</html>