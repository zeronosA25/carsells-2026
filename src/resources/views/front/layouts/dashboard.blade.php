<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CarSells Dashboard' }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #0d1118;
            color: #d1d5db;
            font-family: Arial, sans-serif;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .app {
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 230px;
            background: #121821;
            border-right: 1px solid rgba(255, 255, 255, 0.06);
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            padding: 24px 0;
        }

        .brand {
            padding: 0 24px 28px;
        }

        .brand-title {
            color: #f4d24b;
            font-size: 18px;
            font-weight: 700;
        }

        .brand-subtitle {
            margin-top: 4px;
            font-size: 10px;
            letter-spacing: 3px;
            color: #6b7280;
            text-transform: uppercase;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .menu a {
            padding: 13px 24px;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9ca3af;
            border-right: 3px solid transparent;
        }

        .menu a:hover,
        .menu a.active {
            background: rgba(244, 210, 75, 0.1);
            color: #f4d24b;
            border-right-color: #f4d24b;
        }

        .sidebar-bottom {
            position: absolute;
            left: 0;
            right: 0;
            bottom: 24px;
            padding: 0 24px;
        }

        .new-transaction {
            display: block;
            background: #f4d24b;
            color: #111827;
            padding: 13px;
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .bottom-link {
            display: block;
            color: #9ca3af;
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 14px;
        }

        .main {
            margin-left: 230px;
            width: calc(100% - 230px);
            min-height: 100vh;
        }

        .topbar {
            height: 64px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
        }

        .search {
            width: 330px;
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 10px 14px;
            border-radius: 6px;
            color: #d1d5db;
        }

        .top-menu {
            display: flex;
            align-items: center;
            gap: 22px;
            font-size: 12px;
            color: #9ca3af;
        }

        .top-menu .active {
            color: #f4d24b;
        }

        .avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: 1px solid rgba(244, 210, 75, 0.4);
            background: rgba(244, 210, 75, 0.15);
        }

        .content {
            padding: 26px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 24px;
        }

        .page-title {
            margin: 0;
            font-size: 42px;
            font-weight: 300;
            color: #e5e7eb;
        }

        .page-subtitle {
            margin-top: 6px;
            color: #9ca3af;
            font-size: 14px;
        }

        .text-gold {
            color: #f4d24b;
        }

        .actions {
            display: flex;
            gap: 12px;
        }

        .btn-outline {
            border: 1px solid rgba(244, 210, 75, 0.5);
            color: #f4d24b;
            background: transparent;
            padding: 11px 18px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        .btn-gold {
            background: #f4d24b;
            color: #111827;
            border: none;
            padding: 11px 18px;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-weight: 700;
        }

        .grid-3 {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 16px;
        }

        .grid-main {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 16px;
        }

        .card {
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.06);
            padding: 22px;
        }

        .card-highlight {
            border-left: 4px solid #f4d24b;
        }

        .card-label {
            font-size: 11px;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 4px;
        }

        .card-sub {
            font-size: 11px;
            color: #f4d24b;
            margin-bottom: 22px;
        }

        .stat-number {
            font-size: 38px;
            font-weight: 300;
            color: #e5e7eb;
        }

        .small-muted {
            color: #9ca3af;
            font-size: 12px;
        }

        .progress {
            height: 8px;
            background: #111827;
            margin-top: 14px;
        }

        .progress-fill {
            height: 8px;
            background: #f4d24b;
            width: 84%;
        }

        .section-title {
            font-size: 20px;
            font-weight: 400;
            margin: 24px 0 14px;
            color: #e5e7eb;
        }

        .chart {
            height: 230px;
            display: flex;
            align-items: flex-end;
            gap: 34px;
            padding: 20px;
        }

        .bar {
            width: 95px;
            background: rgba(244, 210, 75, 0.25);
        }

        .bar.active {
            background: #f4d24b;
        }

        .activity {
            display: flex;
            gap: 12px;
            margin-bottom: 20px;
        }

        .activity-icon {
            width: 30px;
            height: 30px;
            background: rgba(244, 210, 75, 0.12);
            border: 1px solid rgba(244, 210, 75, 0.25);
        }

        .activity-title {
            font-size: 14px;
            color: #e5e7eb;
        }

        .activity-desc {
            font-size: 12px;
            color: #9ca3af;
            margin-top: 4px;
        }

        .inventory-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
        }

        .car-card {
            background: #171d27;
            border: 1px solid rgba(255, 255, 255, 0.06);
            overflow: hidden;
        }

        .car-card img,
        .car-placeholder {
            width: 100%;
            height: 140px;
            object-fit: cover;
            background: #0d1118;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .car-body {
            padding: 14px;
        }

        .car-title {
            font-size: 14px;
            color: #e5e7eb;
            margin-bottom: 10px;
        }

        .car-price {
            color: #f4d24b;
            font-weight: 700;
        }

        @media (max-width: 900px) {
            .sidebar {
                position: static;
                width: 100%;
            }

            .app {
                display: block;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .grid-3,
            .grid-main,
            .inventory-grid {
                grid-template-columns: 1fr;
            }

            .page-header,
            .topbar {
                flex-direction: column;
                height: auto;
                gap: 12px;
                align-items: flex-start;
            }

            .search {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="app">
        <aside class="sidebar">
            <div class="brand">
                <div class="brand-title">CarSells</div>
                <div class="brand-subtitle">Principal Office</div>
            </div>

            <nav class="menu">
                <a href="{{ route('front.dashboard') }}" class="{{ request()->routeIs('front.dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('front.inventory.index') }}" class="{{ request()->routeIs('front.inventory.*') ? 'active' : '' }}">
                    Inventory
                </a>
                <a href="{{ route('front.crm.index') }}" class="{{ request()->routeIs('front.crm.*') ? 'active' : '' }}">
                    CRM
                </a>
                <a href="{{ route('front.transactions.index') }}" class="{{ request()->routeIs('front.transactions.*') ? 'active' : '' }}">
                    Transactions
                </a>
                <a href="{{ route('front.reports.index') }}" class="{{ request()->routeIs('front.reports.*') ? 'active' : '' }}">
                    Reports
                </a>
            </nav>

            <div class="sidebar-bottom">
                <a href="/admin/sales/create" class="new-transaction">
                    New Transaction
                </a>
                <a href="#" class="bottom-link">Support</a>
                <a href="/admin" class="bottom-link">Admin Panel</a>
            </div>
        </aside>

        <main class="main">
            <header class="topbar">
                <input class="search" type="text" placeholder="Search inventory...">

                <div class="top-menu">
                    <span class="active">Overview</span>
                    <span>Allocations</span>
                    <span>Valuations</span>
                    <div class="avatar"></div>
                </div>
            </header>

            <section class="content">
                @yield('content')
            </section>
        </main>
    </div>
</body>
</html>
