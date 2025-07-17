<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kreatoria AI - Analisis Kandidat v2</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    :root {
      --bg-dark: #111827; --bg-medium: #1F2937; --bg-light: #374151;
      --text-primary: #F9FAFB; --text-secondary: #9CA3AF; --accent: #22D3EE;
      --navbar-height: 88px;
    }
    html, body { height: 100%; margin: 0; padding: 0; }
    body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: var(--bg-dark); color: var(--text-primary); display: flex; flex-direction: column; height: 100vh; overflow: hidden; }
    .navbar { height: var(--navbar-height); padding: 0 5%; display: flex; align-items: center; border-bottom: 1px solid var(--bg-light); flex-shrink: 0; }
    .logo { font-size: 24px; font-weight: 800; color: var(--text-primary); text-decoration: none; }
    .chat-container { flex-grow: 1; display: flex; flex-direction: column; width: 100%; max-width: 800px; margin: 0 auto; padding: 20px; overflow: hidden; }
    .chat-history { flex-grow: 1; overflow-y: auto; padding: 20px 0; display: flex; flex-direction: column; gap: 25px; max-height: calc(100vh - var(--navbar-height) - 180px); }
    .message-bubble { display: flex; gap: 15px; max-width: 85%; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--bg-light); display: flex; justify-content: center; align-items: center; font-size: 20px; flex-shrink: 0; }
    .message-content { background-color: var(--bg-medium); padding: 15px 20px; border-radius: 12px; }
    .message-content p { margin:0; line-height: 1.7; word-wrap: break-word; }
    .ai-message { align-self: flex-start; }
    .user-message { align-self: flex-end; flex-direction: row-reverse; }
    .user-message .message-content { background-color: var(--accent); color: var(--bg-dark); }
    .input-area { flex-shrink: 0; padding-top: 20px; border-top: 1px solid var(--bg-light); background-color: var(--bg-dark); }
    .input-area textarea { width: 100%; box-sizing: border-box; height: 80px; padding: 15px; background-color: var(--bg-medium); border: 1px solid var(--bg-light); border-radius: 8px; color: var(--text-primary); font-size: 16px; resize: none; }
    .input-area button { width: 100%; margin-top: 10px; padding: 12px; border: none; background-color: var(--accent); color: var(--bg-dark); border-radius: 8px; font-weight: 700; cursor: pointer; }
    .input-area button:disabled { background-color: var(--bg-light); cursor: not-allowed; }
  </style>
</head>
<body>
  <nav class="navbar">
    <a href="{{ route('explore.index') }}" class="logo">Kreatoria</a>
  </nav>

  <div class="chat-container">
    <div class="chat-history" id="chat-history"></div>
    <div class="input-area" id="input-area">
      <textarea id="user-detailed-input" placeholder="Ketik kebutuhan Anda... Contoh: saya butuh desainer untuk membuat logo brand kopi"></textarea>
      <button id="send-button">Kirim ke AI</button>
    </div>
  </div>

<script>
document.addEventListener('DOMContentLoaded', () => {
  const kandidatDummy = [
    { id: 1, nama: 'Aditya Pratama', jabatan: 'Senior UI/UX Designer', keahlian: ['UI/UX Design', 'Figma', 'Prototyping', 'Design System'], karya: [{ judul: 'Ollie - Landing Page UI Kit' }, { judul: 'Aplikasi Mobile Banking Redesign' }] },
    { id: 2, nama: 'Rina Chen', jabatan: 'Branding & Identity Specialist', keahlian: ['Branding', 'Logo Design', 'Adobe Illustrator'], karya: [{ judul: 'Nusantara Coffee - Brand Identity' }, { judul: 'Logo untuk Startup Tech' }] },
    { id: 3, nama: 'Bayu Wijaya', jabatan: 'Frontend Developer & Illustrator', keahlian: ['Web Development', 'React.js', 'Ilustrasi', 'Character Design'], karya: [{ judul: 'Cosmic Wanderer - Character Design' }, { judul: 'Portfolio Website for Photographers' }] }
  ];

  // --- PENTING: GANTI DENGAN KUNCI API GROQ ANDA YANG VALID ---
  const API_KEY = "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";
  const MODEL = "llama3-8b-8192";

  const chatHistory = document.getElementById('chat-history');
  const sendButton = document.getElementById('send-button');
  const userInput = document.getElementById('user-detailed-input');

  function addMessageToChat(sender, text) {
    const bubble = document.createElement('div');
    bubble.className = `message-bubble ${sender}-message`;
    bubble.innerHTML = `<div class="avatar"><i class="fas ${sender === 'ai' ? 'fa-robot' : 'fa-user'}"></i></div><div class="message-content"><p>${text.replace(/\n/g, '<br>')}</p></div>`;
    chatHistory.appendChild(bubble);
    chatHistory.scrollTop = chatHistory.scrollHeight;
  }

  async function panggilAI(kebutuhan) {
    // --- INI BAGIAN YANG DIPERBAIKI ---
    if (API_KEY === "GANTI_DENGAN_KUNCI_API_GROQ_ANDA") {
        addMessageToChat('ai', '<strong>ERROR:</strong> Kunci API belum diatur. Silakan edit file HTML dan ganti nilai variabel `API_KEY` dengan kunci API Groq Anda yang valid.');
        return;
    }

    addMessageToChat('user', kebutuhan);
    sendButton.disabled = true;
    userInput.value = '';
    addMessageToChat('ai', 'Oke, saya terima permintaan Anda. Menganalisis dan mencocokkan kandidat...');

    let profilKandidatLengkap = [];

    // TAHAP 1: Terjemahkan semua profil (jika belum 100% ID)
    const promptTerjemahan = `Anda adalah API penerjemah ahli. Terjemahkan setiap objek dalam array JSON berikut ke Bahasa Indonesia yang natural. Kunci yang perlu diterjemahkan adalah "jabatan", "keahlian", dan "judul" di dalam "karya". Balas HANYA dengan array JSON yang valid. Input: ${JSON.stringify(kandidatDummy, null, 2)} Output:`;
    try {
        const response = await fetch("https://api.groq.com/openai/v1/chat/completions", {
            method: "POST",
            headers: { "Content-Type": "application/json", "Authorization": `Bearer ${API_KEY}` },
            body: JSON.stringify({ model: MODEL, messages: [{ role: "user", content: promptTerjemahan }], temperature: 0.1, response_format: { type: "json_object" } })
        });
        if (!response.ok) throw new Error(`HTTP error ${response.status}`);
        const data = await response.json();
        const content = JSON.parse(data.choices[0].message.content);
        profilKandidatLengkap = Array.isArray(content) ? content : content.kandidat || kandidatDummy;
    } catch (error) {
        console.error("GAGAL PADA TAHAP TERJEMAHAN:", error);
        addMessageToChat('ai', `<strong>ERROR:</strong> Gagal menerjemahkan profil. Mungkin ada masalah dengan API Key atau jaringan. Menggunakan data asli.`);
        profilKandidatLengkap = kandidatDummy; // fallback ke data asli jika gagal
    }

    // TAHAP 2: Analisis setiap kandidat dengan data yang sudah bersih
    for (const kandidat of profilKandidatLengkap) {
      const daftarKaryaStr = kandidat.karya.map(k => `- Judul: ${k.judul}`).join('\n');

      const promptAnalisis = `
        Anda adalah AI Perekrut ahli, tegas, dan analitis.
        Tugas Anda adalah menilai kecocokan kandidat dengan kebutuhan pencari berdasarkan data yang 100% dalam Bahasa Indonesia.

        [Kebutuhan Pencari]
        ${kebutuhan}

        [Profil Kandidat]
        Nama: ${kandidat.nama}
        Jabatan: ${kandidat.jabatan}
        Keahlian: ${kandidat.keahlian.join(', ')}

        [Daftar Karya Relevan]
        ${daftarKaryaStr}

        INSTRUKSI OUTPUT:
        1.  Tentukan Persentase Kecocokan dari 0% hingga 100%.
        2.  Tentukan Level Kecocokan (Sangat Cocok, Cukup Cocok, Kurang Cocok) berdasarkan persentase.
        3.  Buat ALASAN yang spesifik. Hubungkan secara langsung [Keahlian] atau [Daftar Karya] kandidat dengan [Kebutuhan Pencari]. Jangan memberi alasan umum.
            Contoh alasan bagus: "Sangat cocok karena keahliannya di Desain Logo dan portofolionya 'Nusantara Coffee' relevan langsung dengan kebutuhan Anda."
            Contoh alasan buruk: "Dia punya skill yang bagus."

        Berikan jawaban HANYA dalam format satu baris yang dipisahkan oleh tanda hubung (-) seperti ini, tanpa teks pembuka atau penutup:
        NAMA - PERSENTASE% - LEVEL KECOCOKAN - ALASAN
      `;

      try {
        const response = await fetch("https://api.groq.com/openai/v1/chat/completions", {
          method: "POST",
          headers: { "Content-Type": "application/json", "Authorization": `Bearer ${API_KEY}` },
          body: JSON.stringify({
            model: MODEL,
            messages: [
              { role: "system", content: "Anda adalah asisten AI perekrut yang analitis. Jawab ringkas dalam Bahasa Indonesia dan patuhi format output yang diminta dengan ketat." },
              { role: "user", content: promptAnalisis }
            ],
            temperature: 0.2
          })
        });

        if (!response.ok) throw new Error(`HTTP error ${response.status}`);
        const data = await response.json();
        const jawabanAI = data.choices[0].message.content;
        addMessageToChat('ai', `<b>Analisis untuk ${kandidat.nama}:</b><br>${jawabanAI}`);
      } catch (error) {
        console.error(`Gagal menganalisis ${kandidat.nama}:`, error);
        addMessageToChat('ai', `<strong>ERROR:</strong> Gagal menganalisis ${kandidat.nama}.`);
      }
    }

    addMessageToChat('ai', '✅ Analisis selesai!');
    sendButton.disabled = false;
  }

  sendButton.addEventListener('click', () => {
    const kebutuhan = userInput.value.trim();
    if (kebutuhan) { panggilAI(kebutuhan); }
    else { addMessageToChat('ai', 'Tolong ketik dulu apa yang Anda cari di kotak input.'); }
  });

  addMessageToChat('ai', 'Halo! Saya siap membantu. Silakan ketik kebutuhan spesifik Anda di bawah.');
});
</script>
</body>
</html>
