@extends('../layout/' . $layout)

@section('subhead')
<title>Resale - Transaction History</title>
<link href="http://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('dist/css/square-cropper.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/form-range.css') }}" />
<link rel="stylesheet" href="{{ asset('dist/css/nouislider.css') }}" />
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Transaction History</h2>
        <!-- BEGIN: Logs -->
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="transactions-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">NO.</th>
                            <th class="whitespace-nowrap">PHOTO</th>
                            <th class="whitespace-nowrap">TRANSACTION ID</th>
                            <th class="whitespace-nowrap">TYPE</th>
                            <th class="whitespace-nowrap">TRANSACTION BY</th>
                            <th class="whitespace-nowrap">SUBTOTAL</th>
                            <th class="whitespace-nowrap">PAYMENT</th>
                            <th class="whitespace-nowrap">CHANGE</th>
                            <th class="text-center whitespace-nowrap">DATE</th>
                            <th class="whitespace-nowrap">ACTION</th>
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

@section('modal')
<!-- BEGIN: View Transaction Modal -->
<div id="view-transaction-modal" class="modal modal-slide-over" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content"> <a data-tw-dismiss="modal" href="javascript:;"> <i data-feather="x" class="w-8 h-8 text-slate-400"></i> </a>
            <div class="modal-header p-5">
                <h2 class="font-medium text-base mr-auto">View Transaction</h2>
            </div>
            <div class="modal-body">
                <div class="flex justify-center">
                    <div class="px-6 py-6">
                        <div class="overflow-x-auto">
                            <table class="table w-full" id="items-table">
                                <thead>
                                    <tr>
                                        <th class="whitespace-nowrap">TRANSACTION ID</th>
                                        <th class="whitespace-nowrap">PRODUCT</th>
                                        <th class="whitespace-nowrap">PRICE</th>
                                        <th class="whitespace-nowrap">QTY</th>
                                        <th class="whitespace-nowrap">TOTAL</th>
                                        <th class="whitespace-nowrap">REFUNDED</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                    <div class="text-center sm:text-right sm:ml-auto">
                        <div class="text-xl text-primary font-medium mt-2" id="amount">₱ 0.00</div>
                        <div class="text-base text-slate-500">Total Amount</div>

                        <div class="text-xl text-primary font-medium mt-4" id="paid">₱ 0.00</div>
                        <div class="text-base text-slate-500">Amount Paid</div>

                        <div class="text-xl text-primary font-medium mt-4" id="change">₱ 0.00</div>
                        <div class="text-base text-slate-500">Change</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: View Transaction Modal -->
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

        var table = $("#transactions-table").DataTable({
            processing: true,
            ordering: false,
            serverSide: true,
            autoWidth: false,
            autoHeight: false,
            responsive: true,
            pageResize: false,

            ajax: {
                url: "{{ route('datatables.transaction_history') }}",
            },

            columns: [
                {data: "id", name: "id"},
                {data: "photo", name: "photo"},
                {data: "transaction_id", name: "transaction_id"},
                {data: "type", name: "type"},
                {data: "name", name: "name"},
                {data: "subtotal", name: "subtotal"},
                {data: "payment", name: "payment"},
                {data: "change", name: "change"},
                {data: "date", name: "date"},
                {data: "actions", name: "actions"},
            ],

            columnDefs: [
                {
                    targets: [-1],
                    className: "table-report__action w-26",
                },
                {
                    targets: [0],
                    className: "text-center",
                },
                {
                    targets: [1],
                    className: "w-24",
                },
                {
                    targets: [2, 4, 5, 6, 7],
                    className: "text-center"
                },
            ]
        });

        $("table").on("click", "#view", function () {
            const id = $(this).data("transaction-id");
            var items = $("#items-table").DataTable({
                processing: true,
                ordering: false,
                serverSide: true,
                autoWidth: false,
                autoHeight: false,
                responsive: true,
                pageResize: false,

                ajax: {
                    url: "{{ route('datatables') }}" + "/transaction-items/" + id,
                },

                columns: [
                    {data: "transaction_id", name: "transaction_id"},
                    {data: "name", name: "name"},
                    {data: "price", name: "price"},
                    {data: "quantity", name: "quantity"},
                    {data: "total", name: "total"},
                    {data: "refunded", name: "refunded"},
                ],

                columnDefs: [
                    {
                        targets: [0],
                        className: "text-center",
                    },
                    {
                        targets: [2, 3, 4, 5],
                        className: "text-center"
                    },
                ]
            });

            $.ajax({
                type: "POST",
                url: "{{ route('transaction_history') }}" + "/show/" + id,
                data: { submit: true },
                dataType: "json",
                success: function (response) {
                    $.each(response, function (s, v) {
                        $("#" + s).text("₱ " + v);
                    });
                }
            });
            showSlideover("#view-transaction-modal");
            items.destroy();
        });
    });
</script>
@endsection
