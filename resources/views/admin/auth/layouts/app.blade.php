<!DOCTYPE html>
<html lang="en">
    @include('admin.auth.layouts.includes.head')
    <body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    @include('admin.auth.layouts.includes.theme_mode')
        @yield('content')
    @include('admin.auth.layouts.includes.footer')
    </body>
</html>
