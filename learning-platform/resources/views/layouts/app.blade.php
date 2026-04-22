<!DOCTYPE html>
<html class="dark" dir="rtl" lang="ar">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Smart Learn')</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&family=Noto+Kufi+Arabic:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-background": "#e2e2e5",
                        "tertiary-container": "#d560e6",
                        "tertiary-fixed-dim": "#f9abff",
                        "on-tertiary": "#570066",
                        "surface-container-high": "#282a2c",
                        "on-primary": "#00228a",
                        "on-tertiary-container": "#4c0059",
                        "on-tertiary-fixed": "#35003f",
                        "on-surface-variant": "#c4c5d7",
                        "secondary": "#ffb778",
                        "primary-fixed": "#dde1ff",
                        "on-secondary-fixed-variant": "#6c3a00",
                        "error-container": "#93000a",
                        "on-primary-fixed-variant": "#0034c0",
                        "on-surface": "#e2e2e5",
                        "on-secondary": "#4c2700",
                        "on-error-container": "#ffdad6",
                        "outline-variant": "#444654",
                        "surface-variant": "#333537",
                        "on-primary-fixed": "#001257",
                        "inverse-surface": "#e2e2e5",
                        "outline": "#8e90a0",
                        "secondary-container": "#fd9000",
                        "surface-container-highest": "#333537",
                        "surface-bright": "#37393b",
                        "surface-container-low": "#1a1c1e",
                        "on-tertiary-fixed-variant": "#7b008f",
                        "surface-tint": "#b9c3ff",
                        "primary-fixed-dim": "#b9c3ff",
                        "inverse-primary": "#2d50d9",
                        "surface": "#121416",
                        "secondary-fixed-dim": "#ffb778",
                        "on-secondary-fixed": "#2e1500",
                        "secondary-fixed": "#ffdcc1",
                        "inverse-on-surface": "#2f3133",
                        "background": "#121416",
                        "surface-container-lowest": "#0c0e10",
                        "on-error": "#690005",
                        "on-secondary-container": "#613400",
                        "on-primary-container": "#001d79",
                        "primary-container": "#6e88ff",
                        "surface-dim": "#121416",
                        "primary": "#b9c3ff",
                        "surface-container": "#1e2022",
                        "tertiary": "#f9abff",
                        "error": "#ffb4ab",
                        "tertiary-fixed": "#ffd6fe",
                        "success": "#10b981"
                    },
                    fontFamily: {
                        "headline": ["Plus Jakarta Sans"],
                        "body": ["Inter"],
                        "label": ["Inter"],
                        "plus-jakarta": ["Plus Jakarta Sans"],
                        "kufi": ["Noto Kufi Arabic"]
                    }
                },
            },
        }
    </script>
    <style>
        body { font-family: 'Inter', 'Noto Kufi Arabic', sans-serif; background-color: #121416; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #121416; }
        ::-webkit-scrollbar-thumb { background: #333537; border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-on-surface antialiased overflow-x-hidden">

    @if(session('success'))
        <div id="toast-success" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] bg-success/90 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-sm transition-all duration-500">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">check_circle</span>
            <span class="text-sm font-bold">{{ session('success') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-success'); if(t) t.style.opacity = '0'; setTimeout(() => { if(t) t.remove(); }, 500); }, 3000);</script>
    @endif

    @if(session('error'))
        <div id="toast-error" class="fixed top-6 left-1/2 -translate-x-1/2 z-[100] bg-error/90 text-on-error px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3 backdrop-blur-sm transition-all duration-500">
            <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">error</span>
            <span class="text-sm font-bold">{{ session('error') }}</span>
        </div>
        <script>setTimeout(() => { const t = document.getElementById('toast-error'); if(t) t.style.opacity = '0'; setTimeout(() => { if(t) t.remove(); }, 500); }, 3000);</script>
    @endif

    @yield('content')

    @stack('scripts')
</body>
</html>