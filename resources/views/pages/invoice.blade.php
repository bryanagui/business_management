@extends('../layout/' . $layout)

@section('subhead')
<title>Invoice Layout - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="intro-y flex flex-col sm:flex-row items-center mt-8">
    {{-- <h2 class="text-lg font-medium mr-auto">Invoice Layout</h2> --}}
    <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
        <button class="btn btn-primary shadow-md mr-2">Print</button>
        <div class="dropdown ml-auto sm:ml-0">
            <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                <span class="w-5 h-5 flex items-center justify-center">
                    <i class="w-4 h-4" data-feather="plus"></i>
                </span>
            </button>
        </div>
    </div>
</div>
<!-- BEGIN: Invoice -->
<div class="intro-y box overflow-hidden mt-5">
    <div class="border-b border-slate-200/60 dark:border-darkmode-400 text-center sm:text-left">
        <div class="px-5 py-10 sm:px-20 sm:py-20">
            <div class="text-primary font-semibold text-3xl">INVOICE</div>
            <div class="mt-2">
                Receipt <span class="font-medium">#1923195</span>
            </div>
            <div class="mt-1">{{ (\Carbon\Carbon::now())->format('F d, Y h:i:sa') }}</div>
        </div>
    </div>
    <div class="px-5 sm:px-16 py-10 sm:py-20">
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                    <tr>
                        <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">PRODUCT NAME</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">PRICE</th>
                        <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(\App\Models\Cart::where('user_id', Auth::user()->id)->get() as $cart)
                    <tr>
                        <td class="border-b dark:border-darkmode-400">
                            <div class="font-medium whitespace-nowrap">{{ $cart->name }}</div>
                            <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">{{ $cart->category }}</div>
                        </td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $cart->quantity }}</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32">₱ {{ number_format($cart->price / 100, 2) }}</td>
                        <td class="text-right border-b dark:border-darkmode-400 w-32 font-medium">₱ {{ number_format($cart->amount / 100, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
        <div class="text-center sm:text-right sm:ml-auto">
            <div class="text-base text-slate-500">Total Amount</div>
            <div class="text-xl text-primary font-medium mt-2">₱ {{ number_format(\App\Models\Cart::where('user_id', Auth::user()->id)->sum('amount') / 100, 2) }}</div>
            <div class="mt-1">Taxes included</div>
        </div>
    </div>
</div>
<!-- END: Invoice -->
@endsection
