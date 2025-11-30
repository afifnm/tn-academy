<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | E-Tarnus Malang</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-700 via-blue-500 to-blue-400 min-h-screen flex items-center justify-center font-sans">

  <div class="bg-white/95 backdrop-blur-lg shadow-2xl rounded-2xl w-full max-w-md p-8 animate-fadeIn">
    <!-- Logo / Judul -->
    <div class="text-center mb-8">
      <!-- Ikon -->
      <div class="w-16 h-16 mx-auto mb-3 bg-blue-600 text-white rounded-full flex items-center justify-center shadow-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
        </svg>
      </div>
      <h1 class="text-2xl font-bold text-blue-700">E-Tarnus Malang</h1>
    </div>

    <!-- Form Login -->
    <form action="<?= base_url('auth/login') ?>" method="post" class="space-y-6">
      <div>
        <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
        <input type="text" id="username" name="username" placeholder="Masukkan Username"
          class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
      </div>

      <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
        <div class="relative">
          <input type="password" id="password" name="password" placeholder="Masukkan Password"
            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition">
          <!-- Icon mata -->
          <button type="button" onclick="togglePassword()" 
            class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-blue-600">
            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
          </button>
        </div>
      </div>

      <button type="submit"
        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-2.5 rounded-xl shadow-md transition transform hover:scale-[1.02]">
        Login
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-sm text-gray-500 mt-6">
      © 2025 E-Tarnus Malang
    </p>
  </div>

  <script>
    function togglePassword() {
      const password = document.getElementById("password");
      const eyeIcon = document.getElementById("eyeIcon");
      if (password.type === "password") {
        password.type = "text";
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a10.053 10.053 0 012.719-4.182m4.62-2.675A9.969 9.969 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.957 9.957 0 01-4.038 5.223M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>`;
      } else {
        password.type = "password";
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
      }
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
<?php if($this->session->flashdata('notifikasi')): ?>
Swal.fire({ 
    icon: '<?= $this->session->flashdata('icon') ?>', 
    text: '<?= $this->session->flashdata('notifikasi') ?>',
    confirmButtonText: 'OK',
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    customClass: {
        confirmButton: 'swal2-confirm-ungu' // pakai custom class
    }
});
<?php endif; ?>
</script>

</body>
</html>
