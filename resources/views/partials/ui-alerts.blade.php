@php
    $successMessages = [
        'Register berhasil. Silakan login.' => 'Pendaftaran berhasil. Silakan masuk.',
        'Transaksi berhasil disimpan.' => 'Transaksi berhasil disimpan.',
        'Transaksi berhasil diperbarui.' => 'Transaksi berhasil diperbarui.',
        'Transaksi berhasil dihapus.' => 'Transaksi berhasil dihapus.',
        'Kategori berhasil disimpan.' => 'Kategori berhasil disimpan.',
        'Kategori berhasil diperbarui.' => 'Kategori berhasil diperbarui.',
        'Kategori berhasil dihapus.' => 'Kategori berhasil dihapus.',
        'Budget berhasil disimpan.' => 'Anggaran berhasil disimpan.',
        'Budget berhasil diperbarui.' => 'Anggaran berhasil diperbarui.',
        'Budget berhasil dihapus.' => 'Anggaran berhasil dihapus.',
        'Profil berhasil diperbarui.' => 'Profil berhasil diperbarui.',
        'Password berhasil diperbarui.' => 'Kata sandi berhasil diperbarui.',
        'User berhasil dijadikan admin.' => 'Peran berhasil diubah menjadi admin.',
        'Admin berhasil dijadikan user.' => 'Peran berhasil diubah menjadi pengguna.',
    ];

    $messageTranslations = [
        'Email atau password salah.' => 'Email atau kata sandi salah.',
        'Nama wajib diisi.' => 'Nama wajib diisi.',
        'Email wajib diisi.' => 'Alamat email wajib diisi.',
        'Email tidak valid.' => 'Alamat email tidak valid.',
        'Email sudah digunakan.' => 'Alamat email sudah digunakan.',
        'Password wajib diisi.' => 'Kata sandi wajib diisi.',
        'Password minimal 6 karakter.' => 'Kata sandi minimal 6 karakter.',
        'Konfirmasi password tidak cocok.' => 'Konfirmasi kata sandi tidak cocok.',
        'Password saat ini tidak sesuai.' => 'Kata sandi saat ini tidak sesuai.',
        'Jenis transaksi tidak valid.' => 'Pilih jenis transaksi yang valid.',
        'Kategori wajib dipilih.' => 'Kategori wajib dipilih.',
        'Kategori tidak valid.' => 'Pilih kategori yang valid.',
        'Nominal wajib diisi.' => 'Nominal wajib diisi.',
        'Nominal harus berupa angka.' => 'Masukkan nominal yang valid.',
        'Nominal harus lebih dari nol.' => 'Nominal harus lebih dari nol.',
        'Keterangan wajib diisi.' => 'Keterangan wajib diisi.',
        'Keterangan maksimal 255 karakter.' => 'Keterangan maksimal 255 karakter.',
        'Tanggal wajib diisi.' => 'Tanggal wajib diisi.',
        'Tanggal tidak valid.' => 'Pilih tanggal yang valid.',
        'Tanggal akhir harus sama atau setelah tanggal awal.' => 'Tanggal akhir harus sama atau setelah tanggal awal.',
        'Nama kategori wajib diisi.' => 'Nama kategori wajib diisi.',
        'Nama kategori sudah digunakan.' => 'Nama kategori sudah digunakan.',
        'Budget untuk kategori dan periode ini sudah ada.' => 'Anggaran untuk kategori dan periode ini sudah ada.',
        'Bulan tidak valid.' => 'Pilih bulan yang valid.',
        'Tahun tidak valid.' => 'Masukkan tahun yang valid.',
        'Kamu tidak dapat menghapus role admin sendiri.' => 'Anda tidak dapat menghapus peran admin sendiri.',
        'Analisis AI belum tersedia. Tambahkan OPENAI_API_KEY pada konfigurasi aplikasi.' => 'Analisis AI belum tersedia. Tambahkan OPENAI_API_KEY pada konfigurasi aplikasi.',
        'Analisis AI sedang mengalami kendala. Coba lagi beberapa saat lagi.' => 'Analisis AI gagal dibuat. Silakan coba lagi beberapa saat.',
    ];

    $fieldMessages = [
        'name' => 'Masukkan nama yang valid.',
        'email' => 'Masukkan alamat email yang valid.',
        'password' => 'Periksa kembali kata sandi Anda.',
        'password_confirmation' => 'Konfirmasi kata sandi tidak cocok.',
        'current_password' => 'Kata sandi saat ini tidak sesuai.',
        'type' => 'Pilih jenis transaksi yang valid.',
        'category_id' => 'Pilih kategori yang valid.',
        'amount' => 'Masukkan nominal yang valid.',
        'description' => 'Masukkan keterangan yang valid.',
        'date' => 'Pilih tanggal yang valid.',
        'date_from' => 'Pilih tanggal awal yang valid.',
        'date_to' => 'Pilih tanggal akhir setelah tanggal awal.',
        'month' => 'Pilih bulan yang valid.',
        'year' => 'Masukkan tahun yang valid.',
    ];

    $successMessage = session('success');
    $successMessage = $successMessages[$successMessage] ?? $successMessage;

    $displayErrors = [];
    foreach ($errors->messages() as $field => $messages) {
        foreach ($messages as $message) {
            $displayErrors[] = $messageTranslations[$message]
                ?? $fieldMessages[$field]
                ?? 'Periksa kembali data yang Anda masukkan.';
        }
    }
    $displayErrors = array_values(array_unique($displayErrors));

    $sessionError = session('error') ?? session('ai_error');
    if ($sessionError) {
        $displayErrors[] = $messageTranslations[$sessionError]
            ?? 'Terjadi kesalahan. Silakan coba lagi.';
    }
@endphp

@if($successMessage)
    <div class="success-message {{ $alertClass ?? '' }}" role="status">{{ $successMessage }}</div>
@endif

@if($displayErrors)
    <div class="error-message {{ $alertClass ?? '' }}" role="alert">
        @foreach($displayErrors as $displayError)
            <p>{{ $displayError }}</p>
        @endforeach
    </div>
@endif