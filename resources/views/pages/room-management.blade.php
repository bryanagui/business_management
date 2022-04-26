@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Room Management</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Room Management</h2>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-new-room-modal">Add New Room</button>
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

@section('modal')
<!-- BEGIN: Successful Notification -->
<div id="room-success-notification" class="toastify-content hidden flex"> <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div id="room-success-notification-title" class="font-medium"></div>
        <div id="room-success-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Successful Notification -->
<!-- BEGIN: Create New Hotel Room Modal -->
<div id="create-new-room-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Add New Room</h2>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('room_management.store') }}" method="POST">
                    @csrf
                    <div class="flex justify-center mb-4">
                        <div class="w-56">
                            <div class="w-56 h-56 image-fit zoom-in">
                                <img src="{{ asset('/storage/images/sana-default.jpg') }}" id="view-staff-image" class="rounded-lg">
                            </div>
                            <input type="file" id="thumbnail-upload" accept="image/*,image/heif,image/heic" name="media" hidden>
                            <button type="button" id="thumbnail-upload-trigger" class="btn btn-primary w-full mt-2">Upload Thumbnail</button>
                            <span class="validation-error error-media {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="create-room-number" class="form-label">Room Number</label>
                        <input id="create-room-number" type="number" class="form-control" name="number" placeholder="1000">
                        <span class="validation-error error-number {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4"> <label>Room Type</label>
                        <select class="form-select" name="type">
                            @foreach(\App\Models\RoomType::all() as $room)
                            <option value="{{ $room->type }}">{{ $room->type }}</option>
                            @endforeach
                        </select>
                        <span class="validation-error error-type {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4"> <label>Floor</label>
                        <select class="form-select" name="floor">
                            @for($i = 1; $i <= 30; $i++) <option value="{{ $i }}">Floor {{ $i }}</option> @endfor
                        </select>
                        <span class="validation-error error-floor {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-room-number" class="form-label">Price/Rate</label>
                        <input id="create-room-number" type="number" class="form-control" name="rate" step="0.01" placeholder="7500.00">
                        <span class="validation-error error-rate {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-address" class="form-label">Description</label>
                        <textarea id="create-address" type="text" class="form-control" name="description" placeholder="A standard one person room"></textarea>
                        <span class="validation-error error-description {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <button type="submit" id="create-form-submit" class="btn btn-primary w-full mr-1 mb-2">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Create new Hotel Room Modal -->
@endsection

@section('script')
<script src="{{ asset('dist/js/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        function clearCreateModal(){
            $('#create-form').trigger("reset");;
            $('span.validation-error').text('');
        }

        function hideSlideover(selector){
            const el = document.querySelector(selector);
            const slideOver = tailwind.Modal.getOrCreateInstance(el);
            slideOver.hide();
        }

        function showSlideover(selector){
            const el = document.querySelector(selector);
            const slideOver = tailwind.Modal.getOrCreateInstance(el);
            slideOver.show();
        }

        function loading(selector){
            $(selector).html('<i data-loading-icon="oval" data-color="white" class="w-5 h-5 mx-auto"></i>');
            tailwind.svgLoader();
            $(selector).attr("disabled", "true");
        }

        function finishedLoading(selector, text){
            $(selector).html(text);
            $(selector).removeAttr("disabled")
        }

        function showSuccessNotification(title, content){
            Toastify({
                node: $("#room-success-notification")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            $("#room-success-notification-title").text(title);
            $("#room-success-notification-content").text(content);
        }

        $("#thumbnail-upload-trigger").click(function (e) {
            $("#thumbnail-upload").trigger('click');
        });

        $("#create-form").submit(function (e) {
            loading("#create-form-submit");
            e.preventDefault();

            let form = document.getElementById("create-form")
            let fd = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('room_management.store') }}",
                data: fd,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status == 1){
                        finishedLoading("#create-form-submit", "Submit");
                        hideSlideover("#create-new-room-modal")
                        clearCreateModal();
                        showSuccessNotification(response.title, response.content);
                        table.ajax.reload();
                    }
                },
                error: function (xhr) {
                    if(xhr.status == 422){
                        var errors = xhr.responseJSON.errors;
                        $('#create-form').find('span.validation-error').text('');
                        $.each(errors, function (s, v) {
                            $('#create-form').find('span.error-'+s).text(v[0]);
                        });
                    }
                    finishedLoading("#create-form-submit", "Submit");
                }
            });
        });
    });
</script>
@endsection
