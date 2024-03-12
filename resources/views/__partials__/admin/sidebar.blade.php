<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ url('/') }}" class="app-brand-link">
            <span class="app-brand-text demo menu-text fw-semibold">{{ env('APP_NAME') }}</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboards -->
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('/dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons mdi mdi-home-outline"></i>
                <div data-i18n="Dashboards">Dashboards</div>
            </a>
        </li>

        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text">Person Management</span>
        </li>

        <li class="menu-item {{ request()->is('person/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-form-select"></i>
                <div data-i18n="Layouts">Person</div>
            </a>

            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('person/import') ? 'active' : '' }}">
                    <a href="{{ route('person.import.form') }}" class="menu-link">
                        <div data-i18n="Without menu">Import From Excel</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('person/list') ? 'active' : '' }}">
                    <a href="{{ route('person.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Person List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text">Reports</span>
        </li>

        <li class="menu-item {{ request()->is('report/*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons mdi mdi-form-select"></i>
                <div data-i18n="Layouts">Reports</div>
            </a>

            <ul class="menu-sub">
                @if(in_array(Auth::user()->role,[1,2]))
                    <li class="menu-item {{ request()->is('report/list') ? 'active' : '' }}">
                        <a href="{{ route('report.list') }}" class="menu-link">
                            <div data-i18n="Without menu">Report List</div>
                        </a>
                    </li>
                @endif
                <li class="menu-item {{ request()->is('report/generate') ? 'active' : '' }}">
                    <a href="{{ route('report.index') }}" class="menu-link">
                        <div data-i18n="Without menu">Report Generate</div>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</aside>
