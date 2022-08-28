<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Alif Tech International - Admin Login</title>
    <!-- fontawesome  -->
    <script src="https://kit.fontawesome.com/be1bfd8bbb.js" crossorigin="anonymous"></script>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('backend/assets/images/favicon.png')}}">

    <!-- Toaster  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet" />
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="{{ asset('backend/css/style.css') }}" rel="stylesheet">

</head>

<body class="h-100 bg-white" >

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <main class="container mt-4 mb-5">
        <section class="row">
            <div class="col-md-12">
                <h1 class="text-center">
                    <span class="  border-bottom border-dark border-5 pb-2">
                        <span class="fa fa-user-circle"></span>
                        <!-- <a class="text-center" href=""> -->
                            Admin Sign In
                        <!-- </a> -->
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                        @endif
                    </span>
                </h1>
            </div>
        </section>
        <section class="row g-5 mt-3 align-items-center justify-content-center ">
            <div class="col-sm-12 col-lg-6">
                <div class="mockup mx-auto">
                    <img src="https://psdmockups.s3.amazonaws.com/wp-content/uploads/2013/12/apple-macbook-pro-retina-flat-design-front-view-vector-psd-mockup.jpg"/>
                    <div class="artwork text-center bg-light ">
                        <img class="w-25 p-2 mt-lg-4" src="{{url('backend/upload/logo/logo.png')}}" alt="">

                        <p class="animate-charcter mt-3"> Alif Tech International</p>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-lg-6">
                <div class="w-75 mx-auto">
                    <form class="mt-5 mb-5 login-input" method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input id="email" type="email" name="email" class="form-control" placeholder="Email" :value="old('email')" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" id="password" class="form-control" placeholder="Password" name="password" required autocomplete="current-password">
                        </div>

                        <div class="form-group">
                            <x-jet-checkbox id="remember_me" name="remember" />
                            <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                        </div>
                        <button class="btn login-form__btn submit w-100">Sign In</button>
                    </form>
                </div>
            </div>
        </section>     
    </main>




            <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>




<!--**********************************
        Scripts
    ***********************************-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
<script src="{{ asset('backend/plugins/common/common.min.js') }}"></script>
<script src="{{ asset('backend/js/custom.min.js') }}"></script>
<script src="{{ asset('backend/js/settings.js') }}"></script>
<script src="{{ asset('backend/js/gleek.js') }}"></script>
<script src="{{ asset('backend/js/styleSwitcher.js') }}"></script>
@if(Session::has('message'))
<script>
    var type = "{{Session::get('alert-type','info')}}"
    switch (type) {
        case 'info':
            toastr.info("{{ Session::get('message') }}");
            break;
        case 'success':
            toastr.success("{{ Session::get('message') }}");
            break;
        case 'warning':
            toastr.warning("{{ Session::get('message') }}");
            break;
        case 'error':
            toastr.error("{{ Session::get('message') }}");
            break;
    }
</script>
@endif
</body>

</html>