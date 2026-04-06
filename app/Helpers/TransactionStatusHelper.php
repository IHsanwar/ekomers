<?php

namespace App\Helpers;

class TransactionStatusHelper
{
    /**
     * Daftar lengkap status transaksi dengan konfigurasi
     */
    public static function getStatuses()
    {
        return [
            'pending' => [
                'label' => 'Pending',
                'description' => 'Menunggu pembayaran',
                'icon' => 'schedule', // Material Icon
                'icon_fa' => 'fa-clock', // Font Awesome
                'color' => 'amber',
                'bg_class' => 'bg-amber-100 text-amber-600 dark:bg-amber-500/20 dark:text-amber-400',
                'badge_class' => 'badge-warning',
            ],
            'confirmed' => [
                'label' => 'Confirmed',
                'description' => 'Pembayaran dikonfirmasi',
                'icon' => 'check_circle',
                'icon_fa' => 'fa-circle-check',
                'color' => 'blue',
                'bg_class' => 'bg-blue-100 text-blue-600 dark:bg-blue-500/20 dark:text-blue-400',
                'badge_class' => 'badge-info',
            ],
            'paid' => [
                'label' => 'Paid',
                'description' => 'Pembayaran diterima',
                'icon' => 'payment',
                'icon_fa' => 'fa-credit-card',
                'color' => 'green',
                'bg_class' => 'bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400',
                'badge_class' => 'badge-success',
            ],
            'shipped' => [
                'label' => 'Shipped',
                'description' => 'Sedang dikirim',
                'icon' => 'local_shipping',
                'icon_fa' => 'fa-truck',
                'color' => 'purple',
                'bg_class' => 'bg-purple-100 text-purple-600 dark:bg-purple-500/20 dark:text-purple-400',
                'badge_class' => 'badge-primary',
            ],
            'completed' => [
                'label' => 'Completed',
                'description' => 'Pesanan selesai',
                'icon' => 'task_alt',
                'icon_fa' => 'fa-check-circle',
                'color' => 'green',
                'bg_class' => 'bg-green-100 text-green-600 dark:bg-green-500/20 dark:text-green-400',
                'badge_class' => 'badge-success',
            ],
            'cancelled' => [
                'label' => 'Cancelled',
                'description' => 'Pesanan dibatalkan',
                'icon' => 'cancel',
                'icon_fa' => 'fa-ban',
                'color' => 'red',
                'bg_class' => 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400',
                'badge_class' => 'badge-danger',
            ],
            'failed' => [
                'label' => 'Failed',
                'description' => 'Pembayaran gagal',
                'icon' => 'error',
                'icon_fa' => 'fa-circle-xmark',
                'color' => 'red',
                'bg_class' => 'bg-red-100 text-red-600 dark:bg-red-500/20 dark:text-red-400',
                'badge_class' => 'badge-danger',
            ],
            'returned' => [
                'label' => 'Returned',
                'description' => 'Pesanan dikembalikan',
                'icon' => 'undo',
                'icon_fa' => 'fa-rotate-left',
                'color' => 'orange',
                'bg_class' => 'bg-orange-100 text-orange-600 dark:bg-orange-500/20 dark:text-orange-400',
                'badge_class' => 'badge-warning',
            ],
            'refunded' => [
                'label' => 'Refunded',
                'description' => 'Pembayaran dikembalikan',
                'icon' => 'refund',
                'icon_fa' => 'fa-money-bill-transfer',
                'color' => 'teal',
                'bg_class' => 'bg-green-100 text-teal-600 dark:bg-teal-500/20 dark:text-teal-400',
                'badge_class' => 'badge-info',
            ],
        ];
    }

    /**
     * Get konfigurasi status tertentu
     */
    public static function getStatus($status)
{
    $statuses = self::getStatuses();

    // Default fallback (SELALU ADA)
    $default = [
        'label' => 'Unknown',
        'description' => 'Status tidak dikenali',
        'icon' => 'help_outline',
        'icon_fa' => 'fa-question-circle',
        'color' => 'gray',
        'bg_class' => 'bg-slate-100 text-slate-600',
        'badge_class' => 'badge-secondary',
    ];

    return $statuses[$status] ?? $default;
}

    /**
     * Get icon untuk status
     */
    public static function getIcon($status, $type = 'material')
    {
        $statusConfig = self::getStatus($status);
        if (!$statusConfig) {
            return null;
        }
        
        return $type === 'fontawesome' ? $statusConfig['icon_fa'] : $statusConfig['icon'];
    }

    /**
     * Get warna class untuk status
     */
    public static function getColorClass($status)
    {
        $statusConfig = self::getStatus($status);
        return $statusConfig['bg_class'] ?? 'bg-slate-100 text-slate-600';
    }

    /**
     * Get label untuk status
     */
    public static function getLabel($status)
    {
        $statusConfig = self::getStatus($status);
        return $statusConfig['label'] ?? ucfirst($status);
    }

    /**
     * Get deskripsi untuk status
     */
    public static function getDescription($status)
    {
        $statusConfig = self::getStatus($status);
        return $statusConfig['description'] ?? '';
    }

    /**
     * Get semua status yang tersedia untuk dropdown
     */
    public static function getAvailableStatuses()
    {
        return array_keys(self::getStatuses());
    }

    /**
     * Get status yang bisa dihapus
     */
    public static function getDeletableStatuses()
    {
        return ['cancelled', 'completed', 'failed'];
    }

    /**
     * Cek apakah status bisa dihapus
     */
    public static function isDeletable($status)
    {
        return in_array($status, self::getDeletableStatuses());
    }

    /**
     * Cek apakah status bisa download invoice
     */
    public static function canDownloadInvoice($status)
    {
        return in_array($status, ['confirmed', 'paid', 'shipped', 'completed']);
    }
}
