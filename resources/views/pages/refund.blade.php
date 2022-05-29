@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Transactions</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Return/Refund</h2>
        <!-- BEGIN: User/Staff List -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <input type="text" class="form-control w-72 mr-4" id="transaction-id" placeholder="Transaction ID">
            <button class="btn btn-primary shadow-md mr-2" id="search-transaction">Search Transaction</button>
        </div>
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="refund-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">ID</th>
                            <th class="whitespace-nowrap">TRANSACTION ID</th>
                            <th class="whitespace-nowrap">PRODUCT</th>
                            <th class="whitespace-nowrap">UNIT PRICE</th>
                            <th class="whitespace-nowrap">QUANTITY</th>
                            <th class="whitespace-nowrap">SUBTOTAL</th>
                            <th class="whitespace-nowrap">REFUNDED</th>
                            <th class="whitespace-nowrap">DATE & TIME</th>
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
<!-- BEGIN: Warning Upload Modal -->
<div id="confirm-return-action-modal" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="alert-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Warning!</div>
                    <div class="text-slate-500 mt-2">You are attempting to return an item.<br>Confirm this action?</div>
                </div>
                <div class="px-5 pb-8 text-center"><button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" id="confirm-return-click" data-tw-dismiss="modal" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Warning Upload Modal -->
<!-- BEGIN: Create New Staff Modal -->
<div id="return-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">Return/Refund</h2>
            </div>
            <div class="modal-body">
                <form id="return-form" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="transaction_id" class="form-label">Transaction ID</label>
                        <input id="transaction_id" type="text" class="form-control" placeholder="Juan S. Dela Cruz">
                        <span class="validation-error error-name {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="form-label">Product Name</label>
                        <input id="name" type="text" class="form-control" placeholder="Juan S. Dela Cruz">
                        <span class="validation-error error-name {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                    </div>
                    <div class="mb-4">
                        <label for="quantity" class="form-label">Quantity to Return</label>
                        <input id="quantity" type="number" class="form-control" name="quantity" placeholder="Juan S. Dela Cruz">
                        <span class="validation-error error-name {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                    </div>
                    <button type="submit" class="btn btn-primary w-full mr-1 mb-2 mt-4">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: Create new Staff Modal -->
<!-- BEGIN: Danger Notification -->
<div id="danger-notification" class="toastify-content hidden flex"> <i class="text-danger" data-feather="x-circle"></i>
    <div class="ml-4 mr-4">
        <div id="danger-notification-title" class="font-medium"></div>
        <div id="danger-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Danger Notification -->
<!-- BEGIN: Successful Notification -->
<div id="success-notification" class="toastify-content hidden flex"> <i class="text-success" data-feather="check-circle"></i>
    <div class="ml-4 mr-4">
        <div id="success-notification-title" class="font-medium"></div>
        <div id="success-notification-content" class="text-slate-500 mt-1"></div>
    </div>
</div>
<!-- END: Successful Notification -->
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

        function clearForm(selector){
            $(selector).trigger("reset");
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

        function hideModal(selector){
            const el = document.querySelector(selector);
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.hide();
        }

        function showModal(selector){
            const el = document.querySelector(selector);
            const modal = tailwind.Modal.getOrCreateInstance(el);
            modal.show();
        }

        function showDangerNotification(title, content){
            Toastify({
                node: $("#danger-notification")
                    .clone()
                    .removeClass("hidden")[0],
                duration: 5000,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            $("#danger-notification-title").text(title);
            $("#danger-notification-content").text(content);
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

        $("#search-transaction").click(function (e) {
            e.preventDefault();

            const id = $("#transaction-id").val() == "" ? 0 : $("#transaction-id").val();

            var table = $("table").DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                autoWidth: false,
                autoHeight: false,
                responsive: true,
                pageResize: false,

                ajax: {
                    url: "{{ route('datatables') }}" + "/refund-items/" + id,
                },

                columns: [
                    {data: "id", name: "id"},
                    {data: "transaction_id", name: "transaction_id"},
                    {data: "name", name: "name"},
                    {data: "price", name: "price"},
                    {data: "quantity", name: "quantity"},
                    {data: "total", name: "total"},
                    {data: "refunded", name: "refunded"},
                    {data: "date", name: "date"},
                    {data: "actions", name: "actions"}
                ],

                columnDefs: [
                    {
                        targets: [-1],
                        className: "table-report__action",
                    },
                    {
                        targets: [0, 1, 2, 3, 4, 5, 6],
                        className: "text-center",
                    },
                ]
            });
            table.destroy();
        });

        $("#refund-table").on("click", "#return", function () {
            const id = $(this).data('id');
            const tid = $("#transaction-id").val();
            showModal("#confirm-return-action-modal");

            $("#confirm-return-click").off().click(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('refund.show') }}",
                    data: { id: id, tid: tid },
                    dataType: "json",
                    success: function (response) {
                        if (response.status == 1){
                            showSlideover("#return-modal");
                            $("#transaction_id").val(response.data.transaction_id);
                            $("#name").val(response.data.name);
                            $("#quantity").val(response.data.quantity);

                            $("#return-form").submit(function (e) {
                                e.preventDefault();
                                const quantity = $("#quantity").val();
                                $.ajax({
                                    type: "POST",
                                    url: "{{ route('refund.store') }}",
                                    data: {id: id, tid: tid, quantity: quantity},
                                    dataType: "json",
                                    success: function (response) {
                                        clearForm("#return-form");
                                        hideSlideover("#return-modal");
                                        showSuccessNotification("Operation successful!", "Return/refund successfully processed.")
                                    }
                                });
                            });
                        }
                        else {
                            showDangerNotification("Operation failed!", response.message);
                        }
                    }
                });
            });
        });
    });
</script>
@endsection
