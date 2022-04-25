@extends('../layout/base')

@section('body')

<body class="py-5">
    @yield('content')
    @yield('modal')

    <!-- BEGIN: JS Assets -->
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBG7gNHAhDzgYmq4-EHvM4bqW1DNj2UCuk&libraries=places"></script>
    <script src="{{ mix('dist/js/app.js') }}"></script>
    <!-- END: JS Assets -->
    <!-- BEGIN: Additional Javascript Files/Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- END: Additional Javascript Files/Libraries -->

    <!-- BEGIN: DateTime Now -->
    <script>
        $(document).ready(function() {
                var interval = setInterval(function() {
                    var momentNow = moment();
                    $('#topbar-datetime-running').html(momentNow.format('dddd') + ', ' + momentNow.format('DD MMMM YYYY') + ' ' +
                        momentNow.format('hh:mm:ssa'));
                }, 500);
            });
    </script>
    <!-- END: DateTimeNow -->

    @yield('script')
</body>
@endsection
