# Kinfolk 🪑❤️

> *Never forget a birthday again.*

[Kinfolk](https://kinfolk-production.up.railway.app) is a warm, family-friendly web app that helps you stay connected with the people who matter most. Track birthdays, coordinate gift ideas, and show up for your family and friends — with a little southern hospitality.

---

## ✨ Features

- **Upcoming Birthdays Dashboard** — see everyone's birthdays at a glance, color-coded by urgency (30 / 60 / 90 days)
- **Kin & Folk Classification** — classify contacts as Kin (family) or Folk (friends & others)
- **Gift Ideas** — track gift ideas per person with public/private visibility and purchased state
- **Anonymous Purchase Tracking** — mark gifts as "covered" without revealing who bought them
- **Christmas List** — dedicated holiday gift list with print and PDF export
- **Family Groups** — create shared groups and invite members to coordinate together
- **Invite Links** — share single-use, expiring invite links with family and friends
- **Welcome Email** — new members receive a welcome email when they accept an invite
- **Email Reminders** — automated birthday reminders sent 30 and 7 days in advance
- **Holiday Awareness** — upcoming holidays displayed alongside birthdays
- **Profile Settings** — update your name, email, and password
- **Guided Walkthrough Tour** — interactive onboarding tour powered by Shepherd.js
- **Admin Interface** — administrative tools for managing the app
- **Responsive UI** — works on desktop and mobile

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Framework | [Laravel 12](https://laravel.com) |
| Frontend | Blade, Tailwind CSS, Alpine.js, Livewire |
| Database | MariaDB (local via Laravel Sail), MySQL (production) |
| Auth | Laravel Breeze |
| Mail | Mailpit (local), [Resend](https://resend.com) (production) |
| Dev Environment | Docker / Laravel Sail |

---

## 🚀 Getting Started

### Prerequisites

- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- PHP 8.2+ (for Composer)
- Node.js & npm

### Installation

**1. Clone the repo**
```bash
git clone https://github.com/jmabry111/kinfolk.git
cd kinfolk
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Copy the environment file**
```bash
cp .env.example .env
```

**4. Start Laravel Sail**
```bash
./vendor/bin/sail up -d
```

**5. Generate app key**
```bash
sail artisan key:generate
```

**6. Run migrations and seed**
```bash
sail artisan migrate --seed --seeder=SitcomSeeder
```

**7. Install and build frontend assets**
```bash
sail npm install
sail npm run build
```

**8. Visit the app**

Open [http://localhost](http://localhost) in your browser.

---

## 🎭 Seed Data

The `SitcomSeeder` populates the app with fun test data from five classic TV shows:

| Group | Show |
|---|---|
| The Simpsons | *The Simpsons* |
| The Bundy Family | *Married with Children* |
| Dunder Mifflin Scranton | *The Office* |
| The Pritchett-Dunphy-Tucker Clan | *Modern Family* |
| Cloud 9 Crew | *Superstore* |

**Test accounts:**
```
jason@example.com / password
pam@example.com   / password
```

---

## 📧 Email Reminders

Birthday reminders are sent via a scheduled Artisan command:

```bash
sail artisan kinfolk:send-birthday-reminders
```

This command sends a single email per user covering all contacts with birthdays exactly **7 or 30 days** from today. In production, the command runs daily at 6:00 AM via `routes/console.php`:

```php
Schedule::command('kinfolk:send-birthday-reminders')->dailyAt('6:00');
```

For local development, emails are caught by [Mailpit](http://localhost:8025).

---

## 📁 Project Structure

```
app/
├── Console/Commands/       # SendBirthdayReminders command
├── Http/Controllers/       # FamilyGroup, Contact, Gift, GroupInvite, Dashboard
├── Mail/                   # BirthdayReminder, WelcomeEmail mailables
├── Models/                 # User, FamilyGroup, Contact, Gift, GroupInvite
├── Services/               # HolidayService
database/
├── migrations/             # All database migrations
├── seeders/                # SitcomSeeder
resources/
├── views/
│   ├── layouts/            # app.blade.php, navigation.blade.php, guest.blade.php
│   ├── family-groups/      # index, create, show
│   ├── contacts/           # create, edit, show
│   ├── gifts/              # create, edit
│   ├── invites/            # created, invalid
│   ├── emails/             # birthday-reminder, welcome
│   ├── partials/           # birthday-card
│   └── welcome.blade.php   # Public landing page
public/images/              # Logo files, holiday images
routes/
├── web.php                 # All web routes
└── console.php             # Scheduled commands
```

---

## 🗄 Database Schema

```
users
family_groups        (owner_id → users)
family_group_user    (pivot: family_group_id, user_id, role)
contacts             (family_group_id, added_by → users)
gifts                (contact_id, user_id, purchased_by → users)
group_invites        (family_group_id, created_by → users, token, expires_at, used_at)
```

---

## 🎨 Brand

Kinfolk uses a custom color palette inspired by the logo:

| Name | Hex | Usage |
|---|---|---|
| Slate | `#2A333D` | Primary text, nav background |
| Sage | `#9FC8A9` | Accents, badges, highlights |
| Blue | `#3A629D` | Links, headings, secondary actions |
| Cream | `#FAF7F4` | Page backgrounds |

Fonts: **Playfair Display** (serif/display) + **Lato** (body)

---

## 📖 Documentation

- [**User Guide**](https://docs.google.com/document/d/1lD7Mm0oJDvbf_4BiOTGjdFVWRRAj9aXtbIJKpR92tGA/edit?usp=sharing) — full walkthrough of all features for end users

---

## 🗺 Roadmap

- [ ] Contact photo uploads
- [ ] Wishlist view — let contacts add their own gift wishes
- [ ] Push notifications
- [ ] Mobile app (React Native)

---

## 📄 License

This project is licensed under the [GPL-3.0 License](LICENSE).

---

<p align="center">Made with ♥ for family & friends</p>
