# EXPLANATION.md

Dokumen ini berisi penjelasan singkat mengenai keputusan arsitektur dan desain yang saya ambil selama mengerjakan *project* ini.

## Keputusan Arsitektur & Trade-offs

### 1. Separation of Concerns (Nuxt 4 + Laravel 11)
Daripada membangun aplikasi *monolith* (seperti menggunakan Laravel Livewire atau Inertia), saya memutuskan untuk memisahkan *frontend* (**Nuxt 4**) dan *backend* (**Laravel 11** murni sebagai REST API).
- **Trade-off:** Membutuhkan dua server terpisah saat *development* dan harus mengatur CORS.
- **Alasan:** Pendekatan ini menunjukkan pemahaman saya tentang desain API modern dan memungkinkan *frontend* serta *backend* untuk di-*scale* secara terpisah di masa depan. Ini sangat relevan dengan peran *Full-Stack Developer*.

### 2. Database & Eager Loading
Saya menggunakan **SQLite** secara bawaan (*default*) agar proses penilaian/evaluasi lokal oleh *reviewer* menjadi sangat mudah (tidak perlu repot menyalakan MySQL daemon). Namun, struktur *migration* dan ORM-nya 100% kompatibel jika ingin dipindah ke MySQL/PostgreSQL.
Untuk mengatasi masalah **N+1 query** (salah satu poin bonus), saya mengimplementasikan `with('author')` di `BookController` dan `withCount('books')` di `AuthorController`.

### 3. Caching Strategy
Untuk meningkatkan performa (poin bonus lainnya), saya membungkus *method* `index()` pada `AuthorController` dan `BookController` menggunakan `Cache::remember()`.
- **Trade-off:** Data hasil *cache* berpotensi basi (*stale*).
- **Alasan & Solusi:** Untuk mengatasi masalah data basi, saya membuat sistem invalidasi otomatis (`Cache::flush()`) di dalam setiap *method* yang mengubah data (`store`, `update`, `destroy`). Dengan begitu, pengguna selalu melihat data terbaru tanpa mengorbankan kecepatan baca (*read performance*).

## Desain UI/UX (Neobrutalism)
Antarmuka aplikasi ini sengaja didesain menggunakan gaya **Neobrutalism** (warna-warni mencolok, bayangan hitam tebal, garis batas tegas).
- **Alasan:** Syarat tes meminta antarmuka yang "bersih/clean". Alih-alih menggunakan *library* desain generik yang biasa dipakai orang lain, saya membangun *design system* ini dari nol menggunakan Tailwind CSS. Ini bertujuan untuk menonjolkan kemampuan *styling* tingkat lanjut dan membuat karya ini tampil beda dan *memorable* secara visual.
- **Fitur UX Tambahan:** Saya menyertakan animasi mikro (tombol bereaksi saat ditekan), *loading skeleton* buatan sendiri (`Skeleton.vue`), dan transisi warna yang mulus.

## Fitur Tambahan (Extra)
1. **Automated Testing:** Saya menambahkan tes otomatis menggunakan **PHPUnit** (untuk Backend API) dan **Vitest** (untuk Frontend komponen). Ini memastikan tidak ada API atau UI yang rusak tanpa ketahuan.
2. **Lokalisasi Bahasa Indonesia:** Data *dummy* di *Seeder* telah diatur menggunakan *Faker* format lokal (`id_ID`), sehingga nama penulis dan deskripsi buku terasa lebih relevan dan tidak dipenuhi teks Latin (Lorem Ipsum).
