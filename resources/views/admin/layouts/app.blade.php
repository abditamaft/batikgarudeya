<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Batik Garudeya</title>
    @vite(['resources/css/app.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Caveat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
</head>

<body class="bg-gray-50 text-gray-800 font-sans flex h-screen overflow-hidden">

    <aside id="sidebar" class="bg-brand-dark text-white w-64 flex-shrink-0 hidden md:flex flex-col h-full transition-all duration-300">
        <div class="p-6 border-b border-white/10 flex items-center justify-between">
            <h2 class="text-xl font-bold tracking-wider">Garudeya CMS</h2>
            <button id="close-sidebar" class="md:hidden text-white text-2xl">&times;</button>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2 px-2">Menu Utama</p>
            <a href="/admin/dashboard" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/dashboard') ? 'bg-brand-green' : '' }}">📊 Dashboard</a>
            <a href="/admin/landing" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/landing') ? 'bg-brand-green' : '' }}">🖥️ Landing Page</a>
            <a href="/admin/profil-umkm" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/profil-umkm') ? 'bg-brand-green' : '' }}">🏢 Profil UMKM</a>
            <p class="text-xs text-gray-400 uppercase tracking-wider mt-6 mb-2 px-2">E-Katalog</p>
            <a href="{{ route('admin.kategori.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">🏷️ Kategori Produk</a>
            <a href="{{ route('admin.produk.index') }}" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">📦 Daftar Produk</a>
            
            <p class="text-xs text-gray-400 uppercase tracking-wider mt-6 mb-2 px-2">Publikasi</p>
            <a href="/admin/artikel" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition">📝 Artikel / Blog</a>
            <a href="/admin/pengaturan-web" class="block px-4 py-2 rounded-lg hover:bg-white/10 transition {{ request()->is('admin/pengaturan-web') ? 'bg-brand-green' : '' }}">⚙️ Pengaturan Web</a>
        </nav>
    </aside>

    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
            <button id="open-sidebar" class="md:hidden text-gray-600 text-2xl">☰</button>
            <div class="hidden md:block"></div> <div class="flex items-center gap-4">
                <span class="text-sm font-medium">{{ Auth::user()->name ?? 'Administrator' }}</span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="text-sm bg-red-100 text-red-600 px-3 py-1 rounded-md hover:bg-red-200 transition">Logout</button>
                </form>
            </div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
            @yield('content')
        </main>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        document.getElementById('open-sidebar').addEventListener('click', () => {
            sidebar.classList.remove('hidden');
            sidebar.classList.add('absolute', 'z-50', 'shadow-2xl');
        });
        document.getElementById('close-sidebar').addEventListener('click', () => {
            sidebar.classList.add('hidden');
            sidebar.classList.remove('absolute', 'z-50', 'shadow-2xl');
        });

        ClassicEditor.create(document.querySelector('#editor'), {
            toolbar: [
                'heading', '|', 'bold', 'italic', 'link',
                'bulletedList', 'numberedList', 'blockQuote',
                'insertTable', 'undo', 'redo'
            ]
        })
        .then(editor => {
            // Sinkronisasi isi editor ke textarea
            editor.model.document.on('change:data', () => {
                document.querySelector('#editor').value = editor.getData();
            });
        })
        .catch(error => {
            console.error(error);
        });

        document.getElementById('thumbnailInput').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview_gambarArtikel').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });


        
    </script>

</body>
</html>