<!DOCTYPE HTML>
<html>
<head>
    <title>Pesan Tiket Online</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    @include('layouts.customer.style')
    @stack('content-style')
</head>
<body class="is-preload">

<x-google.translate style="position: fixed; bottom: 50px; right: 30px; z-index: 99999;"></x-google.translate>

<!-- Wrapper -->
<div id="wrapper">

    <!-- Header -->
    @include('layouts.customer.header')

    @yield('content-body')

    @include('layouts.customer.footer')

</div>

@include('layouts.customer.script')
@stack('content-script')

</body>
</html>
