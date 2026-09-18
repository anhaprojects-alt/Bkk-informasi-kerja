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
        User::updateOrCreate(
            ['email' => 'admin@bkk.test'],
            [
                'name' => 'Administrator BKK',
                'phone_number' => '081100000001',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Company accounts, each with a profile and a few job listings.
        $companySeed = [
            [
                'user' => ['name' => 'HRD Maju Sejahtera', 'email' => 'hrd@majusejahtera.test', 'phone' => '081200000001'],
                'company' => ['name' => 'PT Maju Mundur Sejahtera', 'address' => 'Jakarta Selatan', 'website' => 'https://majusejahtera.test'],
                'jobs' => [
                    ['title' => 'Senior Laravel Backend Developer', 'location' => 'Jakarta Selatan', 'salary' => 'Rp 12.000.000 - Rp 18.000.000', 'status' => 'open'],
                    ['title' => 'QA Engineer', 'location' => 'Jakarta Selatan', 'salary' => 'Rp 8.000.000 - Rp 11.000.000', 'status' => 'open'],
                ],
            ],
            [
                'user' => ['name' => 'Rekrutmen Tech Media', 'email' => 'career@techmedia.test', 'phone' => '081200000002'],
                'company' => ['name' => 'Tech Media Solusindo', 'address' => 'Bandung', 'website' => 'https://techmedia.test'],
                'jobs' => [
                    ['title' => 'Mobile UI/UX Designer', 'location' => 'Bandung (Remote)', 'salary' => 'Rp 9.000.000 - Rp 14.000.000', 'status' => 'open'],
                    ['title' => 'Flutter Developer', 'location' => 'Remote', 'salary' => 'Rp 10.000.000 - Rp 15.000.000', 'status' => 'pending'],
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
                ]
            );

            $company = Company::updateOrCreate(
                ['user_id' => $companyUser->id],
                [
                    'name' => $seed['company']['name'],
                    'description' => 'Perusahaan mitra Bursa Kerja Khusus.',
                    'address' => $seed['company']['address'],
                    'website' => $seed['company']['website'],
                ]
            );

            foreach ($seed['jobs'] as $job) {
                JobListing::updateOrCreate(
                    ['company_id' => $company->id, 'title' => $job['title']],
                    [
                        'description' => 'Kami membuka kesempatan untuk posisi '.$job['title'].'. Bergabunglah dengan tim kami yang dinamis dan berkembang.',
                        'requirements' => "- Minimal D3/S1 sesuai bidang\n- Pengalaman minimal 1 tahun\n- Mampu bekerja dalam tim\n- Komunikatif dan bertanggung jawab",
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
            ]
        );

        // Rich sample applications so the smart metrics dashboard renders beautifully.
        $openJobs = JobListing::where('status', 'open')->get();

        if ($openJobs->count() >= 3) {
            // Budi's application history funnel (accepted, pending, rejected)
            Applicant::updateOrCreate(
                ['user_id' => $applicantOne->id, 'job_listing_id' => $openJobs[0]->id],
                [
                    'resume' => 'https://drive.google.com/drive/folders/sample-budi-cv',
                    'cover_letter' => 'Saya tertarik dan yakin dapat berkontribusi maksimal pada posisi backend developer ini.',
                    'status' => 'accepted',
                ]
            );

            Applicant::updateOrCreate(
                ['user_id' => $applicantOne->id, 'job_listing_id' => $openJobs[1]->id],
                [
                    'resume' => 'https://drive.google.com/drive/folders/sample-budi-cv',
                    'cover_letter' => 'Besar harapan saya untuk dapat berdiskusi mengenai kualifikasi saya sebagai QA engineer.',
                    'status' => 'pending',
                ]
            );

            Applicant::updateOrCreate(
                ['user_id' => $applicantOne->id, 'job_listing_id' => $openJobs[2]->id],
                [
                    'resume' => 'https://drive.google.com/drive/folders/sample-budi-cv',
                    'cover_letter' => 'Lamaran dikirim namun belum mendapat respons.',
                    'status' => 'rejected',
                ]
            );
        }
    }
}
