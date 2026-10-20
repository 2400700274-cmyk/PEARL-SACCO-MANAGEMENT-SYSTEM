<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - {{ \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System') }} | Pearl SACCO Management System</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <x-sidebar />

        <!-- Main Wrapper -->
        <div class="main-wrapper">
            <!-- Topbar -->
            <x-topbar />

            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
