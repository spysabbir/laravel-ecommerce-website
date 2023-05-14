@php
    $default_setting = App\Models\Default_setting::first();
@endphp
<!doctype html>
<html lang="en">

<head>
    <title>:: {{ env('APP_NAME') }} :: Admin :: @yield('title_bar')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="description" content="{{ $default_setting->app_name }} Admin Template">
    <meta name="author" content="Spy IT Firm, www.spyitfirm.com">

    <link rel="icon" href="{{asset('uploads/default_photo')}}/{{$default_setting->favicon}}" type="image/x-icon">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/vendor/font-awesome/css/font-awesome.min.css">

    <!-- MAIN CSS -->
    <link rel="stylesheet" href="{{asset('admin')}}/css/main.css">
    <link rel="stylesheet" href="{{asset('admin')}}/css/color_skins.css">
</head>

<body class="theme-cyan">

    <!-- WRAPPER -->
    <div id="wrapper" class="auth-main">
        <div class="container">
            @yield('body_content')
        </div>
    </div>
    <!-- END WRAPPER -->

    <script src="{{asset('admin')}}/bundles/libscripts.bundle.js"></script>
    <script src="{{asset('admin')}}/bundles/vendorscripts.bundle.js"></script>

    <script src="{{asset('admin')}}/bundles/mainscripts.bundle.js"></script>
</body>

</html>
