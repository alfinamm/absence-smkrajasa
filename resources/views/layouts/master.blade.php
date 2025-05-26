<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('layouts.title-meta')
    @include('layouts.head')
</head>

@section('body')

    <body>
    @show

    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('layouts.topbar')
        @include('layouts.sidebar')
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            @include('layouts.footer')
        </div>
        <!-- end main content-->
    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    @include('layouts.right-sidebar')
    <!-- /Right-bar -->

    <!-- JAVASCRIPT -->
    @include('layouts.vendor-scripts')
    <script>
        @if (session()->get('success'))
            msgSuccess('{{ session("success") }}');
        @endif
        @if (session()->get('error'))
            msgError('{{ session("error") }}');
        @endif
        @php
            session()->forget('message');
        @endphp

        function msgSuccess(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                backdrop: false,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        }

        function msgError(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                backdrop: false,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: message
            })
        }

        function swalSuccess(title, message){
            Swal.fire({
                title: title,
                text: message,
                icon: "success"
            }).then(() => {
                location.reload();
            });
        }

        function swalError(title, message){
            Swal.fire({
                title: title,
                text: message,
                icon: "error"
            }).then(() => {
                location.reload();
            });
        }
    </script>
</body>

</html>
