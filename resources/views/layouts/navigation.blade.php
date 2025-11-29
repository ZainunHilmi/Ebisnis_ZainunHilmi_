@php
    use Illuminate\Support\Facades\Auth;
@endphp

<nav>
    <!-- contoh lain di file mu — sesuaikan markup -->
    @if(Auth::check())
        @if(optional(Auth::user())->role === 'admin')
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        @else
            <a href="{{ route('user.dashboard') }}">Dashboard</a>
        @endif

        <a href="{{ route('profile.edit') }}">Profile</a>
        <form method="POST" action="{{ route('logout') }}" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}">Login</a>
    @endif
</nav>
