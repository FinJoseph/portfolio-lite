<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Anti-FOUC : applique le thème le plus tôt possible (avant le rendu Vue).
         Le localStorage est la source de vérité ; en l'absence de préférence enregistrée,
         on respecte prefers-color-scheme. --}}
    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    {{-- inertia : Inertia remplacera dynamiquement ce titre selon la page (ex: via Head côté Vue) --}}
    <title inertia>Portfolio</title>

    {{-- @vite : directive Laravel qui injecte les balises <link>/<script> générées par Vite
         (en dev = pointe vers le serveur Vite local ; en prod = pointe vers les fichiers compilés dans /public/build) --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- @inertiaHead : endroit où Inertia injecte les balises <meta>/<title> dynamiques définies dans chaque page Vue --}}
    @inertiaHead

    <meta name="google-site-verification" content="Rr_em-oySkUVt9Gwjog5HSfgdtecvQ1nNLxjUmU8PX0" />
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#c97a2b">
    <link rel="alternate" type="application/rss+xml" title="Flux RSS" href="/feed.xml" />
</head>

<body>
    {{-- @inertia : génère la div racine (<div id="app" data-page="...">) où Vue va se monter
         data-page contient les données JSON initiales (nom du composant + props) --}}
    @inertia
</body>

</html>
