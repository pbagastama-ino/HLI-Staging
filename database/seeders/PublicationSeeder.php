<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Publication;
use App\Models\User;
use Carbon\Carbon;

class PublicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first user as the creator
        $user = User::first();
        if (!$user) {
            // Create a default user if none exists
            $user = User::create([
                'name' => 'Admin User',
                'email' => 'admin@hligreenpower.com',
                'password' => bcrypt('password'),
            ]);
        }

        $publications = [
            // Company Activities (Press Releases)
            [
                'title' => 'HLI Green Power Achievement 2025',
                'text' => 'HLI Green Power mencapai milestone penting dalam pengembangan teknologi baterai ramah lingkungan. Dengan inovasi terbaru ini, kami berhasil meningkatkan efisiensi penyimpanan energi hingga 40% dibandingkan teknologi sebelumnya.

Tim Research and Development kami telah bekerja keras selama 2 tahun untuk mengembangkan teknologi baterai lithium-ion yang lebih efisien dan ramah lingkungan. Teknologi ini menggunakan material komposit baru yang mengurangi penggunaan kobalt hingga 60% dan meningkatkan kapasitas penyimpanan energi.

Pencapaian ini merupakan hasil dari investasi besar-besaran dalam penelitian dan pengembangan yang dilakukan HLI Green Power. Kami berkomitmen untuk terus mengembangkan teknologi energi terbarukan yang dapat mendukung transisi energi di Indonesia menuju masa depan yang lebih berkelanjutan.

Teknologi baru ini akan segera diproduksi secara massal dan diharapkan dapat memberikan dampak positif bagi industri energi terbarukan di Indonesia. Kami juga berencana untuk mengekspor teknologi ini ke negara-negara ASEAN sebagai bagian dari strategi ekspansi regional.',
                'image' => null,
                'category' => 'company-activities',
                'published_date' => Carbon::parse('2025-10-12'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'HLI Green Power Achievement 2025 - Breakthrough in Green Battery Technology',
                'meta_description' => 'HLI Green Power achieves major milestone in green battery technology development, increasing energy storage efficiency by 40%.',
                'meta_keywords' => 'HLI Green Power, battery technology, green energy, innovation, achievement',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Sustainable Energy Innovation',
                'text' => 'Tim Research and Development kami telah mengembangkan teknologi baru yang akan mengubah cara kita memandang penyimpanan energi. Inovasi ini akan membantu mengurangi ketergantungan pada energi fosil dan mendukung transisi menuju energi terbarukan.

Teknologi penyimpanan energi terbarukan ini menggunakan sistem hybrid yang menggabungkan baterai lithium-ion dengan superkapasitor. Kombinasi ini memungkinkan penyimpanan energi dalam jumlah besar dengan waktu pengisian yang sangat cepat.

Sistem ini telah diuji coba di fasilitas produksi HLI Green Power dan menunjukkan hasil yang sangat memuaskan. Efisiensi energi meningkat hingga 35% dan waktu pengisian berkurang hingga 50% dibandingkan sistem konvensional.

Kami berencana untuk mengimplementasikan teknologi ini di seluruh fasilitas produksi HLI Green Power dalam 6 bulan ke depan. Selain itu, kami juga sedang dalam proses negosiasi dengan beberapa perusahaan energi terbarukan untuk mengadopsi teknologi ini.',
                'image' => null,
                'category' => 'company-activities',
                'published_date' => Carbon::parse('2025-10-05'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Sustainable Energy Innovation - Revolutionary Energy Storage Technology',
                'meta_description' => 'HLI Green Power develops revolutionary hybrid energy storage system combining lithium-ion batteries with supercapacitors.',
                'meta_keywords' => 'sustainable energy, innovation, energy storage, hybrid system, renewable energy',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Environmental Impact Report',
                'text' => 'Laporan tahunan mengenai dampak lingkungan dari operasional HLI Green Power menunjukkan penurunan signifikan dalam emisi karbon. Hal ini merupakan hasil dari implementasi berbagai program keberlanjutan yang telah kami jalankan sepanjang tahun 2025.

Emisi karbon dari operasional perusahaan turun sebesar 25% dibandingkan tahun sebelumnya. Penurunan ini dicapai melalui penggunaan energi terbarukan di fasilitas produksi, optimasi proses manufaktur, dan implementasi sistem manajemen limbah yang lebih efisien.

Kami juga berhasil mengurangi penggunaan air hingga 30% melalui implementasi sistem daur ulang air dan teknologi pengolahan limbah cair yang lebih canggih. Selain itu, 95% dari limbah padat yang dihasilkan telah berhasil didaur ulang atau digunakan kembali.

Program penghijauan yang kami jalankan telah menanam lebih dari 10,000 pohon di sekitar fasilitas produksi dan komunitas lokal. Kami juga telah membangun taman hijau seluas 5 hektar yang berfungsi sebagai paru-paru kota dan habitat bagi berbagai spesies burung.',
                'image' => null,
                'category' => 'company-activities',
                'published_date' => Carbon::parse('2025-09-28'),
                'status' => 'published',
                'featured' => false,
                'meta_title' => 'Environmental Impact Report 2025 - Significant Carbon Emission Reduction',
                'meta_description' => 'HLI Green Power reports 25% reduction in carbon emissions and 30% reduction in water usage through sustainability programs.',
                'meta_keywords' => 'environmental impact, carbon reduction, sustainability, green manufacturing',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Employee Gathering 2025',
                'text' => 'Kegiatan tahunan yang mempererat hubungan antar karyawan HLI Green Power. Berbagai aktivitas seru dan edukatif diadakan untuk meningkatkan semangat kerja tim dan membangun budaya perusahaan yang positif.

Acara Employee Gathering 2025 diadakan di Trans Studio Bandung dengan tema "Together We Grow". Lebih dari 500 karyawan dari berbagai departemen berpartisipasi dalam berbagai kegiatan yang dirancang untuk meningkatkan teamwork dan komunikasi.

Kegiatan yang diadakan meliputi team building games, workshop pengembangan diri, presentasi inovasi karyawan, dan berbagai kompetisi menarik. Acara ini juga menjadi ajang untuk memberikan penghargaan kepada karyawan berprestasi dan yang telah memberikan kontribusi luar biasa bagi perusahaan.

Selain kegiatan formal, acara ini juga menyediakan waktu untuk bersantai dan berinteraksi dengan sesama karyawan. Berbagai makanan dan minuman khas Indonesia dan Korea disediakan untuk memberikan pengalaman kuliner yang beragam.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-09-20'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Employee Gathering 2025 - Together We Grow',
                'meta_description' => 'HLI Green Power holds annual employee gathering with team building activities and employee recognition.',
                'meta_keywords' => 'employee gathering, team building, company culture, employee recognition',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'CSR: Green School Program',
                'text' => 'Program CSR HLI Green Power untuk mendukung pendidikan lingkungan di sekolah-sekolah sekitar. Kegiatan ini melibatkan edukasi dan penanaman pohon bersama siswa-siswi sekolah dasar dan menengah.

Program Green School telah berjalan selama 3 tahun dan telah menjangkau lebih dari 50 sekolah di sekitar fasilitas produksi HLI Green Power. Program ini bertujuan untuk menanamkan kesadaran lingkungan sejak dini kepada generasi muda.

Kegiatan yang dilakukan meliputi workshop tentang pentingnya menjaga lingkungan, praktik penanaman pohon, pembuatan kompos dari sampah organik, dan berbagai permainan edukatif tentang lingkungan. Setiap sekolah yang berpartisipasi akan mendapatkan bantuan berupa bibit pohon, alat-alat berkebun, dan materi edukasi.

Program ini tidak hanya memberikan manfaat bagi lingkungan, tetapi juga membantu membangun hubungan yang baik antara perusahaan dengan komunitas sekitar. Banyak sekolah yang telah mengadopsi program ini sebagai bagian dari kurikulum ekstrakurikuler mereka.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-09-10'),
                'status' => 'published',
                'featured' => false,
                'meta_title' => 'CSR Green School Program - Environmental Education for Students',
                'meta_description' => 'HLI Green Power CSR program provides environmental education and tree planting activities for local schools.',
                'meta_keywords' => 'CSR, green school, environmental education, community engagement',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Town Hall Meeting',
                'text' => 'Town Hall meeting diadakan setiap 3 bulan sekali. Di acara ini karyawan akan bertemu dengan CEO dan C-Level lainnya. Selain itu acara pengenalan karyawan baru, pemberian best employee reward, dan diskusi tentang strategi perusahaan.

Town Hall Meeting Q3 2025 membahas pencapaian perusahaan dalam kuartal ketiga dan rencana strategis untuk kuartal terakhir tahun ini. CEO menyampaikan bahwa perusahaan telah mencapai 85% dari target penjualan tahunan dan berencana untuk memperluas pasar ke negara-negara ASEAN.

Acara ini juga menjadi momen untuk mengenalkan 25 karyawan baru yang bergabung dalam 3 bulan terakhir. Setiap karyawan baru diberikan kesempatan untuk memperkenalkan diri dan berbagi pengalaman mereka sebelum bergabung dengan HLI Green Power.

Best Employee Award diberikan kepada 5 karyawan yang telah menunjukkan performa luar biasa dalam kuartal ini. Penghargaan ini diberikan berdasarkan penilaian dari berbagai aspek seperti inovasi, teamwork, dan kontribusi terhadap pencapaian target perusahaan.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-08-25'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Town Hall Meeting Q3 2025 - Company Strategy and Employee Recognition',
                'meta_description' => 'HLI Green Power holds quarterly town hall meeting with CEO and C-Level executives, featuring new employee introduction and awards.',
                'meta_keywords' => 'town hall meeting, CEO, employee recognition, company strategy',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Ramadhan 2025',
                'text' => 'Aktivitas buka puasa bersama pada bulan Ramadhan tahun 2025. Acara ini diikuti oleh karyawan baik karyawan Indonesia maupun Korea, dalam membangun kebersamaan dalam keberagaman. Selain itu perusahaan juga memberikan parcel lebaran kepada semua karyawan.

Acara buka puasa bersama diadakan setiap Jumat selama bulan Ramadhan di kantor pusat HLI Green Power. Acara ini menjadi momen untuk mempererat hubungan antar karyawan dari berbagai latar belakang budaya dan agama.

Menu yang disajikan merupakan perpaduan antara makanan khas Indonesia dan Korea, mencerminkan keragaman budaya yang ada di perusahaan. Acara ini juga diisi dengan berbagai kegiatan seperti sharing session tentang makna Ramadhan dan pentingnya toleransi dalam lingkungan kerja.

Sebagai bentuk apresiasi kepada karyawan Muslim, perusahaan memberikan parcel lebaran yang berisi berbagai kebutuhan pokok dan makanan khas lebaran. Parcel ini diberikan kepada semua karyawan sebagai bentuk kepedulian perusahaan terhadap kesejahteraan karyawan.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-08-23'),
                'status' => 'published',
                'featured' => false,
                'meta_title' => 'Ramadhan 2025 - Breaking Fast Together in Diversity',
                'meta_description' => 'HLI Green Power celebrates Ramadhan with employees from Indonesia and Korea, promoting cultural diversity and tolerance.',
                'meta_keywords' => 'Ramadhan, breaking fast, cultural diversity, tolerance, employee welfare',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Family Gathering',
                'text' => 'Family Gathering pertama PT HLI Green Power pada tanggal 26 April 2025. Family Gathering ini dilaksanakan di Trans Studio Bandung dengan tema "Grow with HLI". Acara ini diikuti lebih dari 1,000 orang termasuk karyawan dan keluarga mereka.

Acara Family Gathering menjadi momen spesial untuk memperkenalkan keluarga karyawan dengan lingkungan kerja dan budaya perusahaan. Acara ini dirancang untuk memberikan pengalaman yang menyenangkan bagi seluruh keluarga.

Berbagai aktivitas menarik disediakan untuk semua usia, mulai dari permainan anak-anak, wahana hiburan, hingga pertunjukan seni dan budaya. Acara ini juga menampilkan berbagai kuliner khas Indonesia dan Korea yang dapat dinikmati oleh seluruh keluarga.

Selain hiburan, acara ini juga menjadi kesempatan untuk memberikan apresiasi kepada keluarga karyawan yang telah mendukung perjalanan karier mereka di HLI Green Power. Beberapa keluarga diberikan penghargaan khusus atas kontribusi mereka dalam mendukung karyawan.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-08-23'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Family Gathering 2025 - Grow with HLI',
                'meta_description' => 'HLI Green Power holds first family gathering with theme "Grow with HLI" at Trans Studio Bandung.',
                'meta_keywords' => 'family gathering, employee family, company culture, Trans Studio Bandung',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Grand Opening Sport Center',
                'text' => 'Grand Opening Sport Center on 28 May 2025. HLI Green Power mempunyai facility baru untuk karyawan yang ingin melakukan aktifitas olahraga, di fasilitas baru ini terdapat lapangan futsal, gym, dan area yoga.

Sport Center HLI Green Power dibangun dengan standar internasional dan dilengkapi dengan berbagai fasilitas olahraga modern. Fasilitas ini mencakup lapangan futsal berstandar FIFA, gym dengan peralatan fitness terbaru, dan studio yoga yang nyaman.

Fasilitas ini dibuka untuk semua karyawan dan keluarga mereka dengan jadwal operasional yang fleksibel. Berbagai program olahraga dan fitness juga disediakan dengan instruktur profesional untuk membantu karyawan mencapai target kesehatan mereka.

Grand opening dihadiri oleh CEO dan seluruh jajaran direksi HLI Green Power. Acara ini juga menampilkan berbagai pertandingan persahabatan antara departemen dan demo berbagai olahraga yang dapat dilakukan di fasilitas ini.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-08-23'),
                'status' => 'published',
                'featured' => false,
                'meta_title' => 'Grand Opening Sport Center - Modern Sports Facility for Employees',
                'meta_description' => 'HLI Green Power opens new sport center with futsal field, gym, and yoga studio for employees.',
                'meta_keywords' => 'sport center, employee facility, futsal, gym, yoga, health and wellness',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
            [
                'title' => 'Company 3rd Anniversary',
                'text' => '3rd Anniversary HLI Green Power diadakan pada tanggal 19 Aug 2024. Di acara ini kami mengadakan games, pengumuman pemenang Best employee reward, penampilan seni dari karyawan, dan berbagai hiburan menarik.

Perayaan ulang tahun ke-3 HLI Green Power menjadi momen refleksi atas perjalanan perusahaan selama 3 tahun terakhir. Acara ini mengangkat tema "Growing Together, Achieving Excellence" yang mencerminkan komitmen perusahaan untuk terus berkembang bersama karyawan.

Berbagai games dan kompetisi menarik diadakan untuk semua karyawan, mulai dari kompetisi memasak, lomba foto, hingga pertandingan olahraga antar departemen. Acara ini juga menampilkan berbagai penampilan seni dari karyawan yang menunjukkan bakat dan kreativitas mereka.

Best Employee Award diberikan kepada 10 karyawan yang telah menunjukkan performa luar biasa sepanjang tahun. Penghargaan ini diberikan berdasarkan berbagai kriteria seperti inovasi, leadership, teamwork, dan kontribusi terhadap pencapaian target perusahaan.',
                'image' => null,
                'category' => 'life-at-hli',
                'published_date' => Carbon::parse('2025-08-23'),
                'status' => 'published',
                'featured' => true,
                'meta_title' => 'Company 3rd Anniversary - Growing Together, Achieving Excellence',
                'meta_description' => 'HLI Green Power celebrates 3rd anniversary with employee games, awards, and cultural performances.',
                'meta_keywords' => 'company anniversary, employee awards, cultural performance, company milestone',
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ],
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }
    }
}