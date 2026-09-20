<?php

namespace Database\Seeders;

use App\Models\Applicant;
use App\Models\Company;
use App\Models\JobListing;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin account for the backend panel.
        $admin = User::updateOrCreate(
            ['email' => 'admin@bkk.test'],
            [
                'name' => 'Administrator BKK',
                'phone_number' => '081100000001',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'headline' => 'System Manager | BKK Intelligence',
                'bio' => 'Administrator pusat untuk pengelolaan sistem Bursa Kerja Khusus Informasi Kerja.',
                'location' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'city' => 'Jakarta Pusat',
            ]
        );

        // Indonesian Provinces & Cities for realistic seeding
        $locations = [
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Selatan'],
            ['province' => 'DKI Jakarta', 'city' => 'Jakarta Barat'],
            ['province' => 'Jawa Barat', 'city' => 'Bandung'],
            ['province' => 'Jawa Barat', 'city' => 'Bekasi'],
            ['province' => 'Jawa Timur', 'city' => 'Surabaya'],
            ['province' => 'Jawa Tengah', 'city' => 'Semarang'],
            ['province' => 'Banten', 'city' => 'Tangerang'],
            ['province' => 'DI Yogyakarta', 'city' => 'Yogyakarta'],
        ];

        // Company accounts
        $companySeed = [
            [
                'user' => ['name' => 'HRD Maju Sejahtera', 'email' => 'hrd@majusejahtera.test', 'phone' => '081200000001'],
                'company' => ['name' => 'PT Maju Mundur Sejahtera', 'address' => 'Jl. Jendral Sudirman No. 12, Jakarta Selatan', 'website' => 'https://majusejahtera.test'],
                'jobs' => [
                    ['title' => 'Senior Laravel Backend Developer', 'location' => 'Jakarta Selatan', 'salary' => 'Rp 12.000.000 - Rp 18.000.000', 'status' => 'open'],
                    ['title' => 'QA Engineer', 'location' => 'Jakarta Selatan', 'salary' => 'Rp 8.000.000 - Rp 11.000.000', 'status' => 'open'],
                    ['title' => 'Product Manager', 'location' => 'Jakarta Barat', 'salary' => 'Rp 15.000.000 - Rp 25.000.000', 'status' => 'open'],
                ],
            ],
            [
                'user' => ['name' => 'Rekrutmen Tech Media', 'email' => 'career@techmedia.test', 'phone' => '081200000002'],
                'company' => ['name' => 'Tech Media Solusindo', 'address' => 'Jl. Setiabudi No. 45, Bandung', 'website' => 'https://techmedia.test'],
                'jobs' => [
                    ['title' => 'Mobile UI/UX Designer', 'location' => 'Bandung', 'salary' => 'Rp 9.000.000 - Rp 14.000.000', 'status' => 'open'],
                    ['title' => 'Front-end Developer (React)', 'location' => 'Remote', 'salary' => 'Rp 10.000.000 - Rp 16.000.000', 'status' => 'open'],
                    ['title' => 'Flutter Developer', 'location' => 'Remote', 'salary' => 'Rp 10.000.000 - Rp 15.000.000', 'status' => 'pending'],
                ],
            ],
            [
                'user' => ['name' => 'Talent Acquisition Nusantara', 'email' => 'talent@nusantara.test', 'phone' => '081200000003'],
                'company' => ['name' => 'Nusantara Creative Agency', 'address' => 'Jl. Malioboro No. 1, Yogyakarta', 'website' => 'https://nusantara.test'],
                'jobs' => [
                    ['title' => 'Graphic Designer', 'location' => 'Yogyakarta', 'salary' => 'Rp 5.000.000 - Rp 8.000.000', 'status' => 'open'],
                    ['title' => 'Social Media Specialist', 'location' => 'Surabaya', 'salary' => 'Rp 6.000.000 - Rp 9.000.000', 'status' => 'open'],
                ],
            ],
        ];

        foreach ($companySeed as $seed) {
            $companyUser = User::updateOrCreate(
                ['email' => $seed['user']['email']],
                [
                    'name' => $seed['user']['name'],
                    'phone_number' => $seed['user']['phone'],
                    'role' => 'company',
                    'password' => Hash::make('password'),
                    'email_verified_at' => now(),
                    'headline' => 'HR Specialist at '.$seed['company']['name'],
                ]
            );

            $company = Company::updateOrCreate(
                ['user_id' => $companyUser->id],
                [
                    'name' => $seed['company']['name'],
                    'description' => 'Perusahaan mitra Bursa Kerja Khusus yang berfokus pada inovasi dan pertumbuhan karir alumni.',
                    'address' => $seed['company']['address'],
                    'website' => $seed['company']['website'],
                ]
            );

            foreach ($seed['jobs'] as $job) {
                JobListing::updateOrCreate(
                    ['company_id' => $company->id, 'title' => $job['title']],
                    [
                        'description' => 'Kami membuka kesempatan untuk posisi '.$job['title'].'. Bergabunglah dengan tim kami yang dinamis dan berkembang pesat.',
                        'requirements' => "- Minimal D3/S1 sesuai bidang\n- Pengalaman minimal 1-2 tahun\n- Mampu bekerja dalam tim maupun mandiri\n- Proaktif, komunikatif, dan memiliki passion di bidangnya",
                        'location' => $job['location'],
                        'salary' => $job['salary'],
                        'status' => $job['status'],
                    ]
                );
            }
        }

        // Applicant accounts.
        $applicantOne = User::updateOrCreate(
            ['email' => 'budi@pelamar.test'],
            [
                'name' => 'Budi Santoso',
                'phone_number' => '081300000001',
                'role' => 'applicant',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'headline' => 'Fresh Graduate | Aspiring Web Developer',
                'bio' => 'Lulusan teknik informatika yang antusias dengan pengembangan teknologi web terutama menggunakan Laravel.',
                'location' => 'Bekasi',
                'province' => 'Jawa Barat',
                'city' => 'Bekasi',
            ]
        );

        User::updateOrCreate(
            ['email' => 'siti@pelamar.test'],
            [
                'name' => 'Siti Aminah',
                'phone_number' => '081300000002',
                'role' => 'applicant',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'headline' => 'Junior UI/UX Designer',
                'bio' => 'Berpengalaman dalam merancang antarmuka pengguna yang intuitif dan menarik.',
                'location' => 'Bandung',
                'province' => 'Jawa Barat',
                'city' => 'Bandung',
            ]
        );

        // Applications
        $openJobs = JobListing::where('status', 'open')->get();

        foreach($openJobs->take(3) as $index => $job) {
            $status = ['accepted', 'pending', 'rejected'][$index];
            Applicant::updateOrCreate(
                ['user_id' => $applicantOne->id, 'job_listing_id' => $job->id],
                [
                    'resume' => 'https://drive.google.com/sample-cv-link',
                    'cover_letter' => 'Saya sangat tertarik dengan posisi ' . $job->title . ' dan yakin kualifikasi saya sesuai.',
                    'status' => $status,
                ]
            );
        }
    }
}
