@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Room Management</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Room Management</h2>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-new-staff-modal">Add New Room</button>
        </div>
        <!-- BEGIN: Room List -->
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="rooms-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">IMAGE</th>
                            <th class="whitespace-nowrap">ROOM</th>
                            <th class="whitespace-nowrap">FLOOR</th>
                            <th class="whitespace-nowrap">TYPE</th>
                            <th class="whitespace-nowrap">DESCRIPTION</th>
                            <th class="text-center whitespace-nowrap">RATE</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: Room List -->
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('dist/js/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        var table = $("#rooms-table").DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            autoWidth: false,
            autoHeight: false,
            responsive: true,
            pageResize: false,

            ajax: {
                url: "{{ route('datatables.rooms') }}",
            },

            columns: [
                {data: "id", name: "id"},
                {data: "photo", name: "photo"},
                {data: "number", render: function(data, type, full, meta){
                    return '<span class="whitespace-nowrap">'+ 'Room #' + full.number +'</span>'
                }},
                {data: "floor", render: function(data, type, full, meta){
                    return '<span class="whitespace-nowrap">'+ 'Floor #' + full.floor +'</span>'
                }},
                {data: "type", name: "type"},
                {data: "description", name: "description"},
                {data: "rate", name: "rate"},
                {data: "status", name: "status"},
                {data: "actions", name: "actions"},
            ],

            columnDefs: [
                {
                    targets: [0, 1, 4, 5, 6, 7],
                    className: 'text-center',
                },
                {
                    targets: [0, 1],
                    className: "w-24 text-center",
                },
                {
                    targets: -1,
                    className: "table-report__action w-20",
                }
            ]
        });
    });
</script>
@endsection
