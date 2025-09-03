<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="{{ asset('dashboard/assets/css/adminstyle.css') }}">
        <script src="{{ asset('dashboard/assets/js/admin/sidebar.js') }}"></script>
    {{-- <script src="{{ asset('dashboard/assets/js/admin/scheduling.js') }}"></script> --}}


    @yield('local-styles')

    {{-- TinyMCE --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tinymce@8.0.2/skins/ui/oxide/content.min.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.1/css/dataTables.dataTables.css">

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    @yield('local-scripts')

</head>

<body>
