@php
    $successMessages = [
        'Register berhasil. Silakan login.' => 'Your account is ready. Sign in to continue.',
        'Transaksi berhasil disimpan.' => 'Transaction added.',
        'Transaksi berhasil diperbarui.' => 'Transaction updated.',
        'Transaksi berhasil dihapus.' => 'Transaction deleted.',
        'Kategori berhasil disimpan.' => 'Category added.',
        'Kategori berhasil diperbarui.' => 'Category updated.',
        'Kategori berhasil dihapus.' => 'Category deleted.',
        'Budget berhasil disimpan.' => 'Budget added.',
        'Budget berhasil diperbarui.' => 'Budget updated.',
        'Budget berhasil dihapus.' => 'Budget deleted.',
        'Profil berhasil diperbarui.' => 'Profile updated.',
        'Password berhasil diperbarui.' => 'Password updated.',
        'User berhasil dijadikan admin.' => 'User role changed to Admin.',
        'Admin berhasil dijadikan user.' => 'User role changed to Standard User.',
    ];

    $messageTranslations = [
        'Email atau password salah.' => 'The email address or password is incorrect.',
        'Nama wajib diisi.' => 'Enter your name.',
        'Email wajib diisi.' => 'Enter your email address.',
        'Email tidak valid.' => 'Enter a valid email address.',
        'Email sudah digunakan.' => 'An account with this email address already exists.',
        'Password wajib diisi.' => 'Enter your password.',
        'Password minimal 6 karakter.' => 'Use a password with at least 6 characters.',
        'Konfirmasi password tidak cocok.' => 'The passwords do not match.',
        'Password saat ini tidak sesuai.' => 'Your current password is incorrect.',
        'Jenis transaksi tidak valid.' => 'Choose a valid transaction type.',
        'Kategori wajib dipilih.' => 'Choose a category.',
        'Kategori tidak valid.' => 'Choose a valid category.',
        'Nominal wajib diisi.' => 'Enter an amount.',
        'Nominal harus berupa angka.' => 'Enter a valid amount.',
        'Nominal harus lebih dari nol.' => 'Enter an amount greater than zero.',
        'Keterangan wajib diisi.' => 'Enter a description.',
        'Keterangan maksimal 255 karakter.' => 'Keep the description under 255 characters.',
        'Tanggal wajib diisi.' => 'Choose a date.',
        'Tanggal tidak valid.' => 'Choose a valid date.',
        'Tanggal akhir harus sama atau setelah tanggal awal.' => 'The end date must be on or after the start date.',
        'Nama kategori wajib diisi.' => 'Enter a category name.',
        'Nama kategori sudah digunakan.' => 'You already have a category with this name.',
        'Budget untuk kategori dan periode ini sudah ada.' => 'A budget already exists for this category and period.',
        'Bulan tidak valid.' => 'Choose a valid month.',
        'Tahun tidak valid.' => 'Enter a valid year.',
        'Kamu tidak dapat menghapus role admin sendiri.' => 'You cannot remove your own admin access.',
        'Analisis AI belum tersedia. Tambahkan OPENAI_API_KEY pada konfigurasi aplikasi.' => 'AI analysis is not set up yet. Add OPENAI_API_KEY to the server environment.',
        'Analisis AI sedang mengalami kendala. Coba lagi beberapa saat lagi.' => 'AI analysis could not be generated right now. Please try again shortly.',
    ];

    $fieldMessages = [
        'name' => 'Enter a valid name.',
        'email' => 'Enter a valid email address.',
        'password' => 'Check your password and try again.',
        'password_confirmation' => 'The passwords do not match.',
        'current_password' => 'Your current password is incorrect.',
        'type' => 'Choose a valid transaction type.',
        'category_id' => 'Choose a valid category.',
        'amount' => 'Enter a valid amount.',
        'description' => 'Enter a valid description.',
        'date' => 'Choose a valid date.',
        'date_from' => 'Choose a valid start date.',
        'date_to' => 'Choose an end date on or after the start date.',
        'month' => 'Choose a valid month.',
        'year' => 'Enter a valid year.',
    ];

    $successMessage = session('success');
    $successMessage = $successMessages[$successMessage] ?? $successMessage;

    $displayErrors = [];
    foreach ($errors->messages() as $field => $messages) {
        foreach ($messages as $message) {
            $displayErrors[] = $messageTranslations[$message]
                ?? $fieldMessages[$field]
                ?? 'Please review your information and try again.';
        }
    }
    $displayErrors = array_values(array_unique($displayErrors));

    $sessionError = session('error') ?? session('ai_error');
    if ($sessionError) {
        $displayErrors[] = $messageTranslations[$sessionError]
            ?? 'Something went wrong. Please try again.';
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