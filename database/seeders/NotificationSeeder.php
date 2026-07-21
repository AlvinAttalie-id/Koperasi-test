<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clean existing notifications
        Notification::query()->delete();

        $faker = Faker::create('id_ID');
        $userIds = User::pluck('id')->toArray();

        if (empty($userIds)) {
            return;
        }

        $templates = [
            [
                'title' => 'Selamat Datang di Koperasi',
                'message' => 'Selamat datang di Sistem Informasi Koperasi. Pastikan data profil Anda selalu diperbarui.',
            ],
            [
                'title' => 'Pendaftaran Anggota Berhasil',
                'message' => 'Selamat, pendaftaran keanggotaan Anda telah berhasil disetujui oleh tim Front Office.',
            ],
            [
                'title' => 'Pembaruan Data Profil',
                'message' => 'Informasi profil diri dan alamat domisili Anda telah berhasil diperbarui.',
            ],
            [
                'title' => 'Notifikasi Keamanan',
                'message' => 'Terdeteksi aktivitas masuk dari perangkat baru. Jika ini bukan Anda, segera ubah kata sandi.',
            ],
            [
                'title' => 'Pengumuman Rapat Anggota Tahunan',
                'message' => 'Rapat Anggota Tahunan (RAT) Koperasi akan diselenggarakan secara hybrid minggu depan.',
            ],
            [
                'title' => 'Verifikasi Berkas Identitas',
                'message' => 'Berkas NIK dan data kependudukan Anda telah berhasil divalidasi.',
            ],
        ];

        $notifications = [];

        for ($i = 0; $i < 200; $i++) {
            $tmpl = $faker->randomElement($templates);
            $createdAt = $faker->dateTimeBetween('-1 month', 'now');

            $notifications[] = [
                'user_id' => $faker->randomElement($userIds),
                'title' => $tmpl['title'],
                'message' => $tmpl['message'],
                'is_read' => $faker->boolean(40), // 40% read status
                'created_at' => $createdAt->format('Y-m-d H:i:s'),
            ];
        }

        foreach (array_chunk($notifications, 100) as $chunk) {
            Notification::insert($chunk);
        }
    }
}
