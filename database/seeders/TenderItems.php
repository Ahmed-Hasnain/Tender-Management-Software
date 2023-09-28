<?php

namespace Database\Seeders;

use App\Models\Tender;
use Illuminate\Database\Seeder;

class TenderItems extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tender = Tender::latest()->first();
        for ($i=0; $i < 100; $i++) { 
            $tender->items()->create([
                'item_id' => 10,
                'unit_id' => 17,
                'qty' => $i,
                'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique, consequuntur eveniet. Similique dolor placeat nihil quia aperiam illum velit sequi mollitia neque. Quis adipisci, ut vero iusto beatae reprehenderit debitis.',
            ]);
        }
    }
}
