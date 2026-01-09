# Receptenweb (Laravel 12)
Dit project is gemaakt voor het vak Backend Web (EhB). Het is een data-driven receptenwebsite met authenticatie, profielen, community posts, nieuws met nested comments, FAQ en een contactformulier, plus een admin paneel.

## Functionaliteiten

### Login Systeem
- Registreren / Inloggen / Uitloggen
- Remember Me
- Wachtwoord Vergeten

### Gebruikers en Admin
- Een gebruiker is een normale gebruiker of een admin
- Alleen admins kunnen andere gebruikers promoveren of degraderen
- Alleen admins kunnen handmatig een gebruiker aanmaken (en kiezen of die admin wordt)
- Standaard admin (ID 1) is beschermd en kan niet verwijderd worden

### Profielpagina
- Elke gebruiker heeft een publieke profielpagina zichtbaar voor iedereen
- Ingelogde gebruikers kunnen hun eigen profiel bewerken
- Profiel velden: Username, Geboortedatum, Profielfoto (opgeslagen op server), Over Mij tekst
- **Profiel Muur**: Gebruikers kunnen berichten achterlaten op elkaars profielen

### Community Posts
- Gebruikers kunnen posts maken met tekst en optionele afbeelding
- Zichtbaar voor iedereen
- Admins kunnen posts verwijderen met reden (gebruiker krijgt email)

### Nieuws
- Bezoekers kunnen nieuwsitems bekijken (overzicht + detail)
- Admins kunnen nieuws aanmaken, bewerken en verwijderen
- **Nested Comments**: Facebook-stijl comment systeem met replies
- Nieuws velden: Titel, Afbeelding, Inhoud, Publicatiedatum
- Relaties: One-to-many: Gebruiker → Nieuwsitems

### FAQ
- Bezoekers kunnen de FAQ pagina bekijken per categorie
- Admins kunnen categorieën en vragen/antwoorden aanmaken, bewerken en verwijderen

### Contact
- Bezoekers kunnen het contactformulier invullen
- Het bericht wordt opgeslagen in de database
- Admin kan alle contactberichten bekijken in admin paneel
- Admin kan berichten beantwoorden via email

### Dashboard
- Reguliere gebruikers: Feed met laatste nieuws en posts
- Admins: Statistieken (gebruikers, nieuws, posts, FAQ's, contactberichten)

## Standaard Admin Account
- **Naam**: admin
- **Email**: admin@ehb.be
- **Wachtwoord**: Password!321

## Installatie

### Vereisten
- PHP 8.2+
- Composer
- Node + NPM
- Database (SQLite standaard)

### Installatie Stappen

**1. Clone de repository**
```bash
git clone <repository-url>
cd laravelProject
```

**2. Installeer PHP dependencies**
```bash
composer install
```

**3. Maak .env en genereer app key**

Windows:
```bash
copy .env.example .env
php artisan key:generate
```

macOS / Linux:
```bash
cp .env.example .env
php artisan key:generate
```

**4. Maak database aan (SQLite)**

Windows:
```powershell
New-Item database/database.sqlite
```

macOS / Linux:
```bash
touch database/database.sqlite
```

**5. Voer migraties en seeder uit**
```bash
php artisan migrate:fresh --seed
```

**6. Maak storage link (Profielfoto's, Nieuws Afbeeldingen, Post Afbeeldingen)**
```bash
php artisan storage:link
```

**7. Installeer frontend dependencies en build**
```bash
npm install
npm run build
```

**8. Start de server**
```bash
php artisan serve
```

Open de website: `http://127.0.0.1:8000`

Of met Laravel Herd: `http://laravelproject.test`

## Mail Configuratie
Voor development:
```env
MAIL_MAILER=log
```
Email inhoud wordt geschreven naar: `storage/logs/laravel.log`

## Database Relaties
- **One-to-One**: User ↔ Profile
- **One-to-Many**: User → Posts, User → NewsComments, News → NewsComments, FaqCategory → Faqs
- **Self-referencing**: NewsComment → NewsComment (nested replies)

## Technische Stack
- Laravel 12
- Laravel Breeze (Authenticatie)
- SQLite (standaard)
- Blade Templates
- Tailwind CSS 3
- Vite 5
- Alpine.js

## Beveiliging
- CSRF bescherming op alle formulieren
- XSS preventie via Blade templating
- SQL injection preventie met Eloquent ORM
- Wachtwoord hashing met Bcrypt
- Rate limiting op login (max 5 pogingen)
- Admin middleware voor beschermde routes

## Belangrijke Opmerkingen
- Het project ondersteunt `php artisan migrate:fresh --seed`
- `vendor` en `node_modules` staan in `.gitignore`
- Afbeeldingen worden opgeslagen op public disk (`storage/app/public`)
- Voer `php artisan storage:link` uit om uploads toegankelijk te maken

## Bronvermeldingen
- **Laravel 12**: https://laravel.com
- **Laravel Breeze**: https://laravel.com/docs/12.x/starter-kits#breeze
- **Tailwind CSS**: https://tailwindcss.com
- **Vite**: https://vitejs.dev
- **Alpine.js**: https://alpinejs.dev
- **PHP Documentatie**: https://www.php.net/docs.php

---
**Backend Web - EhB** | Laravel 12 | Januari 2026
