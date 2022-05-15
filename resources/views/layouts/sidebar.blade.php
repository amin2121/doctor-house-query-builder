<div class="main-sidebar sidebar-style-2">
  <aside id="sidebar-wrapper">
    <div class="sidebar-brand">
      <a href="index.html">DOCTOR-HOUSE</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
      <a href="index.html">DH</a>
    </div>
    <ul class="sidebar-menu">
      <li class="menu-header">Menu Utama</li>
      <li class="dropdown ">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Master Data</span></a>
        <ul class="dropdown-menu">
          <li class=""><a class="nav-link" href="{{ route('jenis_obat') }}">Jenis Obat</a></li>
          <li><a class="nav-link" href="{{ route('pasien') }}">Pasien</a></li>
          <li><a class="nav-link" href="{{ route('dokter') }}">Dokter</a></li>
          <li><a class="nav-link" href="{{ route('supplier') }}">Supplier</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Stok Obat</span></a>
        <ul class="dropdown-menu">
          <li class=""><a class="nav-link" href="{{ route('obat') }}">Data Obat</a></li>
          <li><a class="nav-link" href="{{ route('faktur-pembelian') }}">Faktur Pembelian</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Pemeriksaan</span></a>
        <ul class="dropdown-menu">
          <li class=""><a class="nav-link" href="{{ route('pemeriksaan-pasien') }}">Pemeriksaan Pasien</a></li>
        </ul>
      </li>
      <li class="dropdown">
        <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Riwayat</span></a>
        <ul class="dropdown-menu">
          <li class=""><a class="nav-link" href="{{ route('riwayat-pemeriksaan-pasien') }}">Pemeriksaan Pasien</a></li>
        </ul>
      </li>
    </ul>
  </aside>
</div>