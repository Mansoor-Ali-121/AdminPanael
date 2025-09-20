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

    @php
        use Illuminate\Support\Facades\URL;
        use App\Helpers\SitemapHelper;

        // Base URL without trailing slash
        $baseUrl = rtrim(URL::to('/'), '/');

        // Current URL
        $currentUrl = URL::current();

        // Relative path = current URL minus base URL
        $relativePath = ltrim(str_replace($baseUrl, '', $currentUrl), '/');

        // Call your helper functions (jo tumne Laravel helper me banaye hain)
        // $canonical = SitemapHelper::getCanonicalByUrl2($relativePath);
        // $alternatePages = getAlternatePages($relativePath);
        // $schema = getSchemaMarkup($relativePath);

        // SEO Meta data for title and description
        // $seoMeta = getSEOMeta($relativePath);
        // if (!empty($seoMeta)) {
        //     $pageTitle = $seoMeta['meta_title'];
        //     $pageDescription = $seoMeta['meta_description'];
        // } else {
        //     $pageTitle = $pageTitle ?? 'Default Page Title';
        //     $pageDescription = $pageDescription ?? 'Default Page Description';
        // }
        // @dd($canonical);
    @endphp


{{-- Seo  --}}
    {{-- <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">

    @if (!empty($canonical['canonical']))
        <link rel="canonical" href="{{ e($canonical['canonical']) }}" />
    @else
        <link rel="canonical" href="{{ e(url($relativePath)) }}" />
    @endif

    @if (!empty($alternatePages))
        @foreach ($alternatePages as $alternate)
            <link rel="alternate" hreflang="{{ e($alternate['hreflang']) }}" href="{{ e($alternate['href']) }}" />
        @endforeach
    @endif

    @if (!empty($schema))
        {!! $schema !!}
    @endif --}}

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #2a6b3f;
            --primary-light: #3c8c55;
            --secondary: #4CAF50;
            --accent: #8BC34A;
            --light: #f8f9fa;
            --dark: #2d3e50;
            --gray: #6c757d;
            --light-gray: #e9ecef;
            --danger: #e74c3c;
            --warning: #f39c12;
            --info: #3498db;
            --purple: #9b59b6;
            --teal: #1abc9c;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f7f9;
            color: var(--dark);
            overflow-x: hidden;
        }
        
        .dashboard {
            display: flex;
            min-height: 100vh;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Header Styles */
        .header {
            background: white;
            padding: 18px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        
        /* Content Styles */
        .content {
            padding: 30px;
            flex: 1;
        }
        
        .page-title {
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            position: relative;
            padding-left: 15px;
        }
        
        .page-title h1:before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 70%;
            width: 5px;
            background: var(--primary);
            border-radius: 10px;
        }
        
        .btn {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(42, 107, 63, 0.3);
        }
        
        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(42, 107, 63, 0.4);
        }
        
        .stats-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 35px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        
        .stat-card {
            padding: 25px;
            display: flex;
            align-items: center;
        }
        
        .stat-icon {
            width: 70px;
            height: 70px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-right: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
          .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
            max-width: 100%;
            margin: 20px auto;
        }
        
        .chart-title {
            margin-bottom: 20px;
            font-size: 20px;
            color: #2d3e50;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chart-filter {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            background: #f8f9fa;
            border: 1px solid #e9ecef;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 500;
        }
        
        .filter-btn.active {
            background: #2a6b3f;
            color: white;
            border-color: #2a6b3f;
        }
        
        .filter-btn:hover {
            background: #3c8c55;
            color: white;
        }
        
        canvas {
            width: 100% !important;
            height: 300px !important;
        }

        .bookings {
            background: linear-gradient(45deg, var(--secondary), var(--accent));
        }
        
        .revenue {
            background: linear-gradient(45deg, var(--info), #03A9F4);
        }
        
        .users {
            background: linear-gradient(45deg, var(--warning), #FFC107);
        }
        
        .services {
            background: linear-gradient(45deg, var(--purple), #E91E63);
        }
        
        .stat-info h3 {
            font-size: 28px;
            margin-bottom: 5px;
            font-weight: 700;
        }
        
        .stat-info p {
            color: var(--gray);
            font-size: 15px;
            font-weight: 500;
        }
        
        .charts {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
            margin-bottom: 35px;
        }
        
        .chart-container {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }
        
        .chart-title {
            margin-bottom: 20px;
            font-size: 20px;
            color: var(--dark);
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .chart-filter {
            display: flex;
            gap: 10px;
        }
        
        .filter-btn {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            background: var(--light);
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .filter-btn.active {
            background: var(--primary);
            color: white;
        }
        
        .recent-data {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }
        
        .data-table {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.06);
        }
        
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .table-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: var(--dark);
        }
        
        .see-all {
            color: var(--primary);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .see-all:hover {
            text-decoration: underline;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid var(--light-gray);
        }
        
        table th {
            font-weight: 600;
            color: var(--gray);
            font-size: 14px;
        }
        
        table tr:last-child td {
            border-bottom: none;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .status {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .completed {
            background: rgba(76, 175, 80, 0.15);
            color: #2e7d32;
        }
        
        .pending {
            background: rgba(255, 152, 0, 0.15);
            color: #ef6c00;
        }
        
        .cancelled {
            background: rgba(244, 67, 54, 0.15);
            color: #d32f2f;
        }
        
        .in-progress {
            background: rgba(33, 150, 243, 0.15);
            color: #1565c0;
        }
        
        .action-btn {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 13px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            margin-right: 5px;
        }
        
        .view-btn {
            background: rgba(52, 152, 219, 0.15);
            color: var(--info);
        }
        
        .edit-btn {
            background: rgba(46, 204, 113, 0.15);
            color: #27ae60;
        }
        
        .delete-btn {
            background: rgba(231, 76, 60, 0.15);
            color: var(--danger);
        }
        
        .action-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        /* Bookings Page */
        .bookings-page {
            /* display: none; */
            padding: 30px;
        }
        
        .bookings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .back-btn {
            padding: 10px 20px;
            background: var(--light);
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: var(--light-gray);
        }
        
        @media (max-width: 1200px) {
            .sidebar {
                width: 230px;
            }
            
            .charts {
                grid-template-columns: 1fr;
            }
        }
        
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
            }
            
            .sidebar-header h2, .sidebar-menu span {
                display: none;
            }
            
            .sidebar-menu i {
                margin-right: 0;
                font-size: 20px;
            }
            
            .recent-data {
                grid-template-columns: 1fr;
            }
            
            .search-bar {
                width: 300px;
            }
        }
        
        @media (max-width: 768px) {
            .stats-cards {
                grid-template-columns: 1fr;
            }
            
            .search-bar {
                width: 200px;
            }
            
            .header-right {
                gap: 15px;
            }
            
            .user-info {
                display: none;
            }
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .card, .chart-container, .data-table {
            animation: fadeIn 0.5s ease-out;
        }
    </style>
</head>


<body>
