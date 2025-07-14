<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>SMK Perkasa 2 Sumedang</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="max-w-6xl mx-auto px-4">
      <div class="flex justify-between items-center py-4">
        <div class="flex items-center space-x-3">
          <img src="public/images/logo.png" alt="Logo" class="h-10">
          <span class="text-lg font-bold">SMK Perkasa 2 Sumedang</span>
        </div>

        <div class="hidden md:flex space-x-6">
          <a href="#" class="hover:text-blue-600">Beranda</a>
          <a href="#profil" class="hover:text-blue-600">Profil</a>
          <a href="public/index.php?page=login" class="hover:text-blue-600">Login Absensi</a>
        </div>

        <!-- Hamburger menu -->
        <div class="md:hidden">
          <button id="menuBtn" class="focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden px-4 pb-4">
      <a href="#" class="block py-2">Beranda</a>
      <a href="#profil" class="block py-2">Profil</a>
      <a href="public/index.php?page=login" class="block py-2">Login Absensi</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="pt-20">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center px-4 py-12">
      <div class="md:w-1/2">
        <h1 class="text-3xl md:text-5xl font-bold mb-4">Selamat Datang di SMK Perkasa 2 Sumedang</h1>
        <p class="text-lg mb-6">Mewujudkan siswa yang kompeten, berdaya saing dan siap kerja di era industri 4.0.</p>
        <a href="#profil" class="bg-blue-600 text-white px-6 py-2 rounded shadow hover:bg-blue-700">
          Lihat Profil
        </a>
      </div>
      <div class="md:w-1/2 mt-8 md:mt-0">
        <img src="public/images/hero.jpg" alt="Hero Image" class="rounded-xl shadow-lg">
      </div>
    </div>
  </section>

  <!-- Profil Section -->
  <section id="profil" class="bg-white py-12">
    <div class="max-w-6xl mx-auto px-4">
      <h2 class="text-2xl font-bold text-center mb-8">Konsentrasi Keahlian</h2>
      <div class="grid md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="bg-gray-100 rounded-xl shadow p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Teknik Komputer dan Jaringan</h3>
          <p>Mengajarkan instalasi jaringan, perangkat keras, dan sistem keamanan komputer modern.</p>
        </div>
        <!-- Card 2 -->
        <div class="bg-gray-100 rounded-xl shadow p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Teknik Pemesinan</h3>
          <p>Fokus pada penggunaan mesin produksi, CNC, dan teknik manufaktur presisi.</p>
        </div>
        <!-- Card 3 -->
        <div class="bg-gray-100 rounded-xl shadow p-6 text-center hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Teknik Kendaraan Ringan</h3>
          <p>Mengajarkan perawatan dan perbaikan kendaraan bermotor roda empat.</p>
        </div>
      </div>
    </div>
  </section>

  <footer class="text-center py-6 bg-gray-200 mt-10 text-sm">
    &copy; <?= date('Y') ?> SMK Perkasa 2 Sumedang. All rights reserved.
  </footer>

  <!-- JS Hamburger Toggle -->
  <script>
    const btn = document.getElementById("menuBtn");
    const menu = document.getElementById("mobileMenu");
    btn.addEventListener("click", () => {
      menu.classList.toggle("hidden");
    });
  </script>

</body>
</html>
