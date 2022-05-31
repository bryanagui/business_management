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
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Categories</h2>
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <input type="text" class="form-control w-72 mr-2" id="category-name" placeholder="Add Category...">
            <button class="btn btn-primary shadow-md mr-2" id="add-category-button"><i class="fa-solid fa-plus"></i></button>
        </div>
        <!-- BEGIN: Category List -->
        <div class="col-span-12 mt-6" id="categories-content">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0 w-1/2">
                <table class="table table-report w-24 sm:mt-2" id="categories-table">
                    <thead>
                        <th class="whitespace-nowrap">ID</th>
                        <th class="whitespace-nowrap">NAME</th>
                        <th class="whitespace-nowrap">DATE</th>
                        <th class="whitespace-nowrap">ACTIONS</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END: Category List -->
    </div>
</div>
@endsection

@section('modal')
<!-- BEGIN: Successful Notification -->
<div id="success-notification" class="toastify-content hidden flex"> <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div id="success-notification-title" class="font-medium"></div>
        <div id="success-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Successful Notification -->
<!-- BEGIN: Confirm Add Modal -->
<div id="confirm-add-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="check-circle" class="w-16 h-16 text-success mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Confirm</div>
                    <div class="text-slate-500 mt-2">Are you sure you'd want to add this category?</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" data-tw-dismiss="modal" class="btn btn-success confirm-add-category w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Confirm Add Modal -->
<!-- BEGIN: Confirm Delete Modal -->
<div id="confirm-delete-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="x-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Confirm</div>
                    <div class="text-slate-500 mt-2">Items under this category will be inaccessible until:<br>• You create a category under the same name; or<br>• You update the items' category to an existing one<br><br>Are you sure you want to continue?</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" data-tw-dismiss="modal" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} confirm-delete-category w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Confirm Delete Modal -->
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

        function reloadCategory(){
            $("#categories-content").load(location.href + " #categories-content");
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

        function showSuccessNotification(title, content){
            Toastify({
                node: $("#success-notification")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            $("#success-notification-title").text(title);
            $("#success-notification-content").text(content);
        }

        var table = $("#categories-table").DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            autoWidth: false,
            autoHeight: false,
            responsive: true,
            pageResize: false,

            ajax: {
                url: "{{ route('datatables.categories') }}",
            },

            columns: [
                {data: "id", name: "id"},
                {data: "name", name: "name"},
                {data: "date", name: "date"},
                {data: "actions", name: "actions"}
            ],

            columnDefs: [
                {
                    targets: [0, 1, 2],
                    className: "text-center",
                },
                {
                    targets: [-1],
                    className: "table-report__action w-8"
                }
            ]
        });

        $("#add-category-button").click(function (e) {
            e.preventDefault();
            showModal('#confirm-add-modal');
                $(".confirm-add-category").off().click(function (e) {
                    e.preventDefault();
                    $.ajax({
                    type: "POST",
                    url: "{{ route('category.store') }}",
                    data: { name: $("#category-name").val() },
                    dataType: "json",
                    success: function (response) {
                        reloadCategory();
                        showSuccessNotification('Operation Successful!', response.message);
                        $("#category-name").val(null);
                        hideModal("#confirm-add-modal");
                    }
                });
            });
        });

        $("div#categories-content").on("click", "#delete", function () {
            const id = $(this).data('id');
            showModal('#confirm-delete-modal');
            $(".confirm-delete-category").off().click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('category') }}" + "/destroy/" + id,
                    data: { submit: true },
                    dataType: "json",
                    success: function (response) {
                        table.ajax.reload();
                        showSuccessNotification('Operation Successful!', response.message);
                        hideModal("#confirm-delete-modal");
                    }
                });
            });
        });
    });
</script>
@endsection
