@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Room Management</title>
<link href="http://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('dist/css/square-cropper.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/form-range.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/nouislider.css') }}" />
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
<!-- BEGIN: Error Modal -->
<div id="error-modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Error!</div>
                    <div class="text-slate-500 mt-2">We could not read the file uploaded.<br>Supported file types: JPG, JPEG, PNG</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">OK</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Error Modal -->
<!-- BEGIN: Discard Upload Modal -->
<div id="discard-upload-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="alert-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Discard</div>
                    <div class="text-slate-500 mt-2">Are you sure you want to discard your changes?</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" id="confirm-discard-upload" data-tw-dismiss="modal" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Discard Upload Modal -->
<!-- BEGIN: Confirm Upload Modal -->
<div id="confirm-upload-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Confirm</div>
                    <div class="text-slate-500 mt-2">Are you sure you want to continue with your current changes?</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" data-tw-dismiss="modal" class="btn btn-success confirm-cropped-upload w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Confirm Upload Modal -->
<!-- BEGIN: Create New Hotel Room Modal -->
<div id="create-new-room-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Add New Room</h2>
            </div>
            <div class="modal-body">
                <form id="image-upload" method="POST">
                    @csrf
                    <input type="file" id="thumbnail-upload" accept="image/*,image/heif,image/heic" name="image" hidden>
                </form>
                <form id="create-form" action="{{ route('room_management.store') }}" method="POST">
                    @csrf
                    <div class="flex justify-center mb-4">
                        <div class="w-56">
                            <div class="w-56 h-56 image-fit zoom-in">
                                <img src="{{ asset('/storage/static/images/nothumb.jpg') }}" id="thumbnail-preview" class="rounded-lg">
                            </div>
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
<!-- BEGIN: Crop Image for Upload Modal -->
<div id="image-crop-modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Thumbnail</h2>
                <a href="javascript:;" id="x-dismiss-modal"> <i data-feather="x" class="w-5 h-5 text-slate-400"></i> </a>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body p-4">
                <div class="flex justify-center image-darken w-full max-h-128">
                    <img src="" class="rounded-lg" id="picture-preview">
                </div>
                <div class="flex justify-center">
                    <div class="w-72 mt-4">
                        <div id="zoom-level-slider"></div>
                    </div>
                </div>
            </div>
            <!-- END: Modal Body -->
            <!-- BEGIN: Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="cancel-dismiss-modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                <button type="button" id="upload-cropped-image" class="btn btn-primary w-24">Save</button>
            </div>
            <!-- END: Modal Footer -->
        </div>
    </div>
</div>
<!-- END: Crop Image for Upload Modal -->
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="{{ asset('/dist/js/jquery-cropper.min.js') }}"></script>
<script src="{{ asset('/dist/js/nouislider.min.js') }}"></script>
<script src="{{ asset('/dist/js/datatables.js') }}"></script>
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

        function showModal(selector){
            const el = document.querySelector(selector);
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.show();
        }

        function hideModal(selector){
            const el = document.querySelector(selector);
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.hide();
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

        var rangeSlider = document.getElementById('zoom-level-slider');

        noUiSlider.create(rangeSlider, {
            start: [0],
            step: 0.001,
            connect: [true, false],
            range: {
                'min': [0],
                'max': [1.6667]
            }
        });

        const createFormImage = new FormData();

        $("#thumbnail-upload-trigger").click(function (e) {
            $("#thumbnail-upload").trigger('click');
        });

        $("#thumbnail-upload").off().change(function (e) {
            e.preventDefault();

            let form = document.getElementById("image-upload")
            let fd = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('thumbnail.store') }}",
                data: fd,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status == 1){
                        $.ajax({
                            type: "POST",
                            url: "{{ route('thumbnail.show') }}",
                            data: { submit: true },
                            dataType: "json",
                            success: function (response) {
                                showModal('#image-crop-modal');
                                $("#picture-preview").attr("src", response.location);
                                var $image = $('#picture-preview');

                                $image.cropper({
                                    aspectRatio: 1/1,
                                    dragMode: 'move',
                                    viewMode: 1,
                                    autoCropArea: 1,
                                    responsive: true,
                                    restore: false,
                                    guides: false,
                                    center: false,
                                    highlight: false,
                                    cropBoxMovable: false,
                                    cropBoxResizable: false,
                                    toggleDragModeOnDblclick: false,
                                    zoomOnWheel: false,
                                    ready: function() {
                                        // var canvasData = $image.cropper('getCanvasData');
                                        var cropBoxData = $image.cropper('getCropBoxData');
                                        var imageData = $image.cropper('getImageData');

                                        rangeSlider.noUiSlider.updateOptions({
                                            range: {
                                                'min': imageData.width / imageData.naturalWidth,
                                                'max': 1.667,
                                            }
                                        });

                                        rangeSlider.noUiSlider.set([imageData.width / imageData.naturalWidth]);

                                        rangeSlider.noUiSlider.on('slide', function () {
                                            $image.cropper('zoomTo', rangeSlider.noUiSlider.get());
                                        });

                                        $(window).resize(function () {
                                            if(window.innerWidth < 1023) {
                                                rangeSlider.noUiSlider.updateOptions({
                                                    range: {
                                                        'min': $(".cropper-crop-box").width() / imageData.naturalWidth,
                                                        'max': 1.667,
                                                    }
                                                });
                                            }
                                            else {
                                                rangeSlider.noUiSlider.updateOptions({
                                                    range: {
                                                        'min': imageData.width / imageData.naturalWidth,
                                                        'max': 1.667,
                                                    }
                                                });
                                            }
                                        });
                                    },
                                });

                                var cropper = $image.data('cropper');
                                $("#upload-cropped-image").click(function (e) {
                                    e.preventDefault();

                                    showModal("#confirm-upload-modal");
                                        $(".confirm-cropped-upload").off().click(function (e) {
                                            $image.cropper("getCroppedCanvas").toBlob((blob) => {
                                            createFormImage.append('image', blob);

                                            console.log(createFormImage);

                                            const fd = new FormData();
                                            fd.append('image', blob);

                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('thumbnail.store') }}",
                                                data: fd,
                                                dataType: "json",
                                                cache: false,
                                                processData: false,
                                                contentType: false,
                                                success: function (response) {
                                                    hideModal("#image-crop-modal");
                                                    $("#thumbnail-preview").attr("src", response.location);
                                                    $("#thumbnail-upload").val(null);
                                                    $("#picture-preview").removeAttr("src");
                                                    $image.cropper("destroy");
                                                    rangeSlider.noUiSlider.reset();
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "{{ route('image.destroy') }}",
                                                        data: { submit: true },
                                                        dataType: "json",
                                                    });
                                                }
                                            });
                                        });
                                    });
                                });

                                $("#x-dismiss-modal, #cancel-dismiss-modal").click(function (e) {
                                    showModal("#discard-upload-modal");
                                    $("#confirm-discard-upload").off().click(function (e) {
                                        $("#thumbnail-upload").val(null);
                                        $("#picture-preview").removeAttr("src");
                                        $image.cropper("destroy");
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ route('thumbnail.destroy') }}",
                                            data: { submit: true },
                                            dataType: "json",
                                            success: function (response) {
                                                hideModal("#image-crop-modal");
                                                hideModal("#discard-upload-modal");
                                                rangeSlider.noUiSlider.reset();
                                            },
                                        });
                                    });
                                });
                            }
                        });
                    }
                },
                error: function (xhr) {
                    if(xhr.status == 422){
                        showModal("#error-modal");
                        $("#thumbnail-upload").val(null);
                    }
                }
            });
        });

        $("#create-form").submit(function (e) {
            loading("#create-form-submit");
            e.preventDefault();

            let form = document.getElementById("create-form")
            let fd = new FormData(form);

            fd.append('image', createFormImage.get('image'));

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
