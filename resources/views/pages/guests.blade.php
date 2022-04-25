@extends('../layout/' . $layout)

@section('subhead')
<title>Reserv8tion - Guests</title>
@endsection

@section('subcontent')
<div class="grid grid-cols-12 gap-6 mt-8">
    <div class="col-span-12">
        <h2 class="intro-y text-lg font-medium mr-auto mt-2">Guests</h2>
        <!-- BEGIN: Guests -->
        <div class="col-span-12 mt-6">
            <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                <table class="table table-report sm:mt-2" id="weekly-top-products-table">
                    <thead>
                        <tr>
                            <th class="whitespace-nowrap">GUEST ID</th>
                            <th class="whitespace-nowrap">FULL NAME</th>
                            <th class="whitespace-nowrap">CONTACT</th>
                            <th class="text-center whitespace-nowrap">ROOM</th>
                            <th class="text-center whitespace-nowrap">ROOM TYPE</th>
                            <th class="text-center whitespace-nowrap">CHECK IN DATE</th>
                            <th class="text-center whitespace-nowrap">CHECK OUT DATE</th>
                            <th class="text-center whitespace-nowrap">STATUS</th>
                            <th class="text-center whitespace-nowrap">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (array_slice($fakers, 0, 10) as $faker)
                        <tr class="intro-x">
                            <td class="w-16 items-center text-center">{{ $faker['stocks'][0] }}</td>
                            <td>
                                <span class="font-medium whitespace-nowrap">{{ $fakers[0]['users'][0]['name'] }}</span>
                            </td>
                            <td>09125556666</td>
                            <td class="text-center">Floor 12 Room 5664</td>
                            <td class="text-center">Sosyal na Room</td>
                            <td class="text-center">December 29, 1996</td>
                            <td class="text-center">December 29, 1996</td>
                            <td class="w-20">
                                <div class="flex items-center justify-center {{ $faker['true_false'][0] ? 'text-success' : 'text-danger' }}">
                                    <i data-feather="check-square" class="w-4 h-4 mr-2"></i> {{ $faker['true_false'][0] ? 'Active' : 'Inactive' }}
                                </div>
                            </td>
                            <td class="table-report__action w-20">
                                <div class="flex justify-center items-center">
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
        <!-- END: Guests -->
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
