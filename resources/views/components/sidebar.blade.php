<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('home') }}">PESONA KARAG HILLS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ route('home') }}">KH</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link"><i class="fas fa-user"></i><span>Users</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.index') }}" class="nav-link"><i class="fas fa-list"></i><span>Categories</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.index') }}" class="nav-link"><i class="fas fa-ticket"></i><span>Product / Tickets</span></a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.index') }}" class="nav-link"><i class="fas fa-bar-chart"></i><span>Orders</span></a>
            </li>
            <div class="border-top my-2"></div>
            <li id="keuangan-menu" class="nav-item has-treeview">
                <a href="{{ route('keuangan') }}" class="nav-link toggle-submenu">
                    <i class="fas fa-balance-scale-right"></i>
                    <span>Keuangan</span>
                    <i class="fas fa-angle-down float-right"></i>
                </a>
                <ul class="nav nav-treeview submenu d-none" style="padding-left: 20px;">
                    <li class="nav-item">
                        <a href="{{ route('keuangan') }}" class="nav-link"><i class="fas fa-line-chart"></i><span>Dashboard</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.credit.index') }}" class="nav-link"><i class="fas fa-hand-holding-usd"></i><span>Pemasukan</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.debit.index') }}" class="nav-link"><i class="fas fa-donate"></i><span>Pengeluaran</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.categories.index') }}" class="nav-link"><i class="fas fa-list-alt"></i><span>Kategori</span></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('finance.account.index') }}" class="nav-link"><i class="fas fa-landmark"></i><span>Akun Keuangan</span></a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const keuanganMenu = document.querySelector('#keuangan-menu');
    const toggleSubmenuLink = keuanganMenu.querySelector('.toggle-submenu');
    const submenu = keuanganMenu.querySelector('.submenu');
    const submenuStateKey = 'keuangan-submenu-open';

    const navbarToggle = document.querySelector('[data-toggle="sidebar"]'); // Select navbar toggle button
    const sidebar = document.querySelector('.main-sidebar'); // Sidebar container

    // Check state from localStorage and set submenu visibility
    const isSubmenuOpen = localStorage.getItem(submenuStateKey) === 'true';
    if (isSubmenuOpen) {
        submenu.classList.remove('d-none');
    }

    // Function to open the navbarToggle and sidebar if closed
    function openNavbarAndSidebar() {
        if (!navbarToggle.classList.contains('sidebar')) {
            navbarToggle.classList.add('sidebar'); // Add 'open' class to navbar toggle
        }
        if (!sidebar.classList.contains('sidebar')) {
            sidebar.classList.add('sidebar'); // Open sidebar if not already open
        }
    }

    // Toggle submenu visibility and open navbarToggle/sidebar
    toggleSubmenuLink.addEventListener('click', function (event) {
        event.preventDefault();

        // Toggle submenu visibility
        const isOpen = !submenu.classList.contains('d-none');
        submenu.classList.toggle('d-none', isOpen);

        // Open navbarToggle and sidebar
        openNavbarAndSidebar();

        // Store the new state of the submenu in localStorage
        localStorage.setItem(submenuStateKey, !isOpen);
    });

    // Close submenu when navbar toggle is clicked
    if (navbarToggle) {
        navbarToggle.addEventListener('click', function () {
            if (!submenu.classList.contains('d-none')) {
                submenu.classList.add('d-none'); // Close the submenu
                localStorage.setItem(submenuStateKey, false); // Update state in localStorage
            }
        });
    }
});


</script>
@endpush

@push('styles')
<style>
/* Sidebar default (closed) */
.main-sidebar {
    transform: translateX(-100%); /* Sidebar off-screen */
    transition: transform 0.3s ease-in-out;
}

/* Sidebar open */
.main-sidebar.open {
    transform: translateX(0); /* Sidebar on-screen */
}


</style>
@endpush


