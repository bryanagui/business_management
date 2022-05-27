@extends('../layout/' . $layout)

@section('subhead')
<title>Update Profile - Rubick - Tailwind HTML Admin Template</title>
@endsection

@section('subcontent')
<div class="intro-y flex items-center mt-8">
    <h2 class="text-lg font-medium mr-auto">Change Password</h2>
</div>
<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="w-12 h-12 image-fit">
                    <img alt="Rubick Tailwind HTML Admin Template" class="rounded-full" src="{{ empty(Auth::user()->photo) ? asset('storage/static/images') . '/null.jpg' : asset('storage/static/images') . '/' . Auth::user()->photo }}">
                </div>
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base">{{ Auth::user()->name }}</div>
                    <div class="text-slate-500">{{ Auth::user()->getRoleNames()[0] }}</div>
                </div>
            </div>
            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                <a class="flex items-center text-primary font-medium" href="">
                    <i data-feather="lock" class="w-4 h-4 mr-2"></i> Change Password
                </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->
    <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        @if(Session::has('message'))
        <div class="alert alert-primary alert-dismissible show flex items-center mt-6 mb-2" role="alert">
            <i data-feather="alert-octagon" class="w-6 h-6 mr-2"></i> {{ Session::get('message') }}
            <button type="button" class="btn-close" data-tw-dismiss="alert" aria-label="Close">
                <i data-feather="x" class="w-4 h-4"></i>
            </button>
        </div>
        @endif
        <!-- BEGIN: Change Password -->
        <div class="intro-y box lg:mt-5">
            <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                <h2 class="font-medium text-base mr-auto">Change Password</h2>
            </div>
            <div class="p-5">
                <form action="{{ route('settings.update_password') }}" method="POST">
                    @csrf
                    <div>
                        <label for="change-password-form-1" class="form-label">Old Password</label>
                        <input id="old-password" name="old_password" type="password" class="form-control">
                        @error('old_password') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="mt-3">
                        <label for="change-password-form-2" class="form-label">New Password</label>
                        <input id="password" name="password" type="password" class="form-control">
                        @error('password') <span class="text-danger">{{ $message }}</span>@enderror
                    </div>
                    <div class="mt-3">
                        <label for="change-password-form-3" class="form-label">Confirm New Password</label>
                        <input id="confirm-password" name="password_confirmation" type="password" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mt-4">Change Password</button>
                </form>
            </div>
        </div>
        <!-- END: Change Password -->
    </div>
</div>
@endsection
