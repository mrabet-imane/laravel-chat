<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Chargement des fichiers JS via Vite -->
    @vite(['resources/js/app.js'])

    <!-- Chargement de Bootstrap pour la mise en page -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optionnel : Pour améliorer les performances, tu peux aussi ajouter un fichier CSS personnalisé ici -->
    <!-- <link rel="stylesheet" href="{{ mix('css/app.css') }}"> -->
</head>
<body>
    <div class="container mt-4">
        <!-- En-tête de la page -->
        @yield('header')

        <!-- Contenu de la page -->
        @yield('content')
    </div>

    <!-- Inclusion de jQuery, Popper.js et Bootstrap JS (si nécessaire pour certains composants) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
