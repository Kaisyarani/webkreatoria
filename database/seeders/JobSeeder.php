<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Job;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    $perusahaan1 = User::firstOrCreate(
        ['email' => 'hr@gojek.com'],
        ['name' => 'Gojek', 'password' => bcrypt('password'), 'account_type' => 'perusahaan']
    );
    $perusahaan2 = User::firstOrCreate(
        ['email' => 'hr@tokopedia.com'],
        ['name' => 'Tokopedia', 'password' => bcrypt('password'), 'account_type' => 'perusahaan']
    );

    Job::create([
        'user_id' => $perusahaan1->id,
        'title' => 'Senior UI/UX Designer',
        'location' => 'Jakarta, Indonesia',
        'type' => 'Full-time',
        'description' => 'Mencari desainer UI/UX berpengalaman untuk memimpin desain produk inti kami, berkolaborasi dengan manajer produk dan engineer untuk menciptakan pengalaman pengguna yang mulus.',
        'tags' => ['UI/UX', 'Mobile Apps', 'Design System'],
        'deadline' => now()->addMonths(1),
    ]);

    Job::create([
        'user_id' => $perusahaan2->id,
        'title' => 'Frontend Developer (React)',
        'location' => 'Remote',
        'type' => 'Full-time',
        'description' => 'Kami mencari developer Frontend yang mahir dengan React dan TypeScript untuk membangun komponen UI yang reusable dan modern untuk platform e-commerce kami.',
        'tags' => ['React', 'TypeScript', 'Frontend'],
        'deadline' => now()->addMonths(2),
    ]);
}
}
