@section('footer')
<nav class="navbar navbar-expand-md navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
    </div>
</nav>
@endsection
@yield('footer')
