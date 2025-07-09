<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ujian Offline - {{ $ujian->nama }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-4">📝 {{ $ujian->nama }}</h2>
        <p class="mb-4 text-gray-600">Durasi: {{ $ujian->durasi }} menit</p>

        <div id="daftar-soal" class="space-y-6"></div>

        <div class="mt-8 text-center">
            <button onclick="simpanJawaban()" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                💾 Simpan Jawaban ke LocalStorage
            </button>
        </div>
    </div>

    <script>
        const soals = @json($ujian->soals);

        const container = document.getElementById("daftar-soal");

        soals.forEach((soal, index) => {
            const wrapper = document.createElement("div");
            wrapper.innerHTML = `
                <div class="p-4 bg-gray-50 rounded shadow">
                    <p class="font-semibold mb-2">Soal ${index + 1}: ${soal.pertanyaan}</p>
                    <label><input type="radio" name="soal_${soal.id}" value="A"> A. ${soal.opsi_a}</label><br>
                    <label><input type="radio" name="soal_${soal.id}" value="B"> B. ${soal.opsi_b}</label><br>
                    <label><input type="radio" name="soal_${soal.id}" value="C"> C. ${soal.opsi_c}</label><br>
                    <label><input type="radio" name="soal_${soal.id}" value="D"> D. ${soal.opsi_d}</label>
                </div>
            `;
            container.appendChild(wrapper);
        });

        function simpanJawaban() {
            const jawaban = {};
            soals.forEach(soal => {
                const selected = document.querySelector(`input[name="soal_${soal.id}"]:checked`);
                jawaban[soal.id] = selected ? selected.value : null;
            });

            localStorage.setItem('ujian_{{ $ujian->id }}_jawaban', JSON.stringify(jawaban));
            alert('Jawaban disimpan di perangkat. Anda bisa submit kapan saja.');
        }
    </script>
</body>
</html>
