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
                    <span>Product / Tickets</span></a>
            </li>

            <li class="nav-item ">
                <a href="{{ route('orders.index') }}" class="nav-link "><i class="fas fa-bar-chart"></i>
                    <span>Orders</span></a>
            </li>
            <div class="border-top my-2"></div>

            <li id="keuangan-menu" class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-wallet"></i>
                    <span>Keuangan</span>
                    <i class="fas fa-angle-down float-right"></i> <!-- Ikon dropdown -->
                </a>
                <ul class="nav nav-treeview" style="display: none; padding-left: 20px;"> <!-- Sub-menu -->
                    <li class="nav-item">
                        <a href="/keuangan/dashboard" class="nav-link">
                            <i class="fas fa-book"></i> <!-- Ikon Pemasukan -->
                            <span>Saldo</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/keuangan/pemasukan" class="nav-link">
                            <i class="fas fa-hand-holding-usd"></i> <!-- Ikon Pemasukan -->
                            <span>Pemasukan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/keuangan/pengeluaran" class="nav-link">
                            <i class="fas fa-donate"></i> <!-- Ikon Pengeluaran -->
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
        // Ambil semua elemen menu utama yang memiliki sub-menu
        const navLinks = document.querySelectorAll('#keuangan-menu');

        navLinks.forEach(link => {
            link.addEventListener('click', (event) => {
                event.preventDefault(); // Mencegah aksi default link

                const parent = link.parentElement; // Elemen induk .nav-item
                const subMenu = parent.querySelector('.nav-treeview'); // Sub-menu di dalamnya

                if (subMenu) {
                    // Tampilkan atau sembunyikan sub-menu
                    const isOpen = parent.classList.contains('menu-open');

                    // Tutup semua menu terbuka lainnya (opsional jika diperlukan)
                    document.querySelectorAll('.menu-open').forEach(openItem => {
                        openItem.classList.remove('menu-open');
                        openItem.querySelector('.nav-treeview').style.display = 'none';
                    });

                    if (isOpen) {
                        // Jika menu saat ini sudah terbuka, sembunyikan
                        parent.classList.remove('menu-open');
                        subMenu.style.display = 'none';
                    } else {
                        // Jika menu saat ini tertutup, buka
                        parent.classList.add('menu-open');
                        subMenu.style.display = 'block';
                    }
                }
            });
        });
    });

</script>
@endpush


@push('styles')
<style>
    /* Sub-menu awal disembunyikan */
    .nav-treeview {
        display: none;
        margin-left: 20px;
        transition: all 0.3s ease-in-out;
    }

    /* Menu terbuka */
    .menu-open > .nav-treeview {
        display: block;
    }

    /* Tambahkan transisi untuk sub-menu */
    .nav-treeview li {
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease-in-out;
    }

    .menu-open .nav-treeview li {
        opacity: 1;
        transform: translateY(0);
    }

</style>
@endpush


