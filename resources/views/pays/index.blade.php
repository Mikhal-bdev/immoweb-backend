<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liste des Pays</title>

    <!-- Styles (vous pouvez remplacer Tailwind par un autre framework CSS) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <header class="bg-blue-600 text-white py-4">
        <div class="max-w-7xl mx-auto px-4">
            <h1 class="text-2xl font-bold">Liste des Pays</h1>
        </div>
    </header>

    <main class="max-w-7xl mx-auto py-6 px-4">
        <!-- Formulaire de recherche -->
        <form method="GET" action="{{ url('api/payss') }}" class="mb-6 flex items-center">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Rechercher..."
                class="border rounded px-4 py-2 flex-grow" />
            <button
                type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded ml-2">
                Rechercher
            </button>
        </form>

        <!-- Tableau des pays -->
        <h2 class="text-xl font-bold mb-4">Liste des Pays</h2>
        <table class="table-auto w-full border-collapse border border-gray-200 mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Code</th>
                    <th class="border px-4 py-2">Alpha2</th>
                    <th class="border px-4 py-2">Alpha3</th>
                    <th class="border px-4 py-2">Nom (FR)</th>
                    <th class="border px-4 py-2">Nom (EN)</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($payss as $pays)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $pays->code }}</td>
                    <td class="border px-4 py-2 text-center">{{ $pays->alpha2 }}</td>
                    <td class="border px-4 py-2 text-center">{{ $pays->alpha3 }}</td>
                    <td class="border px-4 py-2">{{ $pays->nom_fr_fr }}</td>
                    <td class="border px-4 py-2">{{ $pays->nom_en_gb }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="border px-4 py-2 text-center">Aucun pays trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $payss->appends(request()->input())->links() }}</div>

        <!-- Tableau des départements -->
        <h2 class="text-xl font-bold mb-4">Liste des Départements</h2>
        <table class="table-auto w-full border-collapse border border-gray-200 mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Nom</th>
                    <th class="border px-4 py-2">Pays</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($departements as $departement)
                <tr>
                    <td class="border px-4 py-2">{{ $departement->nom_dep }}</td>
                    <td class="border px-4 py-2">{{ $departement->payss->nom_fr_fr ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="border px-4 py-2 text-center">Aucun département trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $departements->appends(request()->input())->links() }}</div>

        <!-- Tableau des communes -->
        <h2 class="text-xl font-bold mb-4">Liste des Communes</h2>
        <table class="table-auto w-full border-collapse border border-gray-200 mb-6">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Nom</th>
                    <th class="border px-4 py-2">Département</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($communes as $commune)
                <tr>
                    <td class="border px-4 py-2">{{ $commune->nom_commune }}</td>
                    <td class="border px-4 py-2">{{ $commune->departement->nom_dep ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="border px-4 py-2 text-center">Aucune commune trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div>{{ $communes->appends(request()->input())->links() }}</div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-4">
        <p>&copy; {{ date('Y') }} Liste des Pays - Laravel</p>
    </footer>
</body>

</html>