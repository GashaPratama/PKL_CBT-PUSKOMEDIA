<!-- ✅ UJIAN SISWA DENGAN GAMBAR - FIXED -->
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ujian - {{ $ujianId }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
  <script>
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/service-worker.js')
        .then(() => console.log('✅ Service Worker ready'))
        .catch(err => console.error('❌ SW failed:', err));
    }
  </script>
</head>
<body class="bg-gray-100 p-4 sm:p-6 font-sans">

<div class="w-full max-w-5xl mx-auto bg-white p-4 sm:p-6 rounded-xl shadow-md flex flex-col-reverse lg:flex-row gap-6">

  <!-- Bagian Soal -->
  <div class="flex-1">
    <h2 class="text-xl sm:text-2xl font-bold mb-3 text-gray-800" id="namaUjian">📘 Ujian</h2>
    <div class="mb-4 text-sm sm:text-base text-red-500 font-semibold">Sisa Waktu: <span id="timer"></span></div>

    <form onsubmit="submitJawaban(); return false;">
      <div id="soal-container"></div>

      <div class="flex flex-col sm:flex-row justify-between gap-3 mt-6">
        <button type="button" onclick="prevSoal()" class="bg-gray-600 text-white px-4 py-2 rounded">← Sebelumnya</button>
        <button type="button" onclick="nextSoal()" class="bg-blue-600 text-white px-4 py-2 rounded">Selanjutnya →</button>
      </div>

      <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mt-4">
        <button type="button" onclick="toggleTandai()" class="bg-red-100 text-red-600 px-4 py-2 rounded border border-red-400 text-sm">
          🚩 Tandai Penting
        </button>
        <button id="btn-selesai" type="submit" disabled class="bg-green-600 opacity-50 cursor-not-allowed text-white px-6 py-2 rounded text-sm">
          ✅ Selesai Ujian
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
const ujianId = @json($ujianId);
const secretKey = 'kunc!_rahasia123';
const jawabanKey = `ujian_${ujianId}_jawaban`;
const tandaiKey = `ujian_${ujianId}_tandai`;
const waktuKey = `ujian_${ujianId}_waktu_mulai`;

function acakArray(array) {
  const arr = [...array];
  for (let i = arr.length - 1; i > 0; i--) {
    const j = Math.floor(Math.random() * (i + 1));
    [arr[i], arr[j]] = [arr[j], arr[i]];
  }
  return arr;
}

const encrypted = localStorage.getItem(`ujian_${ujianId}_data`);
if (!encrypted) {
  alert("❌ Soal tidak ditemukan. Silakan unduh terlebih dahulu.");
  window.location.href = "/siswa/dashboard";
}

let decryptedData, soalList = [];
try {
  decryptedData = JSON.parse(CryptoJS.AES.decrypt(encrypted, secretKey).toString(CryptoJS.enc.Utf8));
  if (!decryptedData || !decryptedData.soal || !Array.isArray(decryptedData.soal)) throw new Error();

  soalList = acakArray(decryptedData.soal.map(soal => {
  const pilihan = acakArray(
    ['a', 'b', 'c', 'd', 'e', 'f']
      .map((k, i) => ({
        kode: String.fromCharCode(65 + i),
        teks: soal[`opsi_${k}`]
          ?.replace(/^\s*[A-Fa-f]\s*[\.\:\)]\s*/, '')  // 🔥 Bersihkan awalan huruf
          ?.trim() || null
      }))
      .filter((item, index, self) =>
        item.teks &&
        self.findIndex(i => i.teks === item.teks) === index
      )
  );
  return {
    id: soal.id,
    pertanyaan: soal.pertanyaan,
    gambar: soal.gambar ?? null,
    pilihan
  };
}));


} catch (e) {
  alert("❌ Gagal membaca soal. Data rusak atau kunci salah.");
  window.location.href = "/siswa/dashboard";
}


document.getElementById("namaUjian").textContent = "📘 Ujian: " + decryptedData.ujian.nama;

const durasiUjianDetik = decryptedData.ujian.durasi * 60;
let waktuMulai = localStorage.getItem(waktuKey);
if (!waktuMulai) {
  waktuMulai = new Date().toISOString();
  localStorage.setItem(waktuKey, waktuMulai);
}
let waktu = durasiUjianDetik - Math.floor((new Date() - new Date(waktuMulai)) / 1000);
if (waktu <= 0) {
  alert("⏰ Waktu ujian telah habis."); waktu = 0;
}

let jawabanSementara = {}, tandaiPenting = {};
try {
  jawabanSementara = JSON.parse(localStorage.getItem(jawabanKey)) || {};
  tandaiPenting = JSON.parse(localStorage.getItem(tandaiKey)) || {};
} catch {}

let currentIndex = 0;

function countdown() {
  const timer = document.getElementById("timer");
  let m = Math.floor(waktu / 60), d = waktu % 60;
  timer.textContent = `${m}m ${d < 10 ? '0' : ''}${d}s`;
  if (waktu <= 0) { alert("⏰ Waktu habis!"); submitJawaban(); }
  waktu--;
}
setInterval(countdown, 1000);

function renderSoal(index) {
  const soal = soalList[index];
  const selected = jawabanSementara[soal.id] || '';
  let pilihanHTML = '';

  soal.pilihan.forEach((item, i) => {
    pilihanHTML += `
      <label class="block cursor-pointer">
        <input id="opsi_${soal.id}_${i}" type="radio" name="radio_${soal.id}" value="${item.kode}" ${selected === item.kode ? 'checked' : ''} onchange="simpanJawaban(${soal.id}, '${item.kode}')">
        <span class="ml-2">${item.teks}</span>
      </label>`;
  });

  document.getElementById('soal-container').innerHTML = `
    <div class="p-4 bg-gray-50 rounded shadow text-sm sm:text-base">
      <h3 class="font-semibold mb-2">Soal ${index + 1} dari ${soalList.length}:</h3>
      <p class="mb-3 text-gray-800">${soal.pertanyaan}</p>
      ${soal.gambar ? `<img src="/img/soal/${soal.gambar}" alt="Gambar Soal" class="rounded border mb-3 max-w-full object-contain" style="max-height: 300px;">` : ''}
      <div class="space-y-2 ml-2">${pilihanHTML}</div>
    </div>`;
  highlightNavigation();
}



function simpanJawaban(id, val) {
  jawabanSementara[id] = val;
  localStorage.setItem(jawabanKey, JSON.stringify(jawabanSementara));
  updateTombolSelesai();
  highlightNavigation();
}

function toggleTandai() {
  const soal = soalList[currentIndex];
  tandaiPenting[soal.id] = !tandaiPenting[soal.id];
  localStorage.setItem(tandaiKey, JSON.stringify(tandaiPenting));
  highlightNavigation();
}

function nextSoal() { if (currentIndex < soalList.length - 1) { currentIndex++; renderSoal(currentIndex); } }
function prevSoal() { if (currentIndex > 0) { currentIndex--; renderSoal(currentIndex); } }

function submitJawaban() {
  if (Object.keys(jawabanSementara).length === 0) {
    alert("🚫 Anda belum menjawab soal apa pun."); return;
  }
  if (!confirm("Apakah kamu yakin ingin menyelesaikan ujian sekarang?")) return;

  const hasil = {
    ujian_id: ujianId,
    waktu: new Date().toISOString(),
    jawaban: jawabanSementara
  };
  localStorage.setItem(`jawaban_ujian_${ujianId}`, JSON.stringify(hasil));
  localStorage.removeItem(jawabanKey);
  localStorage.removeItem(tandaiKey);
  alert("✅ Jawaban disimpan! Anda akan diarahkan ke dashboard.");
  window.location.href = "/siswa/dashboard";
}

function renderNavigation() {
  const nav = document.getElementById('navigasi-soal');
  nav.innerHTML = '';
  soalList.forEach((soal, i) => {
    const btn = document.createElement('button');
    btn.innerText = i + 1;
    btn.id = `nav-${i}`;
    btn.className = "rounded-full px-2 py-1 text-sm font-bold border";
    btn.onclick = () => { currentIndex = i; renderSoal(currentIndex); };
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

function updateTombolSelesai() {
  const btn = document.getElementById("btn-selesai");
  const aktif = Object.keys(jawabanSementara).length > 0;
  btn.disabled = !aktif;
  btn.classList.toggle("opacity-50", !aktif);
  btn.classList.toggle("cursor-not-allowed", !aktif);
}

renderNavigation();
renderSoal(currentIndex);
updateTombolSelesai();
</script>
</body>
</html>
