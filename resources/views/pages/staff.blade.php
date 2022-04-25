@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Staff</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">User Management</h2>
        <!-- BEGIN: User/Staff List -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-new-staff-modal">Add New User/Staff</button>
        </div>
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="staff-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">IMAGE</th>
                            <th class="whitespace-nowrap">NAME</th>
                            <th class="text-center whitespace-nowrap">AGE</th>
                            <th class="whitespace-nowrap">ADDRESS</th>
                            <th class="whitespace-nowrap">EMAIL</th>
                            <th class="whitespace-nowrap">CONTACT NO.</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: User/Staff List -->
    </div>
</div>
@endsection

@section('modal')
<!-- BEGIN: Successful Notification -->
<div id="staff-success-notification" class="toastify-content hidden flex"> <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div id="staff-success-notification-title" class="font-medium"></div>
        <div id="staff-success-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Successful Notification -->
<!-- BEGIN: Danger Notification -->
<div id="staff-danger-notification" class="toastify-content hidden flex"> <i class="text-danger" data-feather="x-circle"></i>
    <div class="ml-4 mr-4">
        <div id="staff-danger-notification-title" class="font-medium"></div>
        <div id="staff-danger-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Danger Notification -->
<!-- BEGIN: Create New Staff Modal -->
<div id="create-new-staff-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Add New User/Staff</h2>
            </div>
            <div class="modal-body">
                <form id="create-form" action="{{ route('staff.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="create-full-name" class="form-label">Full Name</label>
                        <input id="create-full-name" type="text" class="form-control" name="name" placeholder="Juan S. Dela Cruz">
                        <span class="validation-error error-name {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4"> <label>Gender</label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            <div class="form-check mr-2"> <input id="create-gender-male" class="form-check-input" type="radio" name="gender" value="male"> <label class="form-check-label" for="radio-switch-4">Male</label> </div>
                            <div class="form-check mr-2 mt-2 sm:mt-0"> <input id="create-gender-female" class="form-check-input" type="radio" name="gender" value="female"> <label class="form-check-label" for="radio-switch-5">Female</label> </div>
                        </div>
                        <span class="validation-error error-gender {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-address" class="form-label">Address</label>
                        <input id="create-address" type="text" class="form-control" name="address" placeholder="Seoul, South Korea">
                        <span class="validation-error error-address {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-email" class="form-label">Email</label>
                        <input id="create-email" type="email" class="form-control" name="email" placeholder="juandelacruz@example.com">
                        <span class="validation-error error-email {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-confirm-email" class="form-label">Confirm Email</label>
                        <input id="create-confirm-email" type="email" name="email_confirmation" class="form-control" placeholder="juandelacruz@example.com">
                    </div>
                    <div class="mb-4">
                        <label for="create-password" class="form-label">Password</label>
                        <input id="create-password" type="password" class="form-control" name="password" placeholder="Password">
                        <span class="validation-error error-password {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-confirm-password" class="form-label">Confirm Password</label>
                        <input id="create-confirm-password" type="password" name="password_confirmation" class="form-control" placeholder="Password">
                    </div>
                    <div class="mb-4">
                        <label for="create-date" class="form-label">Date of Birth</label>
                        <input id="create-date" type="text" readonly="readonly" name="birthdate" class="datepicker form-control block mx-auto" data-single-mode="true">
                        <span class="validation-error error-birthdate {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="create-contact" class="form-label">Contact Number</label>
                        <input id="create-contact" type="text" class="form-control" name="contact" placeholder="0912 345 6789">
                        <span class="validation-error error-contact {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <button type="submit" id="create-form-submit" class="btn btn-primary w-full mr-1 mb-2 mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Create new Staff Modal -->
<!-- BEGIN: Edit Staff Modal -->
<div id="edit-staff-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Edit Staff</h2>
            </div>
            <div class="modal-body">
                <form id="edit-form" method="POST" autocomplete="off">
                    @method('patch')
                    @csrf
                    <div class="mb-4">
                        <label for="edit-name" class="form-label">Full Name</label>
                        <input id="edit-name" type="text" class="form-control" name="name" placeholder="Juan S. Dela Cruz">
                        <span class="validation-error error-name {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4"> <label>Gender</label>
                        <div class="flex flex-col sm:flex-row mt-2">
                            <div class="form-check mr-2"> <input id="edit-gender-male" class="form-check-input" type="radio" name="gender" value="male"> <label class="form-check-label" for="radio-switch-4">Male</label> </div>
                            <div class="form-check mr-2 mt-2 sm:mt-0"> <input id="edit-gender-female" class="form-check-input" type="radio" name="gender" value="female"> <label class="form-check-label" for="radio-switch-5">Female</label> </div>
                        </div>
                        <span class="validation-error error-gender {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="edit-address" class="form-label">Address</label>
                        <input id="edit-address" type="text" class="form-control" name="address" placeholder="Seoul, South Korea">
                        <span class="validation-error error-address {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="edit-email" class="form-label">Email</label>
                        <input id="edit-email" type="email" class="form-control" name="email" placeholder="juandelacruz@example.com">
                        <span class="validation-error error-email {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="edit-date" class="form-label">Date of Birth</label>
                        <input id="edit-date" type="text" readonly="readonly" name="birthdate" class="datepicker form-control block mx-auto" data-single-mode="true">
                        <span class="validation-error error-birthdate {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <div class="mb-4">
                        <label for="edit-contact" class="form-label">Contact Number</label>
                        <input id="edit-contact" type="text" class="form-control" name="contact" placeholder="0912 345 6789">
                        <span class="validation-error error-contact {{ $dark_mode ? 'text-warning' : 'text-danger' }} "><span>
                    </div>
                    <button type="submit" id="edit-form-submit" class="btn btn-primary w-full mr-1 mb-2 mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Edit Staff Modal -->
<!-- BEGIN: View Staff Modal -->
<div id="view-staff-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">View Staff</h2>
            </div>
            <div class="modal-body">
                <div class="flex justify-center">
                    <div class="w-64 h-64 image-fit zoom-in">
                        <img src="" id="view-staff-image" class="rounded-lg">
                    </div>
                </div>
            </div>
            <!-- BEGIN: Name -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-name"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Name</div>
                    </div>
                </div>
            </div>
            <!-- END: Name -->
            <!-- BEGIN: Gender -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center capitalize" id="view-staff-gender"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Gender</div>
                    </div>
                </div>
            </div>
            <!-- END: Gender -->
            <!-- BEGIN: Age -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-age"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Age</div>
                    </div>
                </div>
            </div>
            <!-- END: Age -->
            <!-- BEGIN: Birthdate -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-date"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Birthdate</div>
                    </div>
                </div>
            </div>
            <!-- END: Birthdate -->
            <!-- BEGIN: Address -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-address"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Address</div>
                    </div>
                </div>
            </div>
            <!-- END: Address -->
            <!-- BEGIN: Email -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-email"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Email</div>
                    </div>
                </div>
            </div>
            <!-- END: Email -->
            <!-- BEGIN: Creation Date -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-created"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Creation Date</div>
                    </div>
                </div>
            </div>
            <!-- END: Creation Date -->
            <!-- BEGIN: Archive Date -->
            <div class="flex justify-center">
                <div class="intro-x w-5/6">
                    <div class="box px-5 py-3 mb-3 zoom-in">
                        <div class="font-medium text-center" id="view-staff-deleted"></div>
                        <div class="text-slate-500 text-xs mt-0.5 text-center">Archive Date</div>
                    </div>
                </div>
            </div>
            <!-- END: Archive Date -->
        </div>
    </div>
</div>
<!-- END: View Staff Modal -->
<!-- BEGIN: Delete/Deactivate User Modal -->
<div id="deactivate-staff-modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to archive these records? <br>These records can be restored later.</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" id="confirm-staff-deactivate" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">Archive</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Delete/Deactivate User Modal -->
<!-- BEGIN: Restore User Modal -->
<div id="restore-staff-modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-warning mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to restore these records? <br>The user owning these records can perform actions again.</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" id="confirm-staff-restore" class="btn btn-warning w-24">Restore</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Restore User Modal -->
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

        function clearCreateModal(){
            $('#create-form').trigger("reset");;
            $('span.validation-error').text('');
        }

        function clearEditModal(){
            $('#edit-form').trigger("reset");;
            $('span.validation-error').text('');
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
                node: $("#staff-success-notification")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            $("#staff-success-notification-title").text(title);
            $("#staff-success-notification-content").text(content);
        }

        function showDangerNotification(title, content){
            Toastify({
                node: $("#staff-danger-notification")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            $("#staff-danger-notification-title").text(title);
            $("#staff-danger-notification-content").text(content);
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

        var table = $("#staff-table").DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            autoWidth: false,
            autoHeight: false,
            responsive: true,
            pageResize: false,

            ajax: {
                url: "{{ route('datatables.staff') }}",
            },

            columns: [
                {data: "id", name: "id"},
                {data: "photo", name: "photo"},
                {data: "name", render: function(data, type, full, meta){
                    return '<span class="font-medium whitespace-nowrap">'+ full.name +'</span>\n' + '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">'+ full.role +'</div>'
                }},
                {data: "age", name: "age"},
                {data: "address", name: "address"},
                {data: "email", name: "email"},
                {data: "contact", name: "contact"},
                {data: "status", name: "status"},
                {data: "actions", name: "actions"}
            ],

            columnDefs: [
                {
                    targets: [0, 3, 4, 7],
                    className: "text-center",
                },
                {
                    targets: [1],
                    className: "w-24"
                },
                {
                    targets: [-1],
                    className: "table-report__action w-20"
                }
            ]
        });

        $("#create-form").submit(function (e) {
            loading("#create-form-submit");
            e.preventDefault();

            let form = document.getElementById("create-form")
            let fd = new FormData(form);
            $.ajax({
                type: "POST",
                url: "{{ route('staff.store') }}",
                data: fd,
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    if(response.status == 1){
                        finishedLoading("#create-form-submit", "Submit");
                        hideSlideover("#create-new-staff-modal")
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

        $("table").on('click', '#view', function (e) {
            showSlideover("#view-staff-modal");

            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{{ route('staff') }}" + "/show/" + id,
                data: { submit: true },
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#view-staff-image").attr('src', response.parsed.image);
                    $.each(response.data, function (i, v) {
                        $("#view-staff-"+i).text(v);
                    });
                    $.each(response.parsed, function (i, v) {
                        $("#view-staff-"+i).text(v);
                    });
                },
            });
        });

        $("table").on('click', '#edit', function (e) {
            showSlideover("#edit-staff-modal");

            var id = $(this).data("id");
            $.ajax({
                type: "POST",
                url: "{{ route('staff') }}" + "/edit/" + id,
                data: { submit: true },
                dataType: "json",
                cache: false,
                processData: false,
                contentType: false,
                success: function (response) {
                    $.each(response.data, function (i, v) {
                         $("#edit-"+i).val(v);
                    });
                    response.data.gender == "female" ? $("#edit-gender-female").prop("checked", true) : $("#edit-gender-male").prop("checked", true);
                    $("#edit-date").val(response.parsed.birthdate);
                },
            });

            $("#edit-form").off().submit(function (e) {
                loading("#edit-form-submit");
                e.preventDefault();

                let form = document.getElementById("edit-form");
                let fd = new FormData(form);
                $.ajax({
                    type: "POST",
                    url: "{{ route('staff') }}" + "/update/" + id,
                    data: fd,
                    dataType: "json",
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if(response.status == 1){
                            finishedLoading("#edit-form-submit", "Submit");
                            hideSlideover("#edit-staff-modal")
                            clearEditModal();
                            showSuccessNotification(response.title, response.content);
                            table.ajax.reload();
                        }
                    },
                    error: function (xhr) {
                        if(xhr.status == 422){
                            var errors = xhr.responseJSON.errors;
                            $('#edit-form').find('span.validation-error').text('');
                            $.each(errors, function (s, v) {
                                $('#edit-form').find('span.error-'+s).text(v[0]);
                            });
                        }
                        finishedLoading("#edit-form-submit", "Submit");
                    }
                });
            });
        });

        $("table").on('click', '#archive', function (e) {
            e.preventDefault();
            showModal("#deactivate-staff-modal");

            var id = $(this).data("id");
            $("#confirm-staff-deactivate").off().click(function (e) {
                loading("#confirm-staff-deactivate");
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('staff') }}" + "/destroy/" + id,
                    data: { submit: true },
                    dataType: "json",
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        switch(response.status){
                            case 1:
                                showSuccessNotification(response.title, response.content);
                                break;
                            default:
                                showDangerNotification(response.title, response.content);
                                break;
                        }
                        finishedLoading("#confirm-staff-deactivate", "Archive");
                        hideModal("#deactivate-staff-modal");
                        table.ajax.reload();
                    },
                });
            });
        });

        $("table").on('click', '#restore', function (e) {
            e.preventDefault();
            showModal("#restore-staff-modal");

            var id = $(this).data("id");
            $("#confirm-staff-restore").off().click(function (e) {
                loading("#confirm-staff-restore");
                $.ajax({
                    type: "PATCH",
                    url: "{{ route('staff') }}" + "/restore/" + id,
                    data: { submit: true },
                    dataType: "json",
                    cache: false,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        showSuccessNotification(response.title, response.content);
                        finishedLoading("#confirm-staff-restore", "Restore");
                        hideModal("#restore-staff-modal");
                        table.ajax.reload();
                    },
                });
            });
        });
    });
</script>
@endsection
