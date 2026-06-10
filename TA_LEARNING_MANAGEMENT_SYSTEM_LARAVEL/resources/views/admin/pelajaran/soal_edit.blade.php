@extends('admin.layouts.app')

@section('title', 'Edit Soal ')
@section('page_title', 'Edit Soal ')

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
            position: fixed;
            pointer-events: none;
            z-index: 9999;
            border: 2px dashed #696CFF;
            box-sizing: border-box;
            display: none;
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
            position: fixed;
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
        <form id="formSoal"
            action="{{ route('admin.pelajaran.judul_soal.soal.update', [$lesson->id, $exercise->id, $item->id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="selection" id="selectionInput">
            <input type="hidden" name="exercise_model_id" value="{{ $item->exercise_model_id }}">
            {{-- <input type="hidden" name="exercise_competence_id" value="{{ $item->exercise_competence_id }}"> --}}

            <div class="col-lg-12 col-md-12 bg-white p-3 shadow-sm mb-3 rounded">
                <h5 class="fw-bold mb-3 text-uppercase">Informasi Soal</h5>
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Tipe Soal</label>
                        <input type="text" class="form-control" value="{{ $exerciseType->name }}" readonly>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kompetensi (KD)</label>
                        <select class="form-select" name="competence_id">
                            <option value="">== Pilih Kompetensi ==</option>
                            @foreach ($competences as $competence)
                                <option value="{{ $competence->id }}"
                                    {{ $item->competence_id == $competence->id ? 'selected' : '' }}>
                                    {{ $competence->point }} - {{ $competence->description }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Model Soal</label>
                        <select class="form-select" name="exercise_model_id" disabled>
                            @foreach ($models as $model)
                                <option value="{{ $model->id }}"
                                    {{ $item->exercise_model_id == $model->id ? 'selected' : '' }}>
                                    {{ $model->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="exercise_choice" class="form-label fw-semibold">Jumlah Pilihan</label>
                        <select id="exercise_choice" name="exercise_choice" class="form-select" onchange="buatPilihan()"
                            disabled>
                            <option value="">== Pilih ==</option>
                            @foreach ([3, 4, 6, 8, 10] as $jumlah)
                                <option value="{{ $jumlah }}"
                                    {{ is_array($item->selection) && count($item->selection) == $jumlah ? 'selected' : '' }}>
                                    {{ $jumlah }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 mt-2">
                        <label class="form-label fw-semibold">Nomor Soal</label>
                        <input type="number" name="exercise_number" value="{{ $item->exercise_number }}"
                            class="form-control" min="1" required>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 col-md-12 bg-white p-3 shadow-sm rounded">
                <h5 class="fw-bold mb-3 text-uppercase">Isi Soal</h5>
                <div id="formArea"></div>

                <div class="mt-4 text-end">
                    <button type="submit" id="btnSimpan" class="btn btn-primary w-100">Update Soal</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Quill --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>


@endsection
@section('js')

    <script>
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
        let editors = [];

        function initImageResizer() {
            const overlay = document.createElement('div');
            overlay.id = 'img-resize-overlay';

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
                if (aH === 'bm' || (aH.includes('b') && !aH.includes('l') && !aH.includes('r')))
                    nh = Math.max(20, sh + dy);
                if (aH === 'tm' || (aH.includes('t') && !aH.includes('l') && !aH.includes('r')))
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

        function imageHandler() {

            const quill = this.quill;

            const input = document.createElement("input");
            input.type = "file";
            input.accept = "image/*";
            input.click();

            input.onchange = async () => {

                const file = input.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append("image", file);
                formData.append("_token", "{{ csrf_token() }}");

                const res = await fetch(
                    "{{ route('admin.pelajaran.judul_soal.soal.uploadImage', [$lesson->id, $exercise->id]) }}", {
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
               "{{ route('admin.pelajaran.judul_soal.soal.uploadImage', [$lesson->id, $exercise->id]) }}",
                { method: "POST", body: formData }
            );
            const data = await res.json();
            if (data.url) {
                const quill = editors.find(q => q.root === e.currentTarget);
                if (quill) {
                    const range = quill.getSelection(true) || { index: quill.getLength() };
                    quill.insertEmbed(range.index, "image", data.url);
                }
            }
            break;
        }
    }
}
        function createEditor(id, content = "", height = 200) {
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
                }
            });

            q.root.innerHTML = content || "";
            editors.push(q);
q.root.addEventListener('paste', handleImagePaste, true);
q.root.addEventListener('drop', handleImagePaste, true);
        }

        function loadExistingForm() {
            const model = {{ $item->exercise_model_id }};
            const area = document.getElementById("formArea");
            const selections = @json(is_array($item->selection) ? $item->selection : json_decode($item->selection ?? '[]', true));
            const answer = @json(is_array($item->answer) ? $item->answer : json_decode($item->answer ?? '[]', true));
            const question = `{!! $item->question !!}`;
            area.innerHTML = "";

            // --- MODEL PILIHAN GANDA / GANDA BANYAK ---
            if (model == 1 || model == 2) {
                let jumlah = selections.length;
                let html = `
            <label>Pertanyaan:</label>
            <div id="editorQuestion" class="border p-2 rounded"></div>
            <input type="hidden" name="question" id="hiddenQuestion">
            <h6 class="mt-3">Pilihan Jawaban</h6>
            <table class="table table-bordered text-center align-middle">
                <thead><tr><th>Abjad</th><th>Pilihan</th></tr></thead><tbody>`;
                for (let i = 0; i < jumlah; i++) {
                    const huruf = String.fromCharCode(65 + i);
                    html += `<tr><td class="fw-bold">${huruf}</td>
                <td><div id="opt${huruf}" class="border rounded p-2"></div></td></tr>`;
                }
                html += `</tbody></table>`;

                if (model == 1) {
                    html += `<label class="fw-semibold">Jawaban Benar:</label>
                <select id="answer" name="answer" class="form-select" required>`;
                    for (let i = 0; i < jumlah; i++) {
                        const huruf = String.fromCharCode(65 + i);
                        html +=
                            `<option value="${huruf}" ${(Array.isArray(answer) ? answer.includes(huruf) : answer == huruf) ? 'selected' : ''}>${huruf}</option>`;
                    }
                    html += `</select>`;
                } else {
                    html += `<label class="fw-semibold">Jawaban Benar:</label>
                <div class="d-flex flex-wrap gap-2">`;
                    for (let i = 0; i < jumlah; i++) {
                        const huruf = String.fromCharCode(65 + i);
                        html += `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="answer[]" value="${huruf}" id="ans${huruf}"
                        ${(Array.isArray(answer) && answer.includes(huruf)) ? 'checked' : ''}>
                        <label class="form-check-label" for="ans${huruf}">${huruf}</label>
                    </div>`;
                    }
                    html += `</div>`;
                }
                area.innerHTML = html;

                createEditor("editorQuestion", question);
                setTimeout(() => {
                    for (let i = 0; i < jumlah; i++) {
                        const huruf = String.fromCharCode(65 + i);
                        createEditor(`opt${huruf}`, selections[i] ?? "", 100);
                    }
                }, 200);

                // --- MODEL ISIAN ---
            } else if (model == 4) {
                area.innerHTML =
                    `
            <label>Pertanyaan:</label>
            <div id="editorQuestion" class="border p-2 rounded"></div>
            <input type="hidden" name="question" id="hiddenQuestion">
            <label class="mt-3">Jawaban:</label>
            <input type="text" name="answer" value="${answer ?? ''}" class="form-control" required autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false">`;
                createEditor("editorQuestion", question);

                // --- MODEL URAIAN / ARGUMEN ---
            } else if (model == 5 || model == 7) {
                area.innerHTML = `
            <label>Pertanyaan:</label>
            <div id="editorQuestion" class="border p-2 rounded"></div>
            <input type="hidden" name="question" id="hiddenQuestion">
            <label class="mt-3">${model == 5 ? 'Panduan Penilaian' : 'Argumen / Jawaban'}:</label>
            <div id="editorAnswer" class="border p-2 rounded"></div>
            <input type="hidden" name="answer" id="hiddenAnswer" required>`;
                createEditor("editorQuestion", question);
                createEditor("editorAnswer", answer ?? "");

                // --- MODEL IYA/TIDAK ---
            } else if (model == 6) {
                area.innerHTML = `
            <label>Pertanyaan:</label>
            <div id="editorQuestion" class="border p-2 rounded"></div>
            <input type="hidden" name="question" id="hiddenQuestion">
            <label class="mt-3">Jawaban:</label>
            <select id="answer" name="answer" class="form-select">
                <option value="Iya" ${(answer == "Iya") ? 'selected' : ''}>Iya</option>
                <option value="Tidak" ${(answer == "Tidak") ? 'selected' : ''}>Tidak</option>
            </select>`;
                createEditor("editorQuestion", question);

                // --- MODEL PERNYATAAN ---
            } else if (model == 3) {
                area.innerHTML = `
            <label>Pernyataan:</label>
            <div id="editorQuestion" class="border p-2 rounded"></div>
            <input type="hidden" name="question" id="hiddenQuestion">
            <label class="mt-3">Kunci Jawaban:</label>
            <select id="answer" name="answer" class="form-select">
                <option value="Benar" ${(answer == "Benar") ? 'selected' : ''}>Benar</option>
                <option value="Salah" ${(answer == "Salah") ? 'selected' : ''}>Salah</option>
            </select>`;
                createEditor("editorQuestion", question);
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            loadExistingForm();
            initImageResizer();
            document.getElementById('formSoal').addEventListener('submit', e => {
                const qEditor = editors.find(q => q.container.id === "editorQuestion");
                if (qEditor) document.getElementById("hiddenQuestion").value = qEditor.root.innerHTML
                    .trim();

                const aEditor = editors.find(q => q.container.id === "editorAnswer");
                if (aEditor && document.getElementById("hiddenAnswer"))
                    document.getElementById("hiddenAnswer").value = aEditor.root.innerHTML.trim();

                const selections = [];
                for (let q of editors) {
                    if (q.container.id.startsWith("opt")) selections.push(q.root.innerHTML.trim());
                }
                document.getElementById('selectionInput').value = JSON.stringify(selections);
            });
        });
    </script>
@endsection
