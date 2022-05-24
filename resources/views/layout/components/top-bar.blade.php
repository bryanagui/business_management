<!-- BEGIN: Top Bar -->
<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    <nav aria-label="breadcrumb" class="-intro-x mr-auto hidden sm:flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Application</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <!-- END: Breadcrumb -->
    <!-- BEGIN: DateTime Now -->
    <span class="font-medium whitespace-nowrap mr-6 ml-6" id="topbar-datetime-running"></span>
    <!-- END: DateTime Now -->
    <!-- BEGIN: Dark Mode Switcher-->
    {{-- <div data-url="{{ route('dark-mode-switcher') }}" class="dark-mode-switcher cursor-pointer shadow-md box border rounded-full w-24 h-12 flex items-center justify-center mr-6">
        <div class="mr-2 text-slate-600 dark:text-slate-200"></div>
        <div class="dark-mode-switcher__toggle {{ $dark_mode ? 'dark-mode-switcher__toggle--active' : '' }} border"></div>
    </div> --}}
    <a type="button" href="{{ route('dark-mode-switcher') }}" class="rounded-full btn {{ $dark_mode ? 'btn-primary' : 'btn-dark' }} mr-6">{!! $dark_mode ? '<i class="fa-regular fa-sun"></i>' : '<i class="fa-regular fa-moon"></i>' !!}</a>
    <!-- END: Dark Mode Switcher-->
    <!-- BEGIN: Notifications -->
    <div class="intro-x dropdown mr-auto sm:mr-6">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            <i data-feather="bell" class="notification__icon dark:text-slate-500"></i>
        </div>
        <div class="notification-content pt-2 dropdown-menu">
            <div class="notification-content__box dropdown-content">
                <div class="notification-content__title">Notifications</div>
                @foreach (\App\Models\Transaction::with(['user'])->limit(10)->get() as $transaction)
                <div class="cursor-pointer relative flex items-center {{ $transaction->id ? 'mt-5' : '' }}">
                    <div class="w-12 h-12 flex-none image-fit mr-1">
                        <img alt="image" class="rounded-full" src="{{ empty($transaction->user->photo) ? asset('storage/static/images') . '/null.jpg' : asset('storage/static/images') . '/' . $transaction->user->photo }}">
                        <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>
                    </div>
                    <div class="ml-2 overflow-hidden">
                        <div class="flex items-center">
                            <a href="javascript:;" class="font-medium truncate mr-5">{{ $transaction->user->name }}</a>
                            <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">{{ $transaction->created_at }}</div>
                        </div>
                        <div class="w-full truncate text-slate-500 mt-0.5">Transaction Completed: + ₱{{ number_format($transaction->amount / 100, 2) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class="intro-x dropdown w-8 h-8">
        <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            <img alt="top-bar-profile" class="top-bar-profile" src="{{ empty(Auth::user()->photo) ? asset('storage/static/images') . '/null.jpg' : asset('storage/static/images') . '/' . Auth::user()->photo }}">
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content bg-primary text-white">
                <li class="p-2">
                    <div class="font-medium">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-white/70 mt-0.5 dark:text-slate-500">{{ Auth::user()->getRoleNames()[0] }}</div>
                </li>
                <li>
                    <hr class="dropdown-divider border-white/[0.08]">
                </li>
                <li>
                    <a href="javascript:;" class="dropdown-item hover:bg-white/5">
                        <i data-feather="settings" class="w-4 h-4 mr-2"></i> Account Settings
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="dropdown-item hover:bg-white/5">
                        <i data-feather="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <!-- END: Account Menu -->
</div>
<!-- END: Top Bar -->
