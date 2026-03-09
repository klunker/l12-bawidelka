<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Home',
                'content' => 'Home page content',
            ],
            [
                'slug' => 'privacy-policy',
                'title' => 'Polityka Prywatności',
                'content' => '<h2>1. Informacje ogólne</h2>
                    <p>Niniejsza polityka prywatności określa zasady przetwarzania i ochrony danych osobowych zbieranych w ramach serwisu Bawidełka.</p>
                    
                    <h2>2. Administrator danych</h2>
                    <p>Administratorem Pani/Pana danych osobowych jest:</p>
                    <ul>
                        <li>Nazwa firmy: Bawidełka</li>
                        <li>Adres: [adres siedziby]</li>
                        <li>NIP: [numer NIP]</li>
                        <li>REGON: [numer REGON]</li>
                        <li>E-mail: [adres e-mail]</li>
                        <li>Telefon: [numer telefonu]</li>
                    </ul>
                    
                    <h2>3. Cel i zakres zbierania danych</h2>
                    <p>Przetwarzamy Pani/Pana dane osobowe w następujących celach:</p>
                    <ul>
                        <li>Realizacji ofert opieki nad dziećmi</li>
                        <li>Komunikacji z klientami</li>
                        <li>Rozliczeń finansowych</li>
                        <li>Marketingu własnych ofert</li>
                    </ul>
                    
                    <h2>4. Podstawa prawna przetwarzania</h2>
                    <p>Podstawą prawną przetwarzania danych jest:</p>
                    <ul>
                        <li>Realizacja umowy (art. 6 ust. 1 lit. b RODO)</li>
                        <li>Obowiązek prawny (art. 6 ust. 1 lit. c RODO)</li>
                        <li>Prawnie uzasadniony interes (art. 6 ust. 1 lit. f RODO)</li>
                    </ul>
                    
                    <h2>5. Okres przechowywania danych</h2>
                    <p>Dane osobowe będą przechowywane przez okres niezbędny do realizacji celów, dla których zostały zebrane.</p>
                    
                    <h2>6. Prawa osób</h2>
                    <p>Przysługują Pani/Panu następujące prawa:</p>
                    <ul>
                        <li>Dostępu do danych</li>
                        <li>Sprostowania danych</li>
                        <li>Usunięcia danych</li>
                        <li>Ograniczenia przetwarzania</li>
                        <li>Przenoszenia danych</li>
                        <li>Wniesienia sprzeciwu</li>
                    </ul>
                    
                    <h2>7. Kontakt</h2>
                    <p>W sprawach związanych z ochroną danych osobowych prosimy o kontakt pod adresem e-mail: [adres e-mail]</p>',
            ],
            [
                'slug' => 'standardy-ochrony-małoletnich',
                'title' => 'Standardy ochrony małoletnich',
                'content' => '<h2>1. Misja i wartości</h2>
                    <p>W Bawidełce priorytetem jest bezpieczeństwo i dobrostan każdego dziecka. Nasze standardy ochrony małoletnich opierają się na zasadach profesjonalizmu, empatii i pełnego zaangażowania.</p>
                    
                    <h2>2. Kwalifikacje personelu</h2>
                    <p>Wszyscy nasi opiekunowie posiadają:</p>
                    <ul>
                        <li>Wymagane kwalifikacje pedagogiczne</li>
                        <li>Ukończone szkolenia z pierwszej pomocy</li>
                        <li>Zaświadczenia o niekaralności</li>
                        <li>Regularne szkolenia z ochrony małoletnich</li>
                    </ul>
                    
                    <h2>3. Zasady bezpieczeństwa</h2>
                    <h3>3.1 Nadzór</h3>
                    <p>Każde dziecko jest pod stałą opieką wykwalifikowanego personelu. Stosujemy zasadę odpowiedniej liczby opiekunów do liczby dzieci.</p>
                    
                    <h3>3.2 Bezpieczeństwo fizyczne</h3>
                    <ul>
                        <li>Regularne kontrole stanu zabawek i sprzętu</li>
                        <li>Bezpieczne zabezpieczenie pomieszczeń</li>
                        <li>Procedury ewakuacyjne</li>
                        <li>Monitorowanie stanu zdrowia dzieci</li>
                    </ul>
                    
                    <h3>3.3 Bezpieczeństwo emocjonalne</h3>
                    <ul>
                        <li>Stworzenie atmosfery akceptacji i zaufania</li>
                        <li>Indywidualne podejście do każdego dziecka</li>
                        <li>Rozwiązywanie konfliktów w sposób konstruktywny</li>
                        <li>Budowanie pozytywnych relacji</li>
                    </ul>
                    
                    <h2>4. Postępowanie w sytuacjach kryzysowych</h2>
                    <p>Mamy opracowane procedury postępowania w przypadku:</p>
                    <ul>
                        <li>Wypadków i urazów</li>
                        <li>Nagłych zachorowań</li>
                        <li>Sytuacji stresogennych</li>
                        <li>Zagrożeń zewnętrznych</li>
                    </ul>
                    
                    <h2>5. Współpraca z rodzicami</h2>
                    <p>Utrzymujemy stały kontakt z rodzicami poprzez:</p>
                    <ul>
                        <li>Regularne spotkania</li>
                        <li>Komunikację bieżącą</li>
                        <li>Konsultacje pedagogiczne</li>
                        <li>Warsztaty dla rodziców</li>
                    </ul>
                    
                    <h2>6. Zgłaszanie niepokojących sytuacji</h2>
                    <p>Wszelkie niepokojące sytuacje należy zgłaszać bezpośrednio do kierownictwa placówki. Zapewniamy pełną poufność i profesjonalne podejście do każdego zgłoszenia.</p>',
            ],
            [
                'slug' => 'regulamin',
                'title' => 'Regulamin',
                'content' => '<h2>§1. Postanowienia ogólne</h2>
                    <p>1. Niniejszy regulamin określa zasady świadczenia ofert opieki nad dziećmi przez placówkę Bawidełka.</p>
                    <p>2. Regulamin obowiązuje wszystkich klientów korzystających z ofert placówki.</p>
                    
                    <h2>§2. Zakres ofert</h2>
                    <p>1. Placówka świadczy oferty opieki nad dziećmi w wieku od [wiek minimalny] do [wiek maksymalny] lat.</p>
                    <p>2. Oferty świadczone są w godzinach od [godzina rozpoczęcia] do [godzina zakończenia].</p>
                    <p>3. Placówka zapewnia:</p>
                    <ul>
                        <li>Opiekę wykwalifikowanego personelu</li>
                        <li>Zajęcia edukacyjne i wychowawcze</li>
                        <li>Pożywienie zgodne z normami żywieniowymi</li>
                        <li>Bezpieczne warunki pobytu</li>
                    </ul>
                    
                    <h2>§3. Zasady zapisów</h2>
                    <p>1. Zapis dziecka na zajęcia następuje po wypełnieniu formularza zgłoszeniowego.</p>
                    <p>2. Do formularza należy dołączyć:</p>
                    <ul>
                        <li>Kwestionariusz zdrowia dziecka</li>
                        <li>Oświadczenie o stanie zdrowia</li>
                        <li>Zgodę na przetwarzanie danych osobowych</li>
                    </ul>
                    
                    <h2>§4. Obowiązki rodziców</h2>
                    <p>Rodzice/opiekunowie prawni zobowiązani są do:</p>
                    <ul>
                        <li>Przyprowadzania i odbierania dziecka osobiście lub przez upoważnioną osobę</li>
                        <li>Informowania o nieobecności dziecka z co najmniej 24-godzinnym wyprzedzeniem</li>
                        <li>Szacownego terminowego uiszczania opłat za oferty</li>
                        <li>Informowania o zmianach w stanie zdrowia dziecka</li>
                    </ul>
                    
                    <h2>§5. Opłaty</h2>
                    <p>1. Opłaty za oferty świadczone są miesięcznie z góry.</p>
                    <p>2. Wysokość opłat określa cennik dostępny w placówce.</p>
                    <p>3. Nieobecność dziecka nie zwalnia z obowiązku uiszczenia opłaty.</p>
                    
                    <h2>§6. Postanowienia końcowe</h2>
                    <p>1. W sprawach nieuregulowanych niniejszym regulaminem stosuje się przepisy powszechnie obowiązującego prawa.</p>
                    <p>2. Regulamin wchodzi w życie z dniem [data].</p>',
            ],
            [
                'slug' => 'rodo',
                'title' => 'RODO',
                'content' => '<h2>Informacja o przetwarzaniu danych osobowych</h2>
                    <p>Zgodnie z art. 13 Rozporządzenia Parlamentu Europejskiego i Rady (UE) 2016/679 z dnia 27 kwietnia 2016 r. w sprawie ochrony osób fizycznych w związku z przetwarzaniem danych osobowych (RODO), informujemy o zasadach przetwarzania Pani/Pana danych osobowych.</p>
                    
                    <h3>1. Administrator danych</h3>
                    <p>Administratorem Pani/Pana danych osobowych jest Bawidełka z siedzibą w [miejscowość], [adres].</p>
                    
                    <h3>2. Inspektor ochrony danych</h3>
                    <p>Wyznaczyliśmy Inspektora Ochrony Danych, z którym można się skontaktować pod adresem e-mail: [iod@bawidelka.pl]</p>
                    
                    <h3>3. Cele i podstawy przetwarzania</h3>
                    <p>Pani/Pana dane osobowe będą przetwarzane:</p>
                    <ul>
                        <li>W celu realizacji umowy o świadczenie ofert opieki nad dziećmi - podstawa: art. 6 ust. 1 lit. b RODO</li>
                        <li>W celu wypełnienia obowiązku prawnego ciążącego na administratorze - podstawa: art. 6 ust. 1 lit. c RODO</li>
                        <li>W celach marketingowych - podstawa: art. 6 ust. 1 lit. a RODO (zgoda)</li>
                    </ul>
                    
                    <h3>4. Odbiorcy danych</h3>
                    <p>Pani/Pana dane mogą być udostępniane:</p>
                    <ul>
                        <li>Podmiotom medycznym w sytuacjach awaryjnych</li>
                        <li>Organów ścigania w przypadku naruszeń prawa</li>
                        <li>Podmiotom przetwarzającym dane na zlecenie administratora</li>
                    </ul>
                    
                    <h3>5. Okres przechowywania danych</h3>
                    <p>Dane osobowe będą przechowywane:</p>
                    <ul>
                        <li>Dla celów realizacji umowy - przez okres trwania umowy</li>
                        <li>Dla celów archiwizacyjnych - przez okres wymagany przepisami prawa</li>
                    </ul>
                    
                    <h3>6. Prawa osób, których dane dotyczą</h3>
                    <p>Przysługują Pani/Panu następujące prawa:</p>
                    <ul>
                        <li>Prawo dostępu do danych</li>
                        <li>Prawo sprostowania danych</li>
                        <li>Prawo usunięcia danych</li>
                        <li>Prawo ograniczenia przetwarzania</li>
                        <li>Prawo przenoszenia danych</li>
                        <li>Prawo wniesienia sprzeciwu</li>
                        <li>Prawo wniesienia skargi do organu nadzorczego</li>
                    </ul>
                    
                    <h3>7. Informacje o zautomatyzowanym podejmowaniu decyzji</h3>
                    <p>Administrator nie podejmuje decyzji w sposób zautomatyzowany.</p>
                    
                    <h3>8. Obowiązek podania danych</h3>
                    <p>Podanie danych osobowych jest dobrowolne, ale niezbędne do zawarcia i realizacji umowy.</p>',
            ],
            [
                'slug' => 'privacy-settings',
                'title' => 'Ustawienia prywatności',
                'content' => '<h2>Zarządzanie swoimi danymi osobowymi</h2>
                    <p>W Bawidełce dajemy Ci pełną kontrolę nad Twoimi danymi osobowymi. Poniżej znajdziesz informacje o tym, jak możesz zarządzać swoją prywatnością.</p>
                    
                    <h2>Dostęp do danych</h2>
                    <p>Możesz w każdej chwili:</p>
                    <ul>
                        <li>Przeglądać swoje dane osobowe</li>
                        <li>Pobierać kopię swoich danych</li>
                        <li>Poprawiać nieprawidłowe informacje</li>
                        <li>Usunąć swoje konto i dane</li>
                    </ul>
                    
                    <h2>Zgody marketingowe</h2>
                    <p>Możesz zarządzać swoimi zgodami na:</p>
                    <ul>
                        <li>Przesyłanie informacji handlowych drogą elektroniczną</li>
                        <li>Przesyłanie informacji handlowych drogą telefoniczną</li>
                        <li>Przetwarzanie danych w celach marketingowych</li>
                    </ul>
                    
                    <h2>Ciasteczka (cookies)</h2>
                    <p>Nasza strona używa ciasteczek w celu:</p>
                    <ul>
                        <li>Zapewnienia prawidłowego działania serwisu</li>
                        <li>Analizy ruchu na stronie</li>
                        <li>Personalizacji treści</li>
                    </ul>
                    
                    <p>Możesz zarządzać ciasteczkami w ustawieniach przeglądarki.</p>
                    
                    <h2>Bezpieczeństwo danych</h2>
                    <p>Stosujemy następujące środki bezpieczeństwa:</p>
                    <ul>
                        <li>Szyfrowanie danych</li>
                        <li>Zabezpieczenia serwerowe</li>
                        <li>Kontrola dostępu</li>
                        <li>Regularne audyty bezpieczeństwa</li>
                    </ul>
                    
                    <h2>Kontakt w sprawach prywatności</h2>
                    <p>Jeśli masz pytania dotyczące prywatności lub chcesz skorzystać ze swoich praw, skontaktuj się z nami:</p>
                    <ul>
                        <li>E-mail: privacy@bawidelka.pl</li>
                        <li>Telefon: [numer telefonu]</li>
                        <li>Adres: [adres placówki]</li>
                    </ul>
                    
                    <h2>Zmiany w ustawieniach</h2>
                    <p>Aby zmienić swoje ustawienia prywatności:</p>
                    <ol>
                        <li>Zaloguj się na swoje konto</li>
                        <li>Wejdź w zakładkę "Ustawienia"</li>
                        <li>Wybierz "Prywatność"</li>
                        <li>Dokonaj zmian i zapisz</li>
                    </ol>',
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }
    }
}
