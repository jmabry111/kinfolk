<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kinfolk — family &amp; friends</title>
    <link rel="icon" type="image/svg+xml" href="/images/kinfolk-logo-square.svg">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-cream-100 text-slate-800">

    {{-- Navigation --}}
    <nav class="bg-slate-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <img src="/images/kinfolk-logo-light.svg" alt="Kinfolk" class="h-10 w-auto">
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-700 hover:text-white transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 rounded-lg text-sm font-medium text-slate-200 hover:bg-slate-700 hover:text-white transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}"
                           class="px-4 py-2 rounded-lg text-sm font-bold bg-sage-500 hover:bg-sage-600 text-white transition-colors">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <section class="relative bg-slate-800 overflow-hidden">
        {{-- Decorative background pattern --}}
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <pattern id="hearts" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M30,45 C30,45 15,35 15,26 C15,20 19,17 23,19.5 C25.5,21 28,24 30,26 C32,24 34.5,21 37,19.5 C41,17 45,20 45,26 C45,35 30,45 30,45Z" fill="white"/>
                </pattern>
                <rect width="100%" height="100%" fill="url(#hearts)"/>
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 md:py-36 text-center">
            <p class="text-sage-400 font-serif italic text-lg mb-4 tracking-wide">never forget a birthday again</p>
            <h1 class="font-serif text-5xl md:text-7xl font-bold text-white leading-tight mb-6">
                Stay close to the ones<br class="hidden md:block"> you love most
            </h1>
            <p class="text-slate-200 text-xl md:text-2xl max-w-2xl mx-auto mb-10 leading-relaxed">
                Kinfolk helps you keep up with birthdays, coordinate gifts, and show up for your family and friends — with a little southern hospitality.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                   class="px-8 py-4 bg-sage-500 hover:bg-sage-600 text-white font-bold text-lg rounded-xl shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5">
                    Get Started — It's Free
                </a>
                <a href="{{ route('login') }}"
                   class="px-8 py-4 bg-slate-700 hover:bg-slate-600 text-white font-medium text-lg rounded-xl transition-colors">
                    Sign In
                </a>
            </div>
        </div>

        {{-- Wave divider --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg viewBox="0 0 1440 80" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0,40 C360,80 1080,0 1440,40 L1440,80 L0,80 Z" fill="#faf7f4"/>
            </svg>
        </div>
    </section>

    {{-- Features --}}
    <section class="py-20 bg-cream-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="font-serif text-4xl font-bold text-slate-800 mb-4">Everything you need to stay connected</h2>
                <p class="text-slate-500 text-lg max-w-xl mx-auto">From birthdays to gift coordination, Kinfolk keeps your whole circle organized.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Feature 1 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Birthday Dashboard</h3>
                    <p class="text-slate-500 leading-relaxed">See everyone's upcoming birthdays at a glance, color-coded by urgency. Never be caught off guard again.</p>
                </div>

                {{-- Feature 2 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Gift Coordination</h3>
                    <p class="text-slate-500 leading-relaxed">Build gift lists, mark ideas as public or private, and let family members see what's already covered — without spoiling the surprise.</p>
                </div>

                {{-- Feature 3 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Family Groups</h3>
                    <p class="text-slate-500 leading-relaxed">Create shared groups and invite family members. Everyone sees the same contacts and can coordinate gifts together.</p>
                </div>

                {{-- Feature 4 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Email Reminders</h3>
                    <p class="text-slate-500 leading-relaxed">Get notified 30 and 7 days before a birthday so you always have plenty of time to find the perfect gift.</p>
                </div>

                {{-- Feature 5 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Kin &amp; Folk</h3>
                    <p class="text-slate-500 leading-relaxed">Classify your people as Kin (family) or Folk (friends &amp; others) for a personal touch that reflects how you think about your circle.</p>
                </div>

                {{-- Feature 6 --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-cream-300 hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 bg-sage-100 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6 text-sage-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <h3 class="font-serif text-xl font-bold text-slate-800 mb-2">Private by Default</h3>
                    <p class="text-slate-500 leading-relaxed">Keep gift ideas private or share them with your group. You're always in control of what others can see.</p>
                </div>

            </div>
        </div>
    </section>

    {{-- Kin & Folk callout --}}
    <section class="py-20 bg-slate-800 relative overflow-hidden">
        <div class="absolute inset-0 opacity-5">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <pattern id="hearts2" x="0" y="0" width="60" height="60" patternUnits="userSpaceOnUse">
                    <path d="M30,45 C30,45 15,35 15,26 C15,20 19,17 23,19.5 C25.5,21 28,24 30,26 C32,24 34.5,21 37,19.5 C41,17 45,20 45,26 C45,35 30,45 30,45Z" fill="white"/>
                </pattern>
                <rect width="100%" height="100%" fill="url(#hearts2)"/>
            </svg>
        </div>
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="font-serif text-4xl md:text-5xl font-bold text-white mb-6">
                Built for the way <span class="text-sage-400 italic">real</span> families work
            </h2>
            <p class="text-slate-200 text-xl leading-relaxed mb-10">
                Whether you're coordinating Christmas gifts for a big family or just making sure you don't forget your best friend's birthday, Kinfolk keeps everyone on the same page — without spoiling any surprises.
            </p>
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <div class="bg-slate-700 rounded-2xl px-8 py-6 text-center">
                    <span class="block text-4xl font-bold text-sage-400 font-serif mb-1">Kin</span>
                    <span class="text-slate-300 text-sm">Your family members</span>
                </div>
                <div class="flex items-center justify-center text-slate-400 font-serif italic text-2xl">&amp;</div>
                <div class="bg-slate-700 rounded-2xl px-8 py-6 text-center">
                    <span class="block text-4xl font-bold text-sage-400 font-serif mb-1">Folk</span>
                    <span class="text-slate-300 text-sm">Your friends &amp; others</span>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 bg-cream-100">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <img src="/images/kinfolk-logo-square-color.svg" alt="Kinfolk" class="w-20 h-20 mx-auto mb-8">
            <h2 class="font-serif text-4xl font-bold text-slate-800 mb-4">Ready to pull up a chair?</h2>
            <p class="text-slate-500 text-xl mb-10">Join Kinfolk and start showing up for the people you love.</p>
            <a href="{{ route('register') }}"
               class="inline-block px-10 py-4 bg-sage-500 hover:bg-sage-600 text-white font-bold text-lg rounded-xl shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5">
                Create Your Free Account
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-800 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row justify-between items-center gap-4">
            <img src="images/kinfolk-logo-light.svg" alt="Kinfolk" class="h-8 w-auto">
            <p class="text-slate-400 text-sm">Made with ♥ for family &amp; friends</p>
        </div>
    </footer>

</body>
</html>
