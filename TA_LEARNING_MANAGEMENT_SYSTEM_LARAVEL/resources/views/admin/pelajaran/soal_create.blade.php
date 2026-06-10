@extends('admin.layouts.app')

@section('title', 'Tambah Soal')
@section('page_title', 'Tambah Soal')

@section('content')
    <style>
        .ql-editor img {
            cursor: pointer;
            max-width: 100%;
        }

        .ql-editor img.img-selected {
            outline: 2px dashed #696CFF;
            outline-offset: 2px;
        }

        #img-resize-overlay {
            position: absolute;
            pointer-events: none;
            z-index: 9999;
            border: 2px dashed #696CFF;
            box-sizing: border-box;
        }

        .resize-handle {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #696CFF;
            border: 2px solid #fff;
            border-radius: 50%;
            pointer-events: all;
        }

        .resize-handle.tl {
            top: -6px;
            left: -6px;
            cursor: nwse-resize;
        }

        .resize-handle.tm {
            top: -6px;
            left: calc(50% - 5px);
            cursor: ns-resize;
        }

        .resize-handle.tr {
            top: -6px;
            right: -6px;
            cursor: nesw-resize;
        }

        .resize-handle.ml {
            top: calc(50% - 5px);
            left: -6px;
            cursor: ew-resize;
        }

        .resize-handle.mr {
            top: calc(50% - 5px);
            right: -6px;
            cursor: ew-resize;
        }

        .resize-handle.bl {
            bottom: -6px;
            left: -6px;
            cursor: nesw-resize;
        }

        .resize-handle.bm {
            bottom: -6px;
            left: calc(50% - 5px);
            cursor: ns-resize;
        }

        .resize-handle.br {
            bottom: -6px;
            right: -6px;
            cursor: nwse-resize;
        }

        #img-resize-toolbar {
            position: absolute;
            background: #212529;
            color: #fff;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 12px;
            display: none;
            gap: 8px;
            align-items: center;
            z-index: 10000;
            white-space: nowrap;
            box-shadow: 0 4px 16px rgba(0, 0, 0, .3);
        }

        #img-resize-toolbar input[type=number] {
            width: 54px;
            background: #343a40;
            color: #fff;
            border: 1px solid #6c757d;
            border-radius: 4px;
            padding: 2px 4px;
            font-size: 11px;
            text-align: center;
        }

        #img-resize-toolbar button {
            background: #495057;
            color: #fff;
            border: none;
            border-radius: 4px;
            padding: 2px 8px;
            font-size: 11px;
            cursor: pointer;
        }

        #img-resize-toolbar button:hover {
            background: #6c757d;
        }

        #img-resize-toolbar .btn-lock-on {
            background: #198754;
        }

        #img-resize-toolbar .btn-del {
            background: #dc3545;
        }
    </style>
    <div class="container-fluid">
        <form id="formSoal" action="{{ route('admin.pelajaran.judul_soal.soal.store', [$lesson_id, $exercise_id]) }}"
            method="POST">
            @csrf
            <input type="hidden" name="selection" id="selectionInput">
            <input type="hidden" id="exercise_id" name="exercise_id" value="{{ $exercise_id }}">
            <input type="hidden" id="exercise_type_id" name="exercise_type_id" value="{{ $exercise_type_id }}">


            <div class="col-lg-12 col-md-12 bg-white p-3 shadow-sm mb-3 rounded">
                <h5 class="fw-bold mb-3 text-uppercase ">Informasi Soal</h5>

                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Tipe Soal</label>
                        <input type="text" class="form-control " value="{{ $exerciseType->name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label for="competence_id" class="form-label fw-semibold">Kompetensi (KD)</label>
                        <select id="competence_id" name="competence_id" class="form-select">
                            <option value="">== Pilih Kompetensi ==</option>
                            @foreach ($competences as $competence)
                                <option value="{{ $competence->id }}">
                                    {{ $competence->point }} - {{ $competence->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="exercise_model_id" class="form-label fw-semibold">Model Soal</label>
                        <select id="exercise_model_id" name="exercise_model_id" class="form-select" onchange="loadForm()"
                            required>
                            <option value="">== Pilih ==</option>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}">{{ $model->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="exercise_choice" class="form-label fw-semibold">Jumlah Pilihan</label>
                        <select id="exercise_choice" name="exercise_choice" class="form-select" onchange="buatPilihan()">
                            <option value="">== Pilih ==</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 bg-white p-3 shadow-sm rounded">
                <h5 class="fw-bold mb-3 text-uppercase ">Isi Soal</h5>
                <div id="formArea">
                    <p class="text-muted fst-italic">
                        Pilih model soal terlebih dahulu untuk memulai input...
                    </p>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" id="btnSimpan" class="btn btn-primary w-100" disabled>
                        Simpan Soal
                    </button>
                </div>
            </div>
        </form>
    </div>
    {{-- Quill JS --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
@endsection
@section('js')
    <script>
        let editors = [];
        const toolbar = [
            [{
                font: []
            }, {
                size: []
            }],
            ["bold", "italic", "underline", "strike"],
            [{
                color: []
            }, {
                background: []
            }],
            [{
                list: "ordered"
            }, {
                list: "bullet"
            }],
            [{
                align: []
            }],
            ["image", "clean"]
        ];

        function initImageResizer() {
            const overlay = document.createElement('div');
            overlay.id = 'img-resize-overlay';
            overlay.style.display = 'none';
            overlay.style.position = 'fixed';

            ['tl', 'tm', 'tr', 'ml', 'mr', 'bl', 'bm', 'br'].forEach(pos => {
                const h = document.createElement('div');
                h.className = `resize-handle ${pos}`;
                h.dataset.pos = pos;
                overlay.appendChild(h);
            });

            const bar = document.createElement('div');
            bar.id = 'img-resize-toolbar';
            bar.innerHTML = `
        <span>W:<input type="number" id="rz-w" min="20"> px</span>
        <span>H:<input type="number" id="rz-h" min="20"> px</span>
        <button id="rz-lock">🔒 Rasio</button>
        <button id="rz-ori">Asli</button>
        <button class="btn-del" id="rz-del">Hapus</button>`;

            document.body.appendChild(overlay);
            document.body.appendChild(bar);

            let sel = null,
                locked = false,
                isDrag = false,
                aH = '';
            let sx, sy, sw, sh, natW = 0,
                natH = 0;

            function updatePos() {
                if (!sel) return;
                const r = sel.getBoundingClientRect();
                overlay.style.display = 'block';
                overlay.style.left = r.left + 'px';
                overlay.style.top = r.top + 'px';
                overlay.style.width = r.width + 'px';
                overlay.style.height = r.height + 'px';

                bar.style.display = 'flex';
                let bTop = r.top - 40;
                if (bTop < 4) bTop = r.bottom + 6;
                bar.style.top = bTop + 'px';
                bar.style.left = r.left + 'px';
                bar.style.position = 'fixed';

                document.getElementById('rz-w').value = Math.round(r.width);
                document.getElementById('rz-h').value = Math.round(r.height);
            }

            function deselect() {
                if (sel) sel.classList.remove('img-selected');
                sel = null;
                overlay.style.display = 'none';
                bar.style.display = 'none';
            }

            document.addEventListener('click', e => {
                if (e.target.tagName === 'IMG' && e.target.closest('.ql-editor')) {
                    if (sel) sel.classList.remove('img-selected');
                    sel = e.target;
                    sel.classList.add('img-selected');
                    natW = sel.naturalWidth || sel.offsetWidth;
                    natH = sel.naturalHeight || sel.offsetHeight;
                    updatePos();
                } else if (!overlay.contains(e.target) && !bar.contains(e.target)) {
                    deselect();
                }
            });

            overlay.addEventListener('mousedown', e => {
                if (!e.target.dataset.pos) return;
                e.preventDefault();
                isDrag = true;
                aH = e.target.dataset.pos;
                sx = e.clientX;
                sy = e.clientY;
                sw = sel.offsetWidth;
                sh = sel.offsetHeight;
            });

            document.addEventListener('mousemove', e => {
                if (!isDrag || !sel) return;
                const dx = e.clientX - sx,
                    dy = e.clientY - sy;
                const ratio = sh / sw;
                let nw = sw,
                    nh = sh;

                if (aH.includes('r')) nw = Math.max(20, sw + dx);
                if (aH.includes('l')) nw = Math.max(20, sw - dx);
                if ((aH === 'bm') || (aH.includes('b') && !aH.includes('l') && !aH.includes('r')))
                    nh = Math.max(20, sh + dy);
                if ((aH === 'tm') || (aH.includes('t') && !aH.includes('l') && !aH.includes('r')))
                    nh = Math.max(20, sh - dy);
                if (aH.includes('b') && (aH.includes('l') || aH.includes('r')))
                    nh = locked ? nw * ratio : Math.max(20, sh + dy);
                if (aH.includes('t') && (aH.includes('l') || aH.includes('r')))
                    nh = locked ? nw * ratio : Math.max(20, sh - dy);
                if ((aH === 'ml' || aH === 'mr') && locked) nh = nw * ratio;
                if (aH === 'bm' || aH === 'tm') nw = sw;

                sel.style.width = Math.round(nw) + 'px';
                sel.style.height = Math.round(nh) + 'px';
                updatePos();
            });

            document.addEventListener('mouseup', () => {
                isDrag = false;
            });

            document.getElementById('rz-w').addEventListener('change', function() {
                if (!sel) return;
                const w = Math.max(20, parseInt(this.value) || 20);
                sel.style.width = w + 'px';
                if (locked) sel.style.height = Math.round(w * sel.offsetHeight / sel.offsetWidth) + 'px';
                updatePos();
            });

            document.getElementById('rz-h').addEventListener('change', function() {
                if (!sel) return;
                const h = Math.max(20, parseInt(this.value) || 20);
                sel.style.height = h + 'px';
                if (locked) sel.style.width = Math.round(h * sel.offsetWidth / sel.offsetHeight) + 'px';
                updatePos();
            });

            document.getElementById('rz-lock').addEventListener('click', function() {
                locked = !locked;
                this.textContent = locked ? '🔒 Rasio ON' : '🔓 Rasio';
                this.className = locked ? 'btn-lock-on' : '';
            });

            document.getElementById('rz-ori').addEventListener('click', () => {
                if (!sel) return;
                sel.style.width = natW + 'px';
                sel.style.height = natH + 'px';
                updatePos();
            });

            document.getElementById('rz-del').addEventListener('click', () => {
                if (sel && confirm('Hapus gambar ini?')) {
                    sel.remove();
                    deselect();
                }
            });

            window.addEventListener('scroll', updatePos, true);
            window.addEventListener('resize', () => {
                if (sel) updatePos();
            });
        }

        // ✅ Aturan bisnis: type_id 4 (AKM) = semua model, selainnya = hanya model 1
        const exerciseTypeId = parseInt(document.getElementById('exercise_type_id').value);
        const allowedModels = exerciseTypeId === 4 ? [1, 2, 3, 4, 5, 6, 7] : [1];

        // ✅ Filter dropdown Model Soal saat halaman load
        document.addEventListener('DOMContentLoaded', function() {
            const modelSelect = document.getElementById('exercise_model_id');
            Array.from(modelSelect.options).forEach(option => {
                const val = parseInt(option.value);
                if (val && !allowedModels.includes(val)) {
                    option.remove();
                }
            });
            initImageResizer(); // ← tambahkan baris ini
        });

        function imageHandler() {
            const quill = this.quill;
            const input = document.createElement("input");
            input.setAttribute("type", "file");
            input.setAttribute("accept", "image/*");
            input.click();

            input.onchange = async () => {
                const file = input.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append("image", file);
                formData.append("_token", "{{ csrf_token() }}");

                const res = await fetch(
                    "{{ route('admin.pelajaran.judul_soal.soal.uploadImage', [$lesson_id, $exercise_id]) }}", {
                        method: "POST",
                        body: formData
                    }
                );

                const data = await res.json();
                if (data.url) {
                    const range = quill.getSelection(true);
                    quill.insertEmbed(range.index, "image", data.url);
                }
            };
        }
        async function handleImagePaste(e) {
            const items = (e.clipboardData || e.dataTransfer)?.items;
            if (!items) return;
            for (const item of items) {
                if (item.type.startsWith('image/')) {
                    e.preventDefault();
                    e.stopPropagation();
                    const file = item.getAsFile();
                    const formData = new FormData();
                    formData.append("image", file);
                    formData.append("_token", "{{ csrf_token() }}");
                    const res = await fetch(
                        "{{ route('admin.pelajaran.judul_soal.soal.uploadImage', [$lesson_id, $exercise_id]) }}", {
                            method: "POST",
                            body: formData
                        }
                    );
                    const data = await res.json();
                    if (data.url) {
                        const quill = editors.find(q => q.root === e.currentTarget);
                        if (quill) {
                            const range = quill.getSelection(true) || {
                                index: quill.getLength()
                            };
                            quill.insertEmbed(range.index, "image", data.url);
                        }
                    }
                    break;
                }
            }
        }

        function createEditor(id, height = 200) {
            const el = document.getElementById(id);
            if (!el) return;
            el.style.minHeight = height + "px";

            const q = new Quill("#" + id, {
                theme: "snow",
                modules: {
                    toolbar: {
                        container: toolbar,
                        handlers: {
                            image: imageHandler
                        }
                    }
                },
                placeholder: "Tulis pertanyaan atau pilihan..."
            });
            editors.push(q);
            q.root.addEventListener('paste', handleImagePaste, true);
            q.root.addEventListener('drop', handleImagePaste, true);
        }

        function resetEditors() {
            editors.forEach(e => {
                if (e && e.root) e.root.innerHTML = "";
            });
            editors = [];
        }

        function loadForm() {
            const modelSelect = document.getElementById("exercise_model_id");
            const model = modelSelect.value;
            const modelInt = parseInt(model);
            const area = document.getElementById("formArea");
            const choiceSelect = document.getElementById("exercise_choice");
            const btnSimpan = document.getElementById("btnSimpan");

            // ✅ Guard: tolak model yang tidak diizinkan
            if (model && !allowedModels.includes(modelInt)) {
                alert("Model soal ini tidak diizinkan untuk tipe soal ini.");
                modelSelect.value = "";
                btnSimpan.setAttribute("disabled", true);
                area.innerHTML =
                    "<p class='text-muted fst-italic'>Pilih model soal terlebih dahulu untuk memulai input...</p>";
                return;
            }

            // enable/disable tombol simpan
            if (modelInt >= 1 && modelInt <= 7) btnSimpan.removeAttribute("disabled");
            else btnSimpan.setAttribute("disabled", true);

            // enable/disable jumlah pilihan
            if (choiceSelect) {
                if (model == "1" || model == "2") choiceSelect.removeAttribute("disabled");
                else choiceSelect.setAttribute("disabled", true);
            }

            area.innerHTML = "";
            resetEditors();

            if (!model) {
                area.innerHTML =
                    "<p class='text-muted fst-italic'>Pilih model soal terlebih dahulu untuk memulai input...</p>";
                return;
            }

            let html = "";

            switch (model) {
                case "1":
                case "2":
                    html = `
                    <h5>Soal Pilihan Ganda${model == "2" ? " Banyak" : ""}</h5>
                    <label>Pertanyaan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <div id="pilihanArea" class="mt-3"></div>`;
                    break;
                case "3":
                    html = `
                    <h5>Soal Pernyataan</h5>
                    <label>Pernyataan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <label class="mt-3">Kunci Jawaban:</label>
                    <select id="answer" name="answer" class="form-select mt-1">
                        <option>Benar</option><option>Salah</option>
                    </select>`;
                    break;
                case "4":
                    html =
                        `
                    <h5>Soal Isian</h5>
                    <label>Pertanyaan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <label class="mt-3">Kunci Jawaban:</label>
                    <input type="text" id="answer" name="answer" class="form-control" placeholder="Isi jawaban benar" required autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">`;
                    break;
                case "5":
                    html = `
                    <h5>Soal Uraian</h5>
                    <label>Pertanyaan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <label class="mt-3">Panduan Penilaian:</label>
                    <div id="editorAnswer" class="border p-2 rounded"></div>
                    <input type="hidden" name="answer" id="hiddenAnswer" required>`;
                    break;
                case "6":
                    html = `
                    <h5>Soal Iya / Tidak</h5>
                    <label>Pertanyaan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <label class="mt-3">Jawaban:</label>
                    <select id="answer" name="answer" class="form-select mt-1">
                        <option>Iya</option><option>Tidak</option>
                    </select>`;
                    break;
                case "7":
                    html = `
                    <h5>Soal Argumen</h5>
                    <label>Pertanyaan:</label>
                    <div id="editorQuestion" class="border p-2 rounded"></div>
                    <input type="hidden" name="question" id="hiddenQuestion">
                    <input type="hidden" name="answer" id="hiddenAnswer" value="-">`;
                    break;
                default:
                    html = `
                    <div class="alert alert-warning text-center p-4 rounded">
                        <h5 class="fw-bold mb-2 text-danger">Model soal belum dibuat</h5>
                        <p class="mb-0">Silakan buat model soal untuk tipe ini terlebih dahulu.</p>
                    </div>`;
            }

            area.innerHTML = html;

            if (["1", "2", "3", "4", "5", "6", "7"].includes(model)) {
                createEditor("editorQuestion", 180);
                if (model == "1" || model == "2") buatPilihan();
                if (model == "5") createEditor("editorAnswer", 150);
            }
        }

        function buatPilihan() {
            const jumlah = parseInt(document.getElementById("exercise_choice").value);
            const model = document.getElementById("exercise_model_id").value;
            const area = document.getElementById("pilihanArea");
            if (!area) return;

            let html = `
            <h6 class="mt-3">Pilihan Jawaban</h6>
            <table class="table table-striped table-bordered table-hover align-middle text-center">
                <thead><tr><th>Abjad</th><th>Pilihan</th></tr></thead>
                <tbody>`;

            for (let i = 0; i < jumlah; i++) {
                const huruf = String.fromCharCode(65 + i);
                html += `
                <tr>
                    <td class="text-center fw-bold">${huruf}</td>
                    <td><div id="opt${huruf}" class="border rounded p-2"></div></td>
                </tr>`;
            }

            html += `</tbody></table><div class="mt-3">`;

            if (model == "1") {
                html += `<label class="form-label fw-semibold">Jawaban Benar:</label>
                         <select id="answer" name="answer" class="form-select" required>
                         <option value="">-- Pilih Jawaban Benar --</option>`;
                for (let i = 0; i < jumlah; i++) {
                    const huruf = String.fromCharCode(65 + i);
                    html += `<option value="${huruf}">${huruf}</option>`;
                }
                html += `</select>`;
            } else if (model == "2") {
                html += `<label class="form-label fw-semibold">Jawaban Benar:</label>
                         <div class="d-flex flex-wrap gap-2">`;
                for (let i = 0; i < jumlah; i++) {
                    const huruf = String.fromCharCode(65 + i);
                    html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="answer[]" value="${huruf}" id="ans${huruf}">
                        <label class="form-check-label" for="ans${huruf}">${huruf}</label>
                    </div>`;
                }
                html += `</div>`;
            }

            html += `</div>`;
            area.innerHTML = html;

            setTimeout(() => {
                for (let i = 0; i < jumlah; i++) {
                    const huruf = String.fromCharCode(65 + i);
                    createEditor(`opt${huruf}`, 100);
                }
            }, 300);
        }

        document.getElementById('formSoal').addEventListener('submit', function(e) {
            const btn = document.getElementById("btnSimpan");
            const originalText = btn.innerHTML;

            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';

            const qEditor = editors.find(q => q.container.id === "editorQuestion");
            if (qEditor) {
                const questionHTML = qEditor.root.innerHTML.trim();
                document.getElementById("hiddenQuestion").value = questionHTML;
                if (!questionHTML || questionHTML === "<p><br></p>") {
                    e.preventDefault();
                    alert("Pertanyaan wajib diisi sebelum disimpan!");
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    return false;
                }
            }

            const aEditor = editors.find(q => q.container.id === "editorAnswer");
            if (aEditor && document.getElementById("hiddenAnswer")) {
                const model = document.getElementById("exercise_model_id").value;
                const answerHTML = aEditor.root.innerHTML.trim();

                // Uraian (model 5): panduan penilaian wajib diisi
                if (model === "5" && (!answerHTML || answerHTML === "<p><br></p>")) {
                    e.preventDefault();
                    alert("Panduan penilaian wajib diisi untuk soal Uraian!");
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                    return false;
                }

                document.getElementById("hiddenAnswer").value = answerHTML;
            }

            const choiceInput = document.getElementById("exercise_choice");
            if (choiceInput && document.getElementById('selectionInput')) {
                const jumlah = parseInt(choiceInput.value);
                const selections = [];
                for (let i = 0; i < jumlah; i++) {
                    const huruf = String.fromCharCode(65 + i);
                    const editor = editors.find(q => q.container.id === `opt${huruf}`);
                    if (editor) selections.push(editor.root.innerHTML.trim());
                }
                document.getElementById('selectionInput').value = JSON.stringify(selections);
            }
        });
    </script>
@endsection
