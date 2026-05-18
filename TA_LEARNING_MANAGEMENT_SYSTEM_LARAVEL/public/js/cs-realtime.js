//  FILE : public/js/cs-realtime.js

import { initializeApp } from "https://www.gstatic.com/firebasejs/10.12.2/firebase-app.js";
import {
    getDatabase,
    ref,
    push,
    onChildAdded,
    query,
    orderByChild,
    serverTimestamp,
} from "https://www.gstatic.com/firebasejs/10.12.2/firebase-database.js";

//  INIT FIREBASE
const app = initializeApp(window.FirebaseConfig);
const db = getDatabase(app);

//  DOM ELEMENTS
const chatBox = document.getElementById("chatBox");
const roomId = document.getElementById("roomId").value;
const sender = document.getElementById("sender").value;
const msgInput = document.getElementById("msgInput");
const sendForm = document.getElementById("sendForm");
const statusLogin = document.getElementById("status_login")?.value || "Umum";
const currentUser = document.getElementById("currentUser").value;

// ==============================
// 🔊 SUARA NOTIFIKASI
// ── Flag: skip pesan lama saat halaman pertama dibuka
// ── Flag: tunggu user berinteraksi dulu (syarat autoplay browser)
// ==============================
let isInitialLoad = true;
let userHasInteracted = false;

setTimeout(() => {
    isInitialLoad = false;
}, 2000);

document.addEventListener(
    "click",
    () => {
        userHasInteracted = true;
    },
    { once: true },
);
document.addEventListener(
    "keydown",
    () => {
        userHasInteracted = true;
    },
    { once: true },
);

// ==============================
// FUNGSI: Tampilkan Bubble Pesan
// ==============================
function addMessageBubble(data) {
    if (!data) return;

    let bubbleClass = "";

    const senderName = data.sender || "Unknown";
    const messageType = data.type || "text";

    const senderLower = senderName.toLowerCase();
    const currentLower = currentUser.toLowerCase();
    const myLower = sender.toLowerCase();

    // apakah login admin?
    const isAdminLogin = myLower.startsWith("admin");

    // sistem tetap tengah
    if (senderLower === "sistem") {
        bubbleClass = "bubble-system";
    }
    // pesan dari diri sendiri → kanan
    else if (senderLower === currentLower) {
        bubbleClass = "bubble-me";
    }
    // login admin & pesan dari AI → kanan
    else if (isAdminLogin && senderLower === "chatbot") {
        bubbleClass = "bubble-me";
    } else {
        bubbleClass = "bubble-other";
    }

    const wrapper = document.createElement("div");
    wrapper.classList.add(bubbleClass);

    let bubbleContent = "";

    if (messageType === "image" && data.image_url) {
        bubbleContent = `
            <div class="bubble-text image-bubble"
                 style="cursor:pointer;"
                 onclick="previewImage('${data.image_url}')">
                🖼 Gambar
            </div>
        `;
    } else {
        const formattedMessage = (data.message || "").replace(/\n/g, "<br>");
        bubbleContent = `<div class="bubble-text">${formattedMessage}</div>`;
    }

    wrapper.innerHTML = `
        ${bubbleClass !== "bubble-system" ? `<div class="sender-name">${senderName}</div>` : ""}
        ${bubbleContent}
        ${bubbleClass !== "bubble-system" ? `<div class="bubble-time">${data.full_time || data.time || ""}</div>` : ""}
    `;

    chatBox.appendChild(wrapper);
    chatBox.scrollTop = chatBox.scrollHeight;
}

// ==============================
// LISTENER: Pesan masuk (Firebase)
// ==============================
const msgRef = query(
    ref(db, `cs_rooms/${roomId}/messages`),
    orderByChild("ts"),
);

onChildAdded(msgRef, (snap) => {
    const data = snap.val();
    if (!data) return;

    // 🔊 Bunyi HANYA jika semua kondisi terpenuhi:
    // 1. Bukan pesan lama (history saat halaman baru dibuka)
    // 2. Bukan pesan dari diri sendiri
    // 3. Bukan pesan sistem
    // 4. User sudah pernah klik/ketik (syarat autoplay browser)
    const isFromMe = (data.sender || "").toLowerCase() === sender.toLowerCase();
    const isSistem = (data.sender || "").toLowerCase() === "sistem";

    if (!isInitialLoad && !isFromMe && !isSistem && userHasInteracted) {
        const audio = new Audio("/sounds/notif.mp3");
        audio.play().catch(() => {});
    }

    addMessageBubble(data);
});

// ==============================
// TYPING INDICATOR
// ==============================
let typingElement = null;

function showTyping() {
    if (typingElement) return;

    typingElement = document.createElement("div");
    typingElement.classList.add("bubble-other");
    typingElement.innerHTML = `
        <div class="sender-name">ChatBot</div>
        <div class="bubble-text">
            <i class="bi bi-three-dots"></i> Berpikir harap tunggu
            <br>
            <small style="color:#888;">
                Jangan refresh halaman, karena dapat menyebabkan proses terhenti dan pesan balasan tidak terkirim.
            </small>
        </div>
    `;

    chatBox.appendChild(typingElement);
    chatBox.scrollTop = chatBox.scrollHeight;
}

function hideTyping() {
    if (!typingElement) return;
    typingElement.remove();
    typingElement = null;
}

// ==============================
// KIRIM PESAN
// ==============================
let isSending = false;

if (sendForm) {
    sendForm.addEventListener("submit", async (e) => {
        e.preventDefault();

        if (isSending) return;
        isSending = true;

        const message = msgInput.value.trim();
        if (!message) {
            isSending = false;
            return;
        }

        const fullTime = () =>
            new Date()
                .toLocaleString("sv-SE", {
                    year: "numeric",
                    month: "2-digit",
                    day: "2-digit",
                    hour: "2-digit",
                    minute: "2-digit",
                    second: "2-digit",
                })
                .replace("T", " ");

        try {
            await push(ref(db, `cs_rooms/${roomId}/messages`), {
                id: "msg_" + Date.now(),
                sender,
                type: "text",
                message,
                full_time: fullTime(),
                ts: serverTimestamp(),
            });

            msgInput.value = "";

            if (window.ChatRoomConfig?.status === "ChatBot") {
                showTyping();

                try {
                    const response = await fetch(
                        window.ChatRoomConfig.webhook.url,
                        {
                            method: "POST",
                            headers: { "Content-Type": "application/json" },
                            body: JSON.stringify({
                                room_id: roomId,
                                message,
                                status_login: statusLogin,
                                sender,
                            }),
                        },
                    );

                    const resData = await response.json();
                    const aiReply =
                        resData.output ||
                        "🙇Maaf, terjadi kendala pada sistem sehingga jawaban belum dapat ditampilkan. Silakan coba beberapa saat lagi atau hubungi admin agar mendapatkan bantuan lebih cepat.";

                    hideTyping();

                    await push(ref(db, `cs_rooms/${roomId}/messages`), {
                        id: "ai_" + Date.now(),
                        sender: "ChatBot",
                        type: "text",
                        message: aiReply,
                        full_time: fullTime(),
                        ts: serverTimestamp(),
                    });
                } catch (err) {
                    hideTyping();

                    await push(ref(db, `cs_rooms/${roomId}/messages`), {
                        id: "ai_error_" + Date.now(),
                        sender: "Sistem",
                        type: "text",
                        message:
                            "ChatBot tidak terhubung. Silakan refresh halaman dan coba lagi.",
                        full_time: fullTime(),
                        ts: serverTimestamp(),
                    });
                }
            }
        } catch (err) {
            console.error(err);

            await push(ref(db, `cs_rooms/${roomId}/messages`), {
                id: "ai_error_" + Date.now(),
                sender: "Sistem",
                type: "text",
                message: "Terjadi kesalahan.",
                full_time: new Date()
                    .toLocaleString("sv-SE", {
                        year: "numeric",
                        month: "2-digit",
                        day: "2-digit",
                        hour: "2-digit",
                        minute: "2-digit",
                        second: "2-digit",
                    })
                    .replace("T", " "),
                ts: serverTimestamp(),
            });
        }

        isSending = false;
    });
}

// ==============================
// RENDER FILE
// ==============================
export function renderFile(file) {
    const isImage = ["jpg", "jpeg", "png", "gif", "webp"].includes(file.ext);

    return `
        <div class="col-4">
            <div class="file-item border rounded p-1 text-center">
                ${
                    isImage
                        ? `<div class="file-thumb">
                               <img src="${file.url}" class="thumb-img"
                                    onclick="previewImage('${file.url}')">
                           </div>`
                        : `<div class="file-thumb d-flex align-items-center justify-content-center">
                               <i class="bi bi-file-earmark-text" style="font-size:32px;"></i>
                           </div>`
                }
                <div class="file-name text-truncate mt-1" title="${file.name}">
                    ${file.name}
                </div>
            </div>
        </div>
    `;
}

// ==============================
// LOAD FILE LIST
// ==============================
export function loadFiles(roomId = null, endpoint = null, containerId = null) {
    if (!roomId || !endpoint || !containerId) return;

    const container = document.getElementById(containerId);
    if (!container) return;

    fetch(`${endpoint}/${roomId}`)
        .then((res) => res.json())
        .then((res) => {
            container.innerHTML = "";

            if (!res.success || !res.files || res.files.length === 0) {
                container.innerHTML = `<div class="text-center text-muted">Belum ada file</div>`;
                return;
            }

            res.files.forEach((f) => {
                container.innerHTML += renderFile(f);
            });
        })
        .catch(() => {
            container.innerHTML = `<div class="text-center text-danger">Gagal memuat file</div>`;
        });
}

// ==============================
// REALTIME POLLING (opsional)
// ==============================
export function enableRealtime(roomId, endpoint, targetId) {
    setInterval(() => {
        loadFiles(roomId, endpoint, targetId);
    }, 2000);
}

// ==============================
// GLOBAL PREVIEW GAMBAR
// ==============================
window.previewImage = function (src) {
    document.getElementById("modalPreviewImg").src = src;
    new bootstrap.Modal(document.getElementById("imagePreviewModal")).show();
};
