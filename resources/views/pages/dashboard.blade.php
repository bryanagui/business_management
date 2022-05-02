@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Dashboard</title>
<link href="http://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('dist/css/cropper.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/form-range.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/nouislider.css') }}" />
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6">
    <div class="col-span-12 2xl:col-span-9">
        <!-- BEGIN: Profile Info -->
        <div class="intro-y box px-5 pt-5 mt-5">
            <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <img alt="Profile Picture" class="rounded-full profile-picture" src="{{ empty(Auth::user()->photo) ? asset('storage/static/images') . '/null.jpg' : asset('storage/static/images') . '/' . Auth::user()->photo }}" data-action="zoom">
                        <div class="absolute mb-1 mr-1 flex items-center justify-center bottom-0 right-0 bg-primary rounded-full p-2">
                            <form id="image-upload" method="POST">
                                @csrf
                                <input type="file" id="dp-file-upload" accept="image/*,image/heif,image/heic" name="image" hidden>
                            </form>
                            <button type="button" class="rounded-full change-dp" id="image-upload-trigger"><i class="w-4 h-4 text-white" data-feather="camera"></i></button>
                        </div>
                    </div>
                    <div class="ml-2">
                        <div class="sm:w-72 sm:whitespace-normal font-medium text-lg">{{ Auth::user()->name }}</div>
                        <div class="text-slate-500">{{ Auth::user()->getRoleNames()[0] }}</div>
                    </div>
                </div>
                <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                    <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                    <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                        <div class="truncate sm:whitespace-normal flex items-center">
                            <i data-feather="mail" class="w-4 h-4 mr-2"></i> {{ Auth::user()->email }}
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-3">
                            <i data-feather="phone" class="w-4 h-4 mr-2"></i> {{ Auth::user()->contact }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Profile Info -->
        <div class="grid grid-cols-12 gap-6">
            <!-- BEGIN: Today's Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">My Daily Report</h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Total Revenue</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-pending"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Accomodation Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="shopping-cart" class="report-box__icon text-warning"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Product Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="heart" class="report-box__icon text-success"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>0 / {{ \App\Models\Room::count() }}</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Rooms</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Today's Report -->
            <!-- BEGIN: Weekly Report -->
            <div class="col-span-12 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Total Daily Report</h2>
                </div>
                <div class="grid grid-cols-12 gap-6 mt-5">
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="dollar-sign" class="report-box__icon text-primary"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Total Revenue</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="user" class="report-box__icon text-pending"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Accomodation Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="shopping-cart" class="report-box__icon text-warning"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>₱</span>
                                    <span>0.00</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Product Sales</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                        <div class="report-box zoom-in">
                            <div class="box p-5">
                                <div class="flex">
                                    <i data-feather="heart" class="report-box__icon text-success"></i>
                                </div>
                                <div class="text-3xl font-medium leading-8 mt-6">
                                    <span>0 / {{ \App\Models\Room::count() }}</span>
                                </div>
                                <div class="text-base text-slate-500 mt-1">Rooms</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Weekly Report -->
            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 lg:col-span-6 mt-8">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Sales Report</h2>
                </div>
                <div class="intro-y box p-5 mt-12 sm:mt-5">
                    <div class="flex flex-col xl:flex-row xl:items-center">
                        <div class="flex">
                            <div>
                                <div class="text-primary dark:text-slate-300 text-lg xl:text-xl font-medium">0</div>
                                <div class="mt-0.5 text-slate-500">This Week</div>
                            </div>
                            <div class="w-px h-12 border border-r border-dashed border-slate-200 dark:border-darkmode-300 mx-4 xl:mx-5"></div>
                            <div>
                                <div class="text-slate-500 text-lg xl:text-xl font-medium">0</div>
                                <div class="mt-0.5 text-slate-500">Last Week</div>
                            </div>
                        </div>
                    </div>
                    <div class="report-chart">
                        <canvas id="report-line-chart" height="169" class="mt-6"></canvas>
                    </div>
                </div>
            </div>
            <!-- END: Sales Report -->
            <!-- BEGIN: Weekly Top Seller -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Weekly Top Seller</h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="report-pie-chart" height="300"></canvas>
                    <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                            <span class="truncate">17 - 30 Years old</span>
                            <span class="font-medium xl:ml-auto">62%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                            <span class="truncate">31 - 50 Years old</span>
                            <span class="font-medium xl:ml-auto">33%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                            <span class="truncate">>= 50 Years old</span>
                            <span class="font-medium xl:ml-auto">10%</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Weekly Top Seller -->
            <!-- BEGIN: Sales Report -->
            <div class="col-span-12 sm:col-span-6 lg:col-span-3 mt-8">
                <div class="intro-y flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Sales Report</h2>
                </div>
                <div class="intro-y box p-5 mt-5">
                    <canvas class="mt-3" id="report-donut-chart" height="300"></canvas>
                    <div class="mt-8">
                        <div class="flex items-center">
                            <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                            <span class="truncate">17 - 30 Years old</span>
                            <span class="font-medium xl:ml-auto">62%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                            <span class="truncate">31 - 50 Years old</span>
                            <span class="font-medium xl:ml-auto">33%</span>
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="w-2 h-2 bg-warning rounded-full mr-3"></div>
                            <span class="truncate">>= 50 Years old</span>
                            <span class="font-medium xl:ml-auto">10%</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Sales Report -->
            <!-- BEGIN: Weekly Top Products -->
            <div class="col-span-12 mt-6">
                <div class="intro-y block sm:flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">Weekly Top Products</h2>
                </div>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2" id="weekly-top-products-table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">IMAGE</th>
                                <th class="whitespace-nowrap">PRODUCT NAME</th>
                                <th class="text-center whitespace-nowrap">STOCK</th>
                                <th class="text-center whitespace-nowrap">STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_slice($fakers, 0, 10) as $faker)
                            <tr class="intro-x">
                                <td class="w-40">
                                    <div class="flex">
                                        <div class="w-10 h-10 image-fit zoom-in">
                                            <img alt="Rubick Tailwind HTML Admin Template" class="tooltip rounded-full" src="{{ asset('dist/images/' . $faker['images'][0]) }}" title="Uploaded at {{ $faker['dates'][0] }}">
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="" class="font-medium whitespace-nowrap">{{ $faker['products'][0]['name'] }}</a>
                                    <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $faker['products'][0]['category'] }}</div>
                                </td>
                                <td class="text-center">{{ $faker['stocks'][0] }}</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center {{ $faker['true_false'][0] ? 'text-success' : 'text-danger' }}">
                                        <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Weekly Top Products -->
        </div>
    </div>
    <div class="col-span-12 2xl:col-span-3">
        <div class="2xl:border-l -mb-10 pb-10">
            <div class="2xl:pl-6 grid grid-cols-12 gap-6">
                <!-- BEGIN: Transactions -->
                <div class="col-span-12 md:col-span-12 xl:col-span-12 2xl:col-span-12 mt-3 2xl:mt-8">
                    <div class="intro-x flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">Recent Transactions</h2>
                    </div>
                    <div class="mt-5">
                        @foreach (array_slice($fakers, 0, 20) as $faker)
                        <div class="intro-x">
                            <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                                <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                    <img alt="Rubick Tailwind HTML Admin Template" src="{{ asset('dist/images/' . $faker['photos'][0]) }}">
                                </div>
                                <div class="ml-4 mr-auto">
                                    <div class="font-medium">{{ $faker['users'][0]['name'] }}</div>
                                    <div class="text-slate-500 text-xs mt-0.5">{{ $faker['dates'][0] }}</div>
                                </div>
                                <div class="{{ $faker['true_false'][0] ? 'text-success' : 'text-danger' }}">{{ $faker['true_false'][0] ? '+' : '-' }}${{ $faker['totals'][0] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('modal')
<!-- BEGIN: Crop Image for Upload Modal -->
<div id="image-crop-modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <!-- BEGIN: Modal Header -->
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Edit Profile Picture</h2>
                <a href="javascript:;" id="x-dismiss-modal"> <i data-feather="x" class="w-5 h-5 text-slate-400"></i> </a>
            </div>
            <!-- END: Modal Header -->
            <!-- BEGIN: Modal Body -->
            <div class="modal-body p-4">
                <div class="flex justify-center image-darken w-full max-h-128">
                    <img src="" class="rounded-lg" id="change-picture-preview">
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
                    <div class="text-slate-500 mt-2">Are you sure you want to continue with your current changes?<br>Your profile picture will be updated.</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" data-tw-dismiss="modal" class="btn btn-success confirm-cropped-upload w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Confirm Upload Modal -->
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script src="{{ asset('/dist/js/jquery-cropper.min.js') }}"></script>
<script src="{{ asset('/dist/js/nouislider.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

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

        function loading(selector){
            $(selector).html('<i data-loading-icon="oval" data-color="white" class="w-4 h-4 mx-auto"></i>');
            tailwind.svgLoader();
            $(selector).attr("disabled", "true");
        }

        function finishedLoadingUploadButton(selector){
            $(selector).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera w-4 h-4 text-white"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>');
            $(selector).removeAttr("disabled")
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

        $(".change-dp").click(function (e) {
            e.preventDefault();
            $("#dp-file-upload").trigger("click");
        });

        $("#dp-file-upload").off().change(function (e) {
            e.preventDefault();
            loading(".change-dp")
            let form = document.getElementById("image-upload")
            let fd = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('image.store') }}",
                data: fd,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    finishedLoadingUploadButton(".change-dp")
                    if(response.status == 1){
                        $.ajax({
                            type: "POST",
                            url: "{{ route('image.show') }}",
                            data: { submit: true },
                            dataType: "json",
                            success: function (response) {
                                showModal('#image-crop-modal');
                                $("#change-picture-preview").attr("src", response.location);
                                var $image = $('#change-picture-preview');

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
                                        $(".confirm-cropped-upload").click(function (e) {
                                            $image.cropper("getCroppedCanvas").toBlob((blob) => {
                                            const formData = new FormData();
                                            formData.append('image', blob);

                                            $.ajax({
                                                type: "POST",
                                                url: "{{ route('image.update') }}",
                                                data: formData,
                                                dataType: "json",
                                                cache: false,
                                                processData: false,
                                                contentType: false,
                                                success: function (response) {
                                                    hideModal("#image-crop-modal");
                                                    $(".profile-picture, .top-bar-profile").attr("src", response.image);
                                                    $("#dp-file-upload").val(null);
                                                    $("#change-picture-preview").removeAttr("src");
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
                                        $("#dp-file-upload").val(null);
                                        $("#change-picture-preview").removeAttr("src");
                                        $image.cropper("destroy");
                                        $.ajax({
                                            type: "POST",
                                            url: "{{ route('image.destroy') }}",
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
                        $("#dp-file-upload").val(null);
                    }
                }
            });
        });
    });
</script>
@endsection
