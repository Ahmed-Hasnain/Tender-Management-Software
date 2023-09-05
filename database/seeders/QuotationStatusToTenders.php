<?php

namespace Database\Seeders;

use App\Models\Tender;
use Illuminate\Database\Seeder;

class QuotationStatusToTenders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tenders = Tender::all();
        $tenders->each(function ($tender) {
            if ($tender->quotation) {
                $tender->status = $tender->quotation->status;
                $tender->saveQuietly();
            }
        });
    }
}
