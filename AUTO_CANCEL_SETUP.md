# Auto-Cancel Pending Orders Setup

## Deskripsi
Sistem ini secara otomatis membatalkan pesanan yang masih berstatus `pending` bila sudah lebih dari 3 hari sejak dibuat.

## Fitur
- ✅ Auto-cancel pesanan pending yang > 3 hari
- ✅ Berjalan otomatis setiap hari jam 00:00 (tengah malam)
- ✅ Mencatat jumlah pesanan yang dibatalkan

## Cara Mengtes (Development)

### 1. Test Manual dengan Command
```bash
php artisan app:auto-cancel-pending-orders
```

Perintah di atas akan langsung menjalankan auto-cancel dan menampilkan hasilnya.

### 2. Setup Scheduler (Production)

Untuk menjalankan auto-cancel secara otomatis setiap hari, Anda perlu setup cron job di server:

**Di Linux/Mac:**
```bash
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

Tambahkan baris di atas ke crontab:
```bash
crontab -e
```

**Di Windows:**
Gunakan Windows Task Scheduler untuk menjalankan:
```bash
php C:\path\to\project\artisan schedule:run
```

Jalankan setiap menit agar scheduler Laravel bisa execute tasks.

## Konfigurasi

Untuk mengubah interval waktu (default: 3 hari), edit file:
```
app/Console/Commands/AutoCancelPendingOrders.php
```

Ubah baris:
```php
$threeDaysAgo = Carbon::now()->subDays(3);  // Ubah angka 3
```

## Dokumentasi
- File Command: `app/Console/Commands/AutoCancelPendingOrders.php`
- File Scheduler: `routes/console.php`
