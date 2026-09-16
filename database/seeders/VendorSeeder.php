<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendors = [
            [
                'code' => 'VND-001',
                'name' => 'PT Belden Kabelindo Nusantara',
                'contact_person' => 'Hendrawan Pratama',
                'phone' => '021-89831234',
                'email' => 'sales@belden-kabelindo.co.id',
                'address' => 'Kawasan Industri MM2100, Jl. Irian Blok EE-1, Cikarang Barat, Bekasi',
                'tax_id' => '01.345.678.9-413.000',
                'bank_name' => 'BCA',
                'bank_account_number' => '7110982341',
                'bank_account_holder' => 'PT Belden Kabelindo Nusantara',
                'is_active' => true,
            ],
            [
                'code' => 'VND-002',
                'name' => 'CV PaperOne Mitra Mandiri',
                'contact_person' => 'Siti Nurhaliza',
                'phone' => '021-56984421',
                'email' => 'order@paperonemitra.com',
                'address' => 'Jl. Daan Mogot KM 12 No. 88, Cengkareng, Jakarta Barat',
                'tax_id' => '02.112.443.5-035.000',
                'bank_name' => 'Bank Mandiri',
                'bank_account_number' => '1180029384756',
                'bank_account_holder' => 'CV PaperOne Mitra Mandiri',
                'is_active' => true,
            ],
            [
                'code' => 'VND-003',
                'name' => 'PT Dell Solusindo Pratama',
                'contact_person' => 'Bambang Kusuma',
                'phone' => '021-29956700',
                'email' => 'commercial@dellsolusindo.co.id',
                'address' => 'Menara Astra Lt. 28, Jl. Jend. Sudirman Kav. 5-6, Jakarta Pusat',
                'tax_id' => '01.998.776.4-021.000',
                'bank_name' => 'BCA',
                'bank_account_number' => '0089452311',
                'bank_account_holder' => 'PT Dell Solusindo Pratama',
                'is_active' => true,
            ],
            [
                'code' => 'VND-004',
                'name' => 'CV Logi Pratama Periferal',
                'contact_person' => 'Rahmat Hidayat',
                'phone' => '0812-9876-5432',
                'email' => 'sales@logipratama.id',
                'address' => 'Harco Mangga Dua Blok B Lt. 3 No. 45, Jakarta Pusat',
                'tax_id' => '03.778.990.1-014.000',
                'bank_name' => 'BNI',
                'bank_account_number' => '0239485721',
                'bank_account_holder' => 'CV Logi Pratama Periferal',
                'is_active' => true,
            ],
            [
                'code' => 'VND-005',
                'name' => 'PT Surya Tonerindo Utama',
                'contact_person' => 'Devi Anggraini',
                'phone' => '021-65309988',
                'email' => 'devi@suryatoner.co.id',
                'address' => 'Komplek Ruko Roxy Mas Blok D3 No. 12, Jakarta Barat',
                'tax_id' => '01.445.889.3-031.000',
                'bank_name' => 'BRI',
                'bank_account_number' => '034101002345501',
                'bank_account_holder' => 'PT Surya Tonerindo Utama',
                'is_active' => true,
            ],
            [
                'code' => 'VND-006',
                'name' => 'CV Mega Elektrik Sarana',
                'contact_person' => 'Irfan Hakim',
                'phone' => '021-88451290',
                'email' => 'irfan@megaelektrik.com',
                'address' => 'Jl. Raya Bekasi KM 24, Cakung, Jakarta Timur',
                'tax_id' => '02.889.123.4-008.000',
                'bank_name' => 'BCA',
                'bank_account_number' => '5420199482',
                'bank_account_holder' => 'CV Mega Elektrik Sarana',
                'is_active' => false,
            ],
        ];

        foreach ($vendors as $vendorData) {
            Vendor::firstOrCreate(['code' => $vendorData['code']], $vendorData);
        }
    }
}
