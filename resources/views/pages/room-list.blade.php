@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Room Management</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Room List</h2>
        <!-- BEGIN: Room List -->
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="rooms-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ROOM ID</th>
                            <th class="text-center whitespace-nowrap">IMAGE</th>
                            <th class="whitespace-nowrap">ROOM</th>
                            <th class="whitespace-nowrap">FLOOR</th>
                            <th class="whitespace-nowrap">TYPE</th>
                            <th class="whitespace-nowrap">DESCRIPTION</th>
                            <th class="text-center whitespace-nowrap">RATE</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
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
                {data: "number", name: "number"},
                {data: "floor", name: "floor"},
                {data: "type", name: "type"},
                {data: "description", name: "description"},
                {data: "rate", name: "rate"},
                {data: "status", name: "status"},
            ],

            columnDefs: [
                {
                    targets: [0, 1, 4, 5, 6, 7],
                    className: 'text-center',
                },
                {
                    targets: [0, 1],
                    className: "w-24"
                },
                {
                    targets: 1,
                    className: "align-center"
                }
            ]
        });
    });
</script>
@endsection
