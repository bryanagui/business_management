@extends('../layout/' . $layout)

@section('subhead')
    <title>Reserv8tion - Reservations</title>
@endsection

@section('subcontent')
    <div class="grid grid-cols-12 gap-6 mt-8">
        <div class="col-span-12">
            <h2 class="intro-y text-lg font-medium mr-auto mt-2">Reservations</h2>
            <!-- BEGIN: Reservations -->
            <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-6">
                <button class="btn btn-primary shadow-md mr-2">Add New Reservation</button>
            </div>
            <div class="col-span-12 mt-6">
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2" id="weekly-top-products-table">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap">ROOM NO.</th>
                                <th class="whitespace-nowrap">ROOM TYPE</th>
                                <th class="text-center whitespace-nowrap">DATE/TIME</th>
                                <th class="text-center whitespace-nowrap">RATE</th>
                                <th class="text-center whitespace-nowrap">STATUS</th>
                                <th class="text-center whitespace-nowrap">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (array_slice($fakers, 0, 10) as $faker)
                                <tr class="intro-x">
                                    <td>{{ $faker['stocks'][0] }}</td>
                                    <td>
                                        <span class="font-medium whitespace-nowrap">{{ $faker['products'][0]['name'] }}</span>
                                        <div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">{{ $faker['products'][0]['category'] }}</div>
                                    </td>
                                    <td class="text-center">Jan 01, 1990 - Dec 29, 1996</td>
                                    <td class="text-center">₱{{ rand(2500, 7500) }}.00/day</td>
                                    <td class="w-20">
                                        <div class="flex items-center justify-center text-warning">
                                            <i data-feather="check-square" class="w-4 h-4 mr-2"></i> Reserved
                                        </div>
                                    </td>
                                    <td class="table-report__action w-20">
                                        <div class="flex justify-center items-center">
                                            <a class="flex items-center mr-3" href="javascript:;">
                                                <i data-feather="eye" class="w-4 h-4 mr-1"></i> View
                                            </a>
                                            <a class="flex items-center mr-3" href="javascript:;">
                                                <i data-feather="tool" class="w-4 h-4 mr-1"></i> Edit
                                            </a>
                                            <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal">
                                                <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: Reservations -->
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('dist/js/datatables.js') }}"></script>
<script>
    $(document).ready(function () {
        $("#weekly-top-products-table").DataTable();
    });
</script>
@endsection
