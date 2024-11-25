<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">PESONA KARAG HILLS</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item  ">
                <a href="{{ route('home')}}" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>

            </li>

            <li class="nav-item ">
                <a href="{{ route('users.index') }}" class="nav-link "><i class="fas fa-user"></i>
                    <span>Users</span></a>
            </li>

            <li class="nav-item ">
                <a href="{{ route('categories.index') }}" class="nav-link "><i class="fas fa-list"></i>
                    <span>Categories</span></a>
            </li>

            <li class="nav-item ">
                <a href="{{ route('products.index') }}" class="nav-link "><i class="fas fa-ticket"></i>
                    <span>Tickets</span></a>
            </li>

            <li class="nav-item ">
                <a href="{{ route('orders.index') }}" class="nav-link "><i class="fas fa-bar-chart"></i>
                    <span>Orders</span></a>
            </li>
            <div class="border-top my-2"></div>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-wallet"></i>
                    <span>Keuangan</span>
                    <i class="fas fa-angle-down float-right"></i> <!-- Ikon dropdown -->
                </a>
                <ul class="nav nav-treeview" style="display: none; padding-left: 20px;"> <!-- Sub-menu -->
                    <li class="nav-item">
                        <a href="/keuangan/pemasukan" class="nav-link">
                            <i class="fas fa-arrow-down"></i> <!-- Ikon Pemasukan -->
                            <span>Pemasukan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/keuangan/pengeluaran" class="nav-link">
                            <i class="fas fa-arrow-up"></i> <!-- Ikon Pengeluaran -->
                            <span>Pengeluaran</span>
                        </a>
                    </li>
                </ul>
            </li>
    </aside>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const navItems = document.querySelectorAll('.nav-item > a');

        navItems.forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah aksi default link
                const parent = item.parentElement;
                const subMenu = parent.querySelector('.nav-treeview');

                if (subMenu) {
                    // Tampilkan atau sembunyikan sub-menu
                    const isOpen = subMenu.style.display === 'block';
                    subMenu.style.display = isOpen ? 'none' : 'block';

                    // Tambahkan atau hapus class aktif
                    parent.classList.toggle('menu-open', !isOpen);
                }
            });
        });
    });
</script>
@endpush


@push('styles')
    /* Sub-menu awal disembunyikan */
    .nav-treeview {
        display: none;
        margin-left: 20px;
        transition: all 0.3s ease-in-out;
    }

    /* Saat menu terbuka */
    .menu-open > .nav-treeview {
        display: block;
    }

    /* Tambahkan animasi transisi */
    .nav-treeview li {
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease-in-out;
    }

    .menu-open .nav-treeview li {
        opacity: 1;
        transform: translateY(0);
    }

@endpush


