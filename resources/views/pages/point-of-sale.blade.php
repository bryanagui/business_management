@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Point of Sale</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Point of Sale</h2>
</div>
@if(Session::has('message'))
<div class="intro-y alert alert-outline-danger alert-dismissible show flex items-center mt-4 mb-4" role="alert">
    <i data-feather="alert-octagon" class="w-6 h-6 mr-2"></i>
    {{ Session::get('message') }}
    <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-feather="x" class="w-4 h-4"></i> </button>
</div>
@endif
<div class="intro-y grid grid-cols-12 gap-5 mt-5 item-list hidden">
    <!-- BEGIN: Item List -->
    <div class="intro-y col-span-12 lg:col-span-8">
        <div class="lg:flex intro-y">
            <div class="relative">
                <input type="text" class="form-control py-3 px-4 w-full lg:w-64 box pr-10 product-search" placeholder="Search item...">
                <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0 text-slate-500" data-feather="search"></i>
            </div>
        </div>
        <div class="grid grid-cols-12 gap-5 mt-5">
            @foreach(\App\Models\ProductCategory::all() as $category)
            <div class="col-span-12 sm:col-span-4 2xl:col-span-3 box p-5 cursor-pointer zoom-in category-selection {{ \App\Models\ProductCategory::pluck('name')->first() == $category->name ? ($dark_mode ? 'category-selected text-white' : 'bg-primary text-white') : '' }}" data-name="{{ $category->name }}">
                <div class="font-medium text-base">{{ $category->name }}</div>
                <div class="text-sm">{{ \App\Models\Product::with(['category'])->where('category', $category->name)->count() }} {{ \App\Models\Product::with(['category'])->where('category', $category->name)->count() == 1 ? " item" : " items" }}</div>
            </div>
            @endforeach
        </div>
        <div class="grid grid-cols-12 gap-5 mt-5 pt-5 border-t products-list">
            @foreach(\App\Models\Product::where('category', \App\Models\ProductCategory::pluck('name')->first())->get() as $product)
            <a href="javascript:;" id="product" data-id="{{ $product->id }}" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3 product">
                <div class="box rounded-md p-3 relative zoom-in">
                    <div class="flex-none relative block before:block before:w-full before:pt-[100%]">
                        <div class="absolute top-0 left-0 w-full h-full image-fit">
                            <img alt="Product Thumbnail" class="rounded-md" src="{{ empty($product->media) ? asset('storage/static/images') . '/nothumb.jpg' : asset('storage/static/product_images') . '/' . $product->media }}">
                        </div>
                    </div>
                    <div class="block font-medium text-center truncate mt-3">{{ $product->name }}</div>
                    <div class="block text-center truncate">Price: ₱ {{ number_format($product->price / 100, 2) }}</div>
                    <div class="block text-center truncate">Stock: {{ $product->stock }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    <!-- END: Item List -->
    <!-- BEGIN: Ticket -->
    <div class="col-span-12 lg:col-span-4">
        <div class="intro-y pr-1">
            <div class="box p-2">
                <ul class="nav nav-pills" role="tablist">
                    <li id="ticket-tab" class="nav-item flex-1" role="presentation">
                        <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#ticket" type="button" role="tab" aria-controls="ticket" aria-selected="true">
                            Ticket
                        </button>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div id="ticket" class="tab-pane active" role="tabpanel" aria-labelledby="ticket-tab">
                <div class="box p-2 mt-5">
                    @foreach (\App\Models\Cart::where('user_id', Auth::user()->id)->get() as $cart)
                    <a href="javascript:;" id="cart-item" data-id="{{ $cart->id }}" class="flex items-center p-3 cursor-pointer transition duration-300 ease-in-out bg-white dark:bg-darkmode-600 hover:bg-slate-100 dark:hover:bg-darkmode-400 rounded-md">
                        <div class="max-w-[50%] truncate mr-1">{{ $cart->name }}</div>
                        <div class="text-slate-500">x {{ $cart->quantity }}</div>
                        <div class="ml-auto font-medium">₱ {{ number_format($cart->amount / 100, 2) }}</div>
                    </a>
                    @endforeach
                </div>
                <div class="box p-5 mt-5">
                    <h4 class="font-medium mb-2">Amount:</h4>
                    <div class="flex payment-input-card">
                        <input type="number" name="payment" id="payment" class="form-control py-3 px-4 w-full bg-slate-100 border-slate-200/60 pr-10" placeholder="Amount">
                        <button class="btn btn-primary ml-2" id="apply-payment" {{ \App\Models\Cart::where('user_id', Auth::user()->id)->get()->isEmpty() ? 'disabled' : '' }}>Apply</button>
                    </div>
                    <span class="validation-error addpayment-error-payment {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                </div>
                <div class="box p-5 mt-5">
                    @if(\App\Models\Cart::where('user_id', Auth::user()->id)->pluck('discount')->first() > 0)
                    <div class="flex">
                        <div class="mr-auto">Discount</div>
                        <div class="font-medium text-danger">-₱ 0.00</div>
                    </div>
                    @endif
                    <div class="flex">
                        <div class="mr-auto font-medium text-base">Total Charge</div>
                        <div class="font-medium text-base">₱ {{ number_format(\App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') / 100, 2) }}</div>
                    </div>
                    <div class="flex">
                        <div class="mr-auto font-medium text-base">Payment</div>
                        <div class="font-medium text-base">₱ {{ number_format(\App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first() / 100, 2) }}</div>
                    </div>
                    <div class="flex">
                        <div class="mr-auto font-medium text-base">Change</div>
                        <div class="font-medium text-base">₱ {{ number_format((\App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first() / 100) - (\App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') / 100), 2) }}</div>
                    </div>
                </div>
                <div class="flex mt-5">
                    <button class="btn w-32 border-slate-300 dark:border-darkmode-400 text-slate-500" data-tw-toggle="modal" data-tw-target="#cart-clear-modal">Clear Items</button>
                    <button class="btn btn-primary w-32 shadow-md ml-auto charge-btn" {{ \App\Models\Cart::where('user_id', Auth::user()->id)->get()->isEmpty() ? 'disabled' : '' }} id="{{ \App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') > \App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first() ? 'payment-incomplete' : 'payment-complete' }}">Charge</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Ticket -->
</div>
@endsection

@section('modal')
<!-- BEGIN: Add Item Modal -->
<div id="add-item-modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto truncate product-title"></h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <label for="quantity" class="form-label">Quantity</label>
                    <div class="flex mt-2 flex-1">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1" id="qty-dec">-</button>
                        <input id="quantity" type="text" class="form-control w-24 text-center" placeholder="Quantity" value="1">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1" id="qty-inc">+</button>
                    </div>
                    <span class="validation-error error-id {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                    <span class="validation-error error-quantity {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 cancel-item">Cancel</button>
                <button type="button" class="btn btn-primary w-24" id="add-current-item">Add Item</button>
            </div>
        </div>
    </div>
</div>
<!-- END: Add Item Modal -->
<!-- BEGIN: Edit Item Modal -->
<div id="edit-item-modal" class="modal" data-tw-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto truncate edit-product-title"></h2>
            </div>
            <div class="modal-body grid grid-cols-12 gap-4 gap-y-3">
                <div class="col-span-12">
                    <label for="quantity" class="form-label">Quantity</label>
                    <div class="flex mt-2 flex-1">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 mr-1" id="edit-qty-dec">-</button>
                        <input id="edit-quantity" type="text" class="form-control w-24 text-center" placeholder="Quantity" value="1">
                        <button type="button" class="btn w-12 border-slate-200 bg-slate-100 dark:bg-darkmode-700 dark:border-darkmode-500 text-slate-500 ml-1" id="edit-qty-inc">+</button>
                    </div>
                    <span class="validation-error edit-error-quantity {{ $dark_mode ? 'text-warning' : 'text-danger' }} "></span>
                </div>
            </div>
            <div class="modal-footer text-right">
                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1 cancel-item">Cancel</button>
                <button type="button" class="btn btn-primary w-32" id="edit-selected-item">Update Item</button>
            </div>
        </div>
    </div>
</div>
<!-- END: Edit Item Modal -->
<!-- BEGIN: Clear Cart Modal -->
<div id="cart-clear-modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="p-5 text-center"> <i data-feather="alert-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                    <div class="text-3xl mt-5">Are you sure?</div>
                    <div class="text-slate-500 mt-2">Do you really want to clear item cart?</div>
                </div>
                <div class="px-5 pb-8 text-center"> <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button> <button type="button" id="confirm-cart-clear" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">Yes</button> </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Clear Cart Modal -->
<!-- BEGIN: Checkout Modal -->
<div class="modal-container modal-payment-complete">
    <div id="cart-checkout-modal" data-tw-backdrop="static" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <form action="{{ route('transaction.store') }}" method="POST">
                        @csrf
                        <div class="p-5 text-center"> <i data-feather="alert-circle" class="w-16 h-16 {{ $dark_mode ? 'text-warning' : 'text-danger' }} mx-auto mt-3"></i>
                            <div class="text-3xl mt-5">Submit Transaction</div>
                            <div class="text-slate-500 mt-2">Proceeding will submit the transaction.<br>Are you sure you want to continue?</div>
                        </div>
                        <div class="px-5 pb-8 text-center">
                            <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-24 mr-1">Cancel</button>
                            <button type="submit" id="confirm-cart-checkout" class="btn {{ $dark_mode ? 'btn-warning' : 'btn-danger' }} w-24">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Checkout Modal -->
<!-- BEGIN: Danger Notification -->
<div id="danger-notification" class="toastify-content hidden flex"> <i class="text-danger" data-feather="x-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium toast-title"></div>
        <div class="text-slate-500 mt-1 toast-content"></div>
    </div>
</div>
<!-- END: Danger Notification -->
@endsection

@section('script')
<script>
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function reloadTicket(){
            $("#ticket").load(location.href + " #ticket");
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

        function resetModalContent(){
            $("#quantity").val(1);
            $("#edit-quantity").val(1);
            $('span.validation-error').text('');
        }

        function showDangerNotification(title, content){
            $(".toast-title").text(title);
            $(".toast-content").text(content);
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
        }

        function getProductInfo(){
            $("div.products-list #product").on("click", function () {
                let id = $(this).attr("data-id");
                $.ajax({
                    type: "POST",
                    url: "{{ route('pos') }}" + '/show/' + id,
                    data: { submit: true },
                    dataType: "json",
                    success: function (response) {
                        if(response.data == null){
                            showDangerNotification("Item does not exist", "The item does not exist. Have you changed something?")
                        }
                        else {
                            if(response.data.stock != 0) {
                                showModal("#add-item-modal");
                                $(".product-title").text(response.data.name);
                                $("#add-current-item").off().click(function (e) {
                                    let qty = $("#quantity").val();
                                    $.ajax({
                                        type: "POST",
                                        url: "{{ route('pos.store') }}",
                                        data: { id: id, quantity: qty },
                                        dataType: "json",
                                        success: function (response) {
                                            hideModal("#add-item-modal");
                                            resetModalContent();
                                            reloadTicket();
                                        },
                                        error: function (xhr) {
                                            if(xhr.status == 422){
                                                var errors = xhr.responseJSON.errors;
                                                $('span.validation-error').text('');
                                                $.each(errors, function (s, v) {
                                                    $('span.error-'+s).text(v[0]);
                                                });
                                            }
                                        }
                                    });
                                });
                            }
                            else {
                                showDangerNotification("Out of Stock", "The item " + response.data.name + " has ran out of stock")
                            }
                        }
                    }
                });
            });
        }

        getProductInfo();

        $(".cancel-item").click(function (e) {
            resetModalContent();
        });

        $("div.item-list").removeClass("hidden");

        $(".product-search").on("keyup", function () {
            let val = $(this).val().toLowerCase();
            $(".product").filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
            });
        });

        $("#qty-inc").click(function (e) { $('#quantity').get(0).value++; });
        $("#qty-dec").click(function (e) { $('#quantity').get(0).value--; });

        $("#edit-qty-inc").click(function (e) { $('#edit-quantity').get(0).value++; });
        $("#edit-qty-dec").click(function (e) { $('#edit-quantity').get(0).value--; });

        $("div#ticket").on("click", "#cart-item", function () {
            const id = $(this).data('id');
            $.ajax({
                type: "POST",
                url: "{{ route('pos') }}" + "/edit/" + id,
                data: { submit: true },
                dataType: "json",
                success: function (response) {
                    showModal('#edit-item-modal');
                    $(".edit-product-title").text(response.name);
                    $("#edit-selected-item").off().click(function (e) {
                        let qty = $("#edit-quantity").val();
                        $.ajax({
                            type: "PATCH",
                            url: "{{ route('pos') }}" + "/update/" + id,
                            data: { id: id, quantity: qty },
                            dataType: "json",
                            success: function (response) {
                                hideModal("#edit-item-modal");
                                resetModalContent();
                                reloadTicket();
                            },
                            error: function (xhr) {
                                if(xhr.status == 422){
                                    var errors = xhr.responseJSON.errors;
                                    $('span.validation-error').text('');
                                    $.each(errors, function (s, v) {
                                        $('span.edit-error-'+s).text(v[0]);
                                    });
                                }
                            }
                        });
                    });
                }
            });
        });

        $("div#ticket").on("contextmenu", "#cart-item", function () {
            const id = $(this).data('id');
            alert(id);
        });

        $("div.category-selection").click(function (e) {
            $("div.category-selection").removeClass('{{$dark_mode ? "category-selected" : "bg-primary"}} text-white');
            $(this).addClass('{{$dark_mode ? "category-selected" : "bg-primary"}} text-white');
            const name = $(this).data("name");
            $.ajax({
                type: "POST",
                url: "{{ route('pos.switch') }}",
                data: { name: name },
                dataType: "json",
                success: function (response) {
                    $("div.products-list").text('');
                    function addCommas(str){
                        var arr,int,dec;
                        str += '';

                        arr = str.split('.');
                        int = arr[0] + '';
                        dec = arr.length>1?'.'+arr[1]:'';
                        return int.replace(/(\d)(?=(\d{3})+$)/g,"$1,") + '.' + parseFloat(dec).toFixed(2).split('.')[1];
                    }
                    if(!response.length == 0){
                        $.each(response, function (i, v) {
                            const image = v.media == null ? "{{ asset('storage/static/images') . '/nothumb.jpg'  }}" : "{{ asset('storage/static/product_images') }}/" + v.media
                            const price = v.price / 100;
                            $("div.products-list").append('<a href="javascript:;" id="product" data-id="' + v.id + '" class="intro-y block col-span-12 sm:col-span-4 2xl:col-span-3 product">\n<div class="box rounded-md p-3 relative zoom-in">\n<div class="flex-none relative block before:block before:w-full before:pt-[100%]">\n<div class="absolute top-0 left-0 w-full h-full image-fit">\n<img alt="Product Thumbnail" class="rounded-md" src="' + image + '">\n</div>\n</div>\n<div class="block font-medium text-center truncate mt-3">'+ v.name +'</div>\n<div class="block text-center truncate">Price: ₱'+ addCommas(price.toFixed(2)) +'</div><div class="block text-center truncate">Stock: '+ v.stock +'</div>\n</div>\n</a>');
                        });
                        getProductInfo();
                    }
                }
            });
        });

        $("div#ticket").on("click", "#apply-payment", function () {
            const payment = $("#payment").val();
            console.log('test');
            $.ajax({
                type: "POST",
                url: "{{ route('pos.set_payment') }}",
                data: { payment: payment },
                dataType: "json",
                success: function (response) {
                    reloadTicket();
                },
                error: function (xhr) {
                    if(xhr.status == 422){
                        var errors = xhr.responseJSON.errors;
                        $(".addpayment-error-payment").text(errors.payment[0]);
                    }
                }
            });
        });

        $("#confirm-cart-clear").click(function (e) {
            e.preventDefault();
            $.ajax({
                type: "DELETE",
                url: "{{ route('pos.destroy') }}",
                data: { submit: true },
                dataType: "json",
                success: function (response) {
                    hideModal("#cart-clear-modal");
                    resetModalContent();
                    reloadTicket();
                }
            });
        });

        $("div#ticket").on("click", "#payment-incomplete", function () {
            showDangerNotification("Payment Incomplete", "Payment does not meet the item costs.")
        });

        $("div#ticket").on("click", "#payment-complete", function () {
            showModal("#cart-checkout-modal");
        });
    });
</script>
@endsection
