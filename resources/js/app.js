//
document.addEventListener('DOMContentLoaded', () => {
    
    // 1. Logika Header Transparan & Animasi Magic Nav Indicator
    const header = document.getElementById('main-header');
    const headerTitle = document.getElementById('header-title');
    const nav = document.getElementById('main-nav');
    const links = document.querySelectorAll('.nav-link');
    const indicator = document.getElementById('nav-indicator');

    // Cari menu mana yang halamannya sedang aktif dibuka (berdasarkan class PHP tadi)
    let activeLink = document.querySelector('.nav-link.active-link');
    if (!activeLink && links.length > 0) activeLink = links[0]; // Fallback ke Beranda
    
    // Simpan status link mana yang sedang disorot kursor
    let currentHovered = activeLink;

    // Fungsi utama: menggeser lebar dan posisi X kotak indikator
    function moveIndicator(target) {
        if (!target) return;
        const targetRect = target.getBoundingClientRect();
        const navRect = nav.getBoundingClientRect();
        
        // Sesuaikan ukuran & letak indikator secara presisi
        indicator.style.width = `${targetRect.width}px`;
        indicator.style.transform = `translateX(${targetRect.left - navRect.left}px)`;
        
        // Panggil fungsi warna agar warna teks langsung menyesuaikan
        updateColors();
    }

    // Fungsi untuk mengubah warna antara Transparan (Putih) dan Scrolled (Merah)
    function updateColors() {
        const isScrolled = window.scrollY > 100;

        if (isScrolled) {
            // KONDISI 2: Header Putih, discroll kebawah
            header.classList.remove('bg-transparent', 'py-4');
            header.classList.add('bg-white', 'shadow-md', 'py-2');
            
            if(headerTitle) headerTitle.classList.replace('text-white', 'text-brand-dark');
            indicator.classList.replace('bg-white', 'bg-brand-dark'); // Indikator jadi merah

            // Atur warna tiap teks menu
            links.forEach(link => {
                if (link === currentHovered) {
                    link.className = `nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 text-white`; // Teks dalam indikator
                } else {
                    link.className = `nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 text-brand-dark`; // Teks luar indikator
                }
            });
        } else {
            // KONDISI 1: Header Transparan, posisi di atas
            header.classList.add('bg-transparent', 'py-4');
            header.classList.remove('bg-white', 'shadow-md', 'py-2');
            
            if(headerTitle) headerTitle.classList.replace('text-brand-dark', 'text-white');
            indicator.classList.replace('bg-brand-dark', 'bg-white'); // Indikator jadi putih

            // Atur warna tiap teks menu
            links.forEach(link => {
                if (link === currentHovered) {
                    link.className = `nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 text-brand-dark`; // Teks dalam indikator
                } else {
                    link.className = `nav-link relative px-5 py-1.5 rounded-full transition-colors duration-300 text-white drop-shadow-md`; // Teks luar indikator
                }
            });
        }
    }

    // Eksekusi awal: Biarkan font loading dulu sebentar lalu paskan posisinya
    setTimeout(() => moveIndicator(activeLink), 100);
    
    // Event listener: Saat layar di-resize, paskan ulang posisinya
    window.addEventListener('resize', () => moveIndicator(currentHovered));
    
    // Event listener: Saat di-scroll
    window.addEventListener('scroll', updateColors);

    // Event listener: Saat kursor diarahkan ke menu lain (Hover)
    links.forEach(link => {
        link.addEventListener('mouseenter', () => {
            currentHovered = link;
            moveIndicator(link);
        });
    });

    // Event listener: Saat kursor keluar dari area navigasi, kembalikan ke menu aktif
    nav.addEventListener('mouseleave', () => {
        currentHovered = activeLink;
        moveIndicator(activeLink);
    });

    // --- (Script Intersection Observer Scroll Animasi biarkan tetap di bawah sini) ---

    // 2. Animasi Scroll Reveal — versi diperbaharui
const observerOptions = {
    root: null,
    rootMargin: '0px 0px -60px 0px', // trigger sedikit sebelum elemen masuk penuh
    threshold: 0.12
};

const observer = new IntersectionObserver((entries, obs) => {
    entries.forEach((entry, i) => {
        if (entry.isIntersecting) {
            // Stagger berdasarkan posisi elemen dalam parent
            const siblings = [...entry.target.parentElement.querySelectorAll('.scroll-anim:not(.animate-in)')];
            const idx = siblings.indexOf(entry.target);
            const extraDelay = idx * 80; // 80ms antar sibling

            setTimeout(() => {
                entry.target.classList.add('animate-in');
            }, extraDelay);

            obs.unobserve(entry.target);
        }
    });
}, observerOptions);

// Assign variant class otomatis jika belum ada
document.querySelectorAll('.scroll-anim').forEach(el => {
    // Jika belum punya variant, default ke fade-up
    const hasVariant = ['fade-up','slide-left','slide-right','scale-in']
        .some(c => el.classList.contains(c));
    if (!hasVariant) el.classList.add('fade-up');

    observer.observe(el);
});
});