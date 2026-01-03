<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FaqCategory;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // Categorie 1: Algemeen
        $algemeen = FaqCategory::create([
            'name' => 'Algemeen',
            'order' => 1,
        ]);

        Faq::create([
            'category_id' => $algemeen->id,
            'question' => 'Wat is deze website?',
            'answer' => 'Dit is een receptenwebsite waar je heerlijke recepten kunt vinden, delen en bewaren. Je kunt ook je eigen recepten toevoegen en met anderen delen.',
            'order' => 1,
        ]);

        Faq::create([
            'category_id' => $algemeen->id,
            'question' => 'Hoe maak ik een account aan?',
            'answer' => 'Klik op de "Registreer" knop rechtsboven. Vul je naam, gebruikersnaam, email, geboortedatum en wachtwoord in. Na registratie kun je direct inloggen.',
            'order' => 2,
        ]);

        Faq::create([
            'category_id' => $algemeen->id,
            'question' => 'Is de website gratis te gebruiken?',
            'answer' => 'Ja, onze website is volledig gratis te gebruiken. Je kunt recepten bekijken, opslaan en delen zonder kosten.',
            'order' => 3,
        ]);

        // Categorie 2: Account & Profiel
        $account = FaqCategory::create([
            'name' => 'Account & Profiel',
            'order' => 2,
        ]);

        Faq::create([
            'category_id' => $account->id,
            'question' => 'Hoe kan ik mijn profiel bewerken?',
            'answer' => 'Log in en klik op je naam rechtsboven. Kies "Profile" en vervolgens "Profiel Bewerken". Hier kun je je profielfoto, gebruikersnaam, naam, geboortedatum en "over mij" tekst aanpassen.',
            'order' => 1,
        ]);

        Faq::create([
            'category_id' => $account->id,
            'question' => 'Kan ik mijn gebruikersnaam wijzigen?',
            'answer' => 'Ja, ga naar je profiel bewerken pagina en pas je gebruikersnaam aan. Let op: je gebruikersnaam moet uniek zijn.',
            'order' => 2,
        ]);

        Faq::create([
            'category_id' => $account->id,
            'question' => 'Hoe upload ik een profielfoto?',
            'answer' => 'Ga naar "Profiel Bewerken" en klik op het bestandsveld onder "Profielfoto". Selecteer een afbeelding van je computer (max 1MB) en klik op "Opslaan".',
            'order' => 3,
        ]);

        Faq::create([
            'category_id' => $account->id,
            'question' => 'Wat als ik mijn wachtwoord vergeten ben?',
            'answer' => 'Klik op de "Log in" knop en vervolgens op "Forgot your password?". Vul je email adres in en je ontvangt instructies om je wachtwoord te resetten.',
            'order' => 4,
        ]);

        // Categorie 3: Nieuws
        $nieuws = FaqCategory::create([
            'name' => 'Nieuws',
            'order' => 3,
        ]);

        Faq::create([
            'category_id' => $nieuws->id,
            'question' => 'Hoe vaak wordt er nieuws geplaatst?',
            'answer' => 'We plaatsen regelmatig nieuws over nieuwe recepten, kooktips, seizoensgebonden ingrediënten en andere interessante onderwerpen. Bekijk de nieuwspagina voor de laatste updates.',
            'order' => 1,
        ]);

        Faq::create([
            'category_id' => $nieuws->id,
            'question' => 'Kan ik zelf nieuwsartikelen plaatsen?',
            'answer' => 'Alleen administrators kunnen nieuwsartikelen plaatsen. Als je een interessant verhaal hebt, neem dan contact op via de contactpagina.',
            'order' => 2,
        ]);

        // Categorie 4: Technische Vragen
        $technisch = FaqCategory::create([
            'name' => 'Technische Vragen',
            'order' => 4,
        ]);

        Faq::create([
            'category_id' => $technisch->id,
            'question' => 'Welke browsers worden ondersteund?',
            'answer' => 'Onze website werkt het beste in moderne browsers zoals Chrome, Firefox, Safari en Edge. We raden aan om altijd de nieuwste versie te gebruiken.',
            'order' => 1,
        ]);

        Faq::create([
            'category_id' => $technisch->id,
            'question' => 'Is de website ook mobiel te gebruiken?',
            'answer' => 'Ja, onze website is volledig responsive en werkt uitstekend op smartphones en tablets.',
            'order' => 2,
        ]);

        Faq::create([
            'category_id' => $technisch->id,
            'question' => 'Ik kan niet inloggen, wat nu?',
            'answer' => 'Controleer of je het juiste email adres en wachtwoord gebruikt. Probeer je wachtwoord te resetten via "Forgot your password?". Als het probleem aanhoudt, neem contact op met de administrator.',
            'order' => 3,
        ]);
    }
}
