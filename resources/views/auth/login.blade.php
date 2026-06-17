<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - SMK Muhammadiyah 1 Bantul</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script>
    tailwind.config = {
      theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { primary: '#f97316', secondary: '#ea580c' } } }
    }
  </script>
</head>
<body class="font-sans min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 flex items-center justify-center p-4">

  <div class="w-full max-w-md">
    {{-- Logo Card --}}
    <div class="text-center mb-8">
      <div class="inline-flex items-center justify-center w-16 h-16 bg-primary rounded-2xl shadow-lg mb-4">
        <i class="fas fa-graduation-cap text-white text-2xl"></i>
      </div>
      <h1 class="text-2xl font-bold text-white">Admin Panel</h1>
      <p class="text-slate-400 text-sm mt-1">SMK Muhammadiyah 1 Bantul</p>
    </div>

    {{-- Login Card --}}
    <div class="bg-white rounded-2xl shadow-2xl p-8">
      <h2 class="text-xl font-bold text-slate-800 mb-2">Masuk ke Dashboard</h2>
      <p class="text-slate-500 text-sm mb-6">Masukkan kredensial admin Anda untuk melanjutkan.</p>

      @if($errors->any())
        <div class="mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-start gap-2">
          <i class="fas fa-exclamation-circle mt-0.5 flex-shrink-0"></i>
          <div>
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}" class="space-y-5">
        @csrf

        <div>
          <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Username / Email</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-user text-slate-400"></i>
            </div>
            <input
              type="text"
              id="email"
              name="email"
              value="{{ old('email') }}"
              required
              autofocus
              class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-slate-800 text-sm @error('email') border-red-400 @enderror"
              placeholder="kesehatan / wawancara / pembayaran"
            >
          </div>
        </div>

        <div>
          <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <i class="fas fa-lock text-slate-400"></i>
            </div>
            <input
              type="password"
              id="password"
              name="password"
              required
              autocomplete="current-password"
              class="w-full pl-10 pr-10 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition text-slate-800 text-sm"
              placeholder="••••••••"
            >
            <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3 flex items-center">
              <i id="pwd-icon" class="fas fa-eye text-slate-400 hover:text-slate-600"></i>
            </button>
          </div>
        </div>

        <div class="flex items-center">
          <input id="remember" name="remember" type="checkbox" value="1"
            class="h-4 w-4 text-primary border-slate-300 rounded focus:ring-primary">
          <label for="remember" class="ml-2 text-sm text-slate-600">Ingat saya</label>
        </div>

        <button type="submit"
          class="w-full bg-primary hover:bg-secondary text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-primary/30 flex items-center justify-center gap-2">
          <i class="fas fa-sign-in-alt"></i>
          Masuk
        </button>
      </form>
    </div>

    <p class="text-center text-slate-500 text-xs mt-6">
      &copy; {{ date('Y') }} SMK Muhammadiyah 1 Bantul
    </p>
  </div>

  <script>
    function togglePassword() {
      const pwd = document.getElementById('password');
      const icon = document.getElementById('pwd-icon');
      if (pwd.type === 'password') {
        pwd.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
      } else {
        pwd.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
      }
    }
  </script>
</body>
</html>
