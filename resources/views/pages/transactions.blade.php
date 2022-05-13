@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Transactions</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Transactions</h2>
        <!-- BEGIN: User/Staff List -->
        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
            <input type="text" class="form-control w-72 mr-4" placeholder="Transaction ID">
            <button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#create-new-staff-modal">Search Transaction</button>
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

@section('script')
<script src="{{ asset('dist/js/datatables.js') }}"></script>
@endsection