<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Ujian - {{ $exam->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const waktuMulaiKey = "simulasi_waktu_mulai_{{ $exam->id }}";
        const waktuSekarang = Math.floor(Date.now() / 1000);
        let waktuMulai = localStorage.getItem(waktuMulaiKey);

        if (!waktuMulai) {
            waktuMulai = waktuSekarang;
            localStorage.setItem(waktuMulaiKey, waktuMulai);
        } else {
            waktuMulai = parseInt(waktuMulai);
        }

        const durasi = {{ $exam->durasi * 60 }};
        let waktu = durasi - (waktuSekarang - waktuMulai);

        function countdown() {
            const timer = document.getElementById("timer");
            let menit = Math.floor(waktu / 60);
            let detik = waktu % 60;
            timer.innerHTML = `${menit}m ${detik < 10 ? '0' : ''}${detik}s`;
            if (waktu <= 0) {
                alert("⏰ Waktu habis!");
                submitFinal();
            }
            waktu--;
        }

        setInterval(countdown, 1000);
    </script>
</head>
<body class="bg-gray-100 p-4 sm:p-6 font-sans">

<div class="w-full max-w-5xl mx-auto bg-white p-4 sm:p-6 rounded-xl shadow-md flex flex-col-reverse lg:flex-row gap-6">

    <!-- Bagian Soal -->
    <div class="flex-1">
        <h2 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800">🧪 Simulasi: {{ $exam->nama }}</h2>
        <div class="mb-4 text-sm sm:text-base text-red-500 font-semibold">Sisa Waktu: <span id="timer"></span></div>

        <form id="form-simulasi" method="POST" action="{{ route('admin.ujian.simulasi.submit', $exam->id) }}">
            @csrf

            <div id="soal-container"></div>
            <div id="hidden-inputs"></div>

            <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
                <button type="button" onclick="prevSoal()" class="bg-gray-600 text-white px-4 py-2 rounded">← Sebelumnya</button>
                <button type="button" onclick="nextSoal()" class="bg-blue-600 text-white px-4 py-2 rounded">Selanjutnya →</button>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mt-4">
                <button type="button" onclick="toggleTandai()" class="bg-red-100 text-red-600 px-4 py-2 rounded border border-red-400 text-sm">
                    🚩 Tandai Penting
                </button>
                <button type="button" onclick="submitFinal()" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded text-sm">
                    ✅ Selesai Simulasi
                </button>
            </div>
        </form>
    </div>

    <!-- Navigasi Soal -->
    <div class="w-full lg:w-64">
        <h3 class="text-lg font-semibold mb-2">📌 Navigasi Soal</h3>
        <div id="navigasi-soal" class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 gap-2"></div>
        <div class="text-xs mt-4 space-y-1">
            <div><span class="inline-block w-3 h-3 bg-blue-500 mr-1 rounded-full"></span> Aktif</div>
            <div><span class="inline-block w-3 h-3 bg-green-500 mr-1 rounded-full"></span> Sudah Dijawab</div>
            <div><span class="inline-block w-3 h-3 bg-red-500 mr-1 rounded-full"></span> Ditandai Penting</div>
        </div>
    </div>
</div>

<script>
    function shuffle(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    let soalList = @json($exam->soals).map(soal => {
        const opsi = [
            { kode: 'A', teks: soal.opsi_a },
            { kode: 'B', teks: soal.opsi_b },
            { kode: 'C', teks: soal.opsi_c },
            { kode: 'D', teks: soal.opsi_d }
        ];
        const jawabanBenarAsli = soal.jawaban_benar.toUpperCase();
        const isiJawabanBenar = opsi.find(o => o.kode === jawabanBenarAsli)?.teks;
        const opsiDiacak = shuffle(opsi);
        const jawabanBenarBaru = opsiDiacak.find(o => o.teks === isiJawabanBenar)?.kode;

        return {
            ...soal,
            opsi_diacak: opsiDiacak,
            jawaban_benar_shuffle: jawabanBenarBaru
        };
    });

    soalList = shuffle(soalList);
    let currentIndex = 0;
    const jawabanSementara = {};
    const tandaiPenting = {};

    function renderSoal(index) {
        const soal = soalList[index];
        const selected = jawabanSementara[soal.id] || '';

        document.getElementById('soal-container').innerHTML = `
            <div class="p-4 bg-gray-50 rounded shadow text-sm sm:text-base">
                <h3 class="font-semibold mb-2">Soal ${index + 1} dari ${soalList.length}:</h3>
                <p class="mb-3">${soal.pertanyaan}</p>
                <div class="space-y-2 ml-2">
                    ${soal.opsi_diacak.map(opt => `
                        <label class="block">
                            <input type="radio" name="radio_${soal.id}" value="${opt.kode}"
                            ${selected === opt.kode ? 'checked' : ''}
                            onchange="simpanJawaban(${soal.id}, '${opt.kode}')">
                            ${opt.kode}. ${opt.teks}
                        </label>
                    `).join('')}
                </div>
                <input type="hidden" name="jawaban[${soal.id}]" id="jawaban_${soal.id}" value="${selected}">
            </div>
        `;

        highlightNavigation();
    }

    function simpanJawaban(soalId, pilihan) {
        jawabanSementara[soalId] = pilihan;
        document.getElementById(`jawaban_${soalId}`).value = pilihan;
        highlightNavigation();
    }

    function toggleTandai() {
        const soal = soalList[currentIndex];
        tandaiPenting[soal.id] = !tandaiPenting[soal.id];
        highlightNavigation();
    }

    function nextSoal() {
        if (currentIndex < soalList.length - 1) {
            currentIndex++;
            renderSoal(currentIndex);
        }
    }

    function prevSoal() {
        if (currentIndex > 0) {
            currentIndex--;
            renderSoal(currentIndex);
        }
    }

    function submitFinal() {
        const hiddenContainer = document.getElementById('hidden-inputs');
        hiddenContainer.innerHTML = '';

        for (const id in jawabanSementara) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `jawaban[${id}]`;
            input.value = jawabanSementara[id];
            hiddenContainer.appendChild(input);
        }

        // 🧹 Hapus waktu mulai dari localStorage
        localStorage.removeItem("simulasi_waktu_mulai_{{ $exam->id }}");

        document.getElementById('form-simulasi').submit();
    }

    function renderNavigation() {
        const nav = document.getElementById('navigasi-soal');
        nav.innerHTML = '';
        soalList.forEach((soal, i) => {
            const btn = document.createElement('button');
            btn.innerText = i + 1;
            btn.id = `nav-${i}`;
            btn.className = "rounded-full px-2 py-1 text-sm font-bold border";
            btn.onclick = () => {
                currentIndex = i;
                renderSoal(currentIndex);
            };
            nav.appendChild(btn);
        });
    }

    function highlightNavigation() {
        soalList.forEach((soal, i) => {
            const btn = document.getElementById(`nav-${i}`);
            btn.className = "rounded-full px-2 py-1 text-sm font-bold border";

            const answered = jawabanSementara[soal.id];
            const marked = tandaiPenting[soal.id];

            if (i === currentIndex) {
                btn.classList.add("bg-blue-500", "text-white");
            } else if (marked) {
                btn.classList.add("bg-red-500", "text-white");
            } else if (answered) {
                btn.classList.add("bg-green-500", "text-white");
            } else {
                btn.classList.add("bg-white", "text-black");
            }
        });
    }

    renderNavigation();
    renderSoal(currentIndex);
</script>
</body>
</html>
