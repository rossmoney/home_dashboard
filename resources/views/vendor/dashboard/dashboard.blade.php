<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Dashboard</title>
        <meta name="google" value="notranslate">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

        {{ $assets }}

        @stack('assets')

        <link rel="stylesheet" href="{{ asset('css/wallboard.css') }}">
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
        <link rel="stylesheet" href="https://unpkg.com/tailwindcss@0.3.0/dist/tailwind.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">

        <script src="https://static.cryptowat.ch/assets/scripts/embed.bundle.js"></script>
    </head>
    <body class="leading-snug">
        <div
            x-data="theme('{{ $theme }}', '{{ $initialMode }}')"
            x-init="init"
            :class="mode === 'dark' ? 'dark-mode' : ''"
        >
            <div class="fixed inset-0 w-screen h-screen grid gap-2 p-2 bg-canvas text-default">
                <livewire:dashboard-update-mode />

                {{ $slot }}
            </div>
        </div>

        <script src="https://kit.fontawesome.com/25563b37c3.js" crossorigin="anonymous"></script>

        @stack('scripts')

        <script>
            const theme = (theme, initialMode) => ({
                theme,
                mode: initialMode,

                init() {
                    if (this.theme === 'device') {
                        this.detectDeviceColorScheme();

                        return;
                    }

                    if (this.theme === 'auto') {
                        this.listenForUpdateModeEvent();

                        return;
                    }
                },

                detectDeviceColorScheme() {
                    const mediaQuery = matchMedia("(prefers-color-scheme: dark)");

                    this.mode = mediaQuery.matches ? 'dark' : 'light';

                    mediaQuery.addListener((event) => {
                        this.mode = mediaQuery.matches ? 'dark' : 'light';
                    });
                },

                listenForUpdateModeEvent() {
                    window.livewire.on('updateMode', newMode => {
                        if (newMode !== this.mode) {
                            this.mode = newMode;
                        }
                    })
                },
            });
        </script>


    </body>
</html>
