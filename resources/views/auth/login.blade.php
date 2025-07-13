@extends('layouts.app')

@section('title', 'Login | Travisa')
@section('login')

<div id="app">
    <section class="section bg-login-page">
        <div class="container mt-5">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

                    <div class="card card-primary">
                        <div class="card-header d-flex flex-column align-items-center">
                            <h4>Login</h4>
                            <p class="mb-0">Masukkan Email dan Password Anda</p>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input id="email" type="email" class="form-control" name="email" required autofocus tabindex="1">
                                    <div class="invalid-feedback">
                                        Please fill in your email
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="d-block">
                                        <label for="password" class="control-label">Password</label>
                                        <div class="float-right">
                                            <a href="{{ route('password.request') }}" class="text-small">Forgot Password?</a>
                                        </div>
                                    </div>
                                    <input id="password" type="password" class="form-control" name="password" required tabindex="2">
                                    <div class="invalid-feedback">
                                        Please fill in your password
                                    </div>
                                </div>

                                <!-- <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="remember" class="custom-control-input" id="remember-me" tabindex="3">
                                        <label class="custom-control-label" for="remember-me">Remember Me</label>
                                    </div>
                                </div> -->

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                        Login
                                    </button>
                                </div>
                            </form>
                            <!-- <div class="text-center mt-4 mb-3">
                                <div class="text-job text-muted">Login With Social</div>
                            </div>
                            <div class="row sm-gutters">
                                <div class="col-6">
                                    <a class="btn btn-block btn-social btn-facebook">
                                        <span class="fab fa-facebook"></span> Facebook
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a class="btn btn-block btn-social btn-twitter">
                                        <span class="fab fa-twitter"></span> Twitter
                                    </a>
                                </div>
                            </div> -->

                        </div>
                    </div>
                    <!-- <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register.html">Create One</a>
            </div> -->

                </div>
            </div>
        </div>
    </section>
</div>

@endsection