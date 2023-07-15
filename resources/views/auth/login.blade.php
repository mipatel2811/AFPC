@extends('layouts.app')

@section('content')
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Afpc</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Shopify App</p>
        @if ($message = Session::get('error'))
          <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{{ $message }}</strong>
          </div>
        @endif
        <form method="GET" action="{{ route('home') }}">
            <div class="form-group">
                <label>Enter Your Shopify Domain to login</label>
                <input type="text" name="shop" class="form-control" required placeholder="your-shop-url.myshopify.com">
            </div>
            <div class="form-group">
                <button class="btn btn-info btn-lg btn-block">Install</button>
            </div>
        </form>
        {{-- <form action="{{ route('login') }}" method="post">
          @csrf
          <div class="input-group mb-3">
            <input type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" value="{{ old('email') }}"
                   required autocomplete="email" autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          @error('email')
            <span class="error" role="alert">
              <strong>{{ $errors->first('email') }}</strong>
            </span>
          @enderror
          <div class="input-group mb-3">
            <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required
                   autocomplete="current-password" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          @error('password')
            <span class="error" role="alert">
              <strong>{{ $errors->first('password') }}</strong>
            </span>
          @enderror
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form> --}}
        <!-- /.social-auth-links -->
        {{-- @if (Route::has('password.request'))
          <p class="mb-1">
            <a href="{{ route('password.request') }}">I forgot my password</a>
          </p>
        @endif --}}
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
@endsection
