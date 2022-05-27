@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Inventory Management</title>
<link href="http://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('dist/css/square-cropper.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/form-range.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/nouislider.css') }}" />
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Logs</h2>
        <!-- BEGIN: Logs -->
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="logs-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">IMAGE</th>
                            <th class="whitespace-nowrap">PERFORMED BY</th>
                            <th class="whitespace-nowrap">LOGGED ACTION</th>
                            <th class="whitespace-nowrap">DATE</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: Logs -->
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('/dist/js/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $("#logs-table").DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            autoWidth: false,
            autoHeight: false,
            responsive: true,
            pageResize: false,

            ajax: {
                url: "{{ route('datatables.logs') }}",
            },

            columns: [
                {data: "id", name: "id"},
                {data: "photo", name: "photo"},
                {data: "name", name: "name"},
                {data: "message", name: "message"},
                {data: "date", name: "date"},
            ],

            columnDefs: [
                {
                    targets: [0],
                    className: "text-center",
                },
                {
                    targets: [1],
                    className: "w-24"
                },
            ]
        });
    });
</script>
@endsection
