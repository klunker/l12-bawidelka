<?php

namespace Database\Seeders;

use App\Models\AboutContent;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = '<p>Jestem twórczynią marki Bawidełka.</p>
<p>Bawidełka powstały w 2021 roku w Opolu z potrzeby serca i ogromnej wiary w marzenia. Od samego początku to miejsce było realizacją mojej wizji – przestrzeni, w której dzieci mogą tworzyć, doświadczać i rozwijać swoją kreatywność w atmosferze radości i swobody.</p>
<p>Przez te lata zorganizowaliśmy mnóstwo warsztatów, kreatywnych urodzin, nocowanek oraz półkolonii. W naszej przestrzeni gościliśmy tysiące dzieci, które wspólnie z nami odkrywały świat wyobraźni, sztuki i twórczej zabawy.</p>
<p>Z czasem postanowiłam pójść o krok dalej i razem z przyjaciółką stworzyłam biuro podróży dla dzieci i młodzieży Vita Ventura, by realizować nasze założenia również poza Opolem – zabierając dzieci w inspirujące miejsca i nowe przygody.</p>
<p>Dziś otwieramy drugi punkt na mapie Polski. Do współtworzenia Bawidełek w Rydułtowach zaprosiłam moją siostrę bliźniaczkę. Razem chcemy rozwijać przestrzeń, w której dzieci czują się ważne, twórcze i po prostu szczęśliwe.</p>
<p>Bawidełka to nie tylko sala zajęć kreatywnych. To miejsce, które powstało z marzeń – i każdego dnia pomaga dzieciom spełniać ich własne.</p>
<p>Z uśmiechem, Anita Kołek</p>';

        AboutContent::create([
            'content' => $content,
            'isActive' => true,
        ]);

        $this->command->info('About content seeded successfully');
    }
}
