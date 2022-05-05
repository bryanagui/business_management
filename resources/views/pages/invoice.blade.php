@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Invoice</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Invoice Report</h2>
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary w-32 print-btn shadow-md mr-2">Print</button>
        <button class="btn btn-primary w-32 return-btn shadow-md mr-2">Return</button>
    </div>
</div>
<!-- BEGIN: Invoice -->
<div class="intro-y box overflow-hidden mt-5" id="invoice">
    <div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
        <div class="px-5 py-10 sm:px-20 sm:py-20">
            <div class="text-primary font-semibold text-3xl">RESERV8TION</div>
            <div class="mt-2 transaction-id">
                <i data-loading-icon="three-dots" class="w-8 h-8"></i>
            </div>
            <div class="mt-1">{{ (\Carbon\Carbon::now())->format('F d, Y h:i:sa') }}</div>
        </div>
        <div class="px-5 sm:px-16 py-10 sm:py-20">
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">PRODUCT NAME</th>
                            <th class="text-right whitespace-nowrap">QTY</th>
                            <th class="text-right whitespace-nowrap">PRICE</th>
                            <th class="text-right whitespace-nowrap">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(\App\Models\Cart::where('user_id', Auth::user()->id)->get() as $cart)
                        <tr>
                            <td>
                                <div class="font-medium whitespace-nowrap">{{ $cart->name }}</div>
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">{{ $cart->category }}</div>
                            </td>
                            <td class="text-right w-32">{{ $cart->quantity }}</td>
                            <td class="text-right w-32">₱ {{ number_format($cart->price / 100, 2) }}</td>
                            <td class="text-right w-32 font-medium">₱ {{ number_format($cart->amount / 100, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
            <div class="text-center sm:text-right sm:ml-auto">
                <div class="text-xl text-primary font-medium mt-2">₱ {{ number_format(\App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') / 100, 2) }}</div>
                <div class="text-base text-slate-500">Total Amount</div>

                <div class="text-xl text-primary font-medium mt-4">₱ {{ number_format(\App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first() / 100, 2) }}</div>
                <div class="text-base text-slate-500">Amount Paid</div>

                <div class="text-xl text-primary font-medium mt-4">₱ {{ number_format((\App\Models\Cart::where('user_id', Auth::user()->id)->pluck('payment')->first() / 100) - (\App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') / 100), 2) }}</div>
                <div class="text-base text-slate-500">Change</div>

                <div class="mt-1">Taxes included</div>
            </div>
        </div>
    </div>
    <!-- END: Invoice -->
    @endsection

    @section('script')
    <script src="{{ asset('dist/js/printThis.js') }}"></script>
    <script>
        $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(".print-btn").click(function (e) {
            $("#invoice").printThis({
                importCSS: true,
                importStyle: true,
            });
        });

        $(".return-btn").click(function (e) {
            window.location.href = "{{ route('pos') }}"
        });

        $.ajax({
            type: "POST",
            url: "{{ route('transaction.store') }}",
            data: { submit: true },
            dataType: "json",
            success: function (response) {
                $(".transaction-id").text("Receipt #" + response.transaction_id);
            }
        });
    });
    </script>
    @endsection
