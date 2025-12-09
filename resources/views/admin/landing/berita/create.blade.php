@extends('layouts.admin')

@section('title', 'Tambah Berita')

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
    /* Trix Editor Modern Styling */
    trix-editor {
        min-height: 400px;
        max-height: 600px;
        overflow-y: auto;
        background: var(--bg-card);
        border: 2px solid var(--border-color);
        border-radius: 0 0 12px 12px;
        padding: 1rem;
        font-size: 1rem;
        line-height: 1.6;
        transition: border-color 0.3s ease;
    }
    
    trix-editor:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }
    
    trix-editor h1 {
        font-size: 2rem;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    trix-editor h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-top: 1.25rem;
        margin-bottom: 0.75rem;
    }
    
    trix-editor ul, trix-editor ol {
        padding-left: 2rem;
        margin: 1rem 0;
    }
    
    trix-editor blockquote {
        border-left: 4px solid var(--primary-color);
        padding-left: 1rem;
        margin: 1rem 0;
        color: #64748b;
        font-style: italic;
    }
    
    trix-editor pre {
        background: #f1f5f9;
        padding: 1rem;
        border-radius: 8px;
        overflow-x: auto;
        margin: 1rem 0;
    }
    
    trix-editor a {
        color: var(--primary-color);
        text-decoration: underline;
    }
    
    trix-toolbar {
        background: var(--bg-body);
        border: 2px solid var(--border-color);
        border-bottom: none;
        border-radius: 12px 12px 0 0;
        padding: 12px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    trix-toolbar .trix-button-row {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
    }
    
    trix-toolbar .trix-button-group {
        display: flex;
        gap: 2px;
        margin-right: 8px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 2px;
        background: var(--bg-card);
    }
    
    trix-toolbar .trix-button {
        background: transparent;
        border: none;
        border-radius: 6px;
        padding: 8px 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #64748b;
    }
    
    trix-toolbar .trix-button:hover {
        background: var(--primary-subtle);
        color: var(--primary-color);
    }
    
    trix-toolbar .trix-button.trix-active {
        background: var(--primary-color);
        color: white;
    }
    
    trix-toolbar .trix-button--icon::before {
        opacity: 0.8;
    }
    
    trix-toolbar .trix-button:hover::before,
    trix-toolbar .trix-button.trix-active::before {
        opacity: 1;
    }
    
    /* Hide file upload button for security */
    trix-toolbar .trix-button--icon-attach {
        display: none;
    }
    
    /* Dialogs */
    trix-toolbar .trix-dialog {
        background: var(--bg-card);
        border: 2px solid var(--border-color);
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    trix-toolbar .trix-dialog__link-fields input {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 8px 12px;
        font-size: 0.95rem;
    }
    
    trix-toolbar .trix-dialog__link-fields input:focus {
        outline: none;
        border-color: var(--primary-color);
    }
    
    /* Custom scrollbar for editor */
    trix-editor::-webkit-scrollbar {
        width: 8px;
    }
    
    trix-editor::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 4px;
    }
    
    trix-editor::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    
    trix-editor::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    
    /* Loading state */
    .trix-loading {
        opacity: 0.6;
        pointer-events: none;
    }
</style>
@endpush

@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Berita</h1>
            <p class="page-subtitle">Tambah berita atau artikel baru.</p>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.landing.berita.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Judul Berita <span class="text-danger">*</span></label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}" required>
                    @error('judul')
                        <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select name="kategori" class="form-control form-select" required>
                                <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                <option value="akademik" {{ old('kategori') == 'akademik' ? 'selected' : '' }}>Akademik</option>
                                <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                <option value="prestasi" {{ old('kategori') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*">
                            <small class="text-muted">Max 2MB. Format: JPG, PNG</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ringkasan</label>
                    <textarea name="ringkasan" class="form-control" rows="2" placeholder="Ringkasan singkat (opsional)">{{ old('ringkasan') }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Konten <span class="text-danger">*</span></label>
                    <input id="konten" type="hidden" name="konten" value="{{ old('konten') }}">
                    <trix-editor input="konten"></trix-editor>
                    @error('konten')
                        <div class="text-danger" style="font-size: 0.875rem; margin-top: 4px;">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-check form-switch">
                        <input type="checkbox" name="is_published" class="form-check-input" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <span>Publikasikan langsung</span>
                    </label>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Simpan</button>
                    <a href="{{ route('admin.landing.berita.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
    // Prevent Trix from auto-focusing
    document.addEventListener('trix-initialize', function(e) {
        e.target.blur();
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Disable file attachments for security
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
            alert('Upload file tidak diizinkan. Gunakan field Gambar di atas untuk upload gambar utama.');
        });
        
        // Add character counter
        const editor = document.querySelector('trix-editor');
        const form = editor.closest('form');
        
        // Create counter element
        const counter = document.createElement('div');
        counter.className = 'text-muted mt-2';
        counter.style.fontSize = '0.875rem';
        editor.parentElement.appendChild(counter);
        
        function updateCounter() {
            const text = editor.textContent.trim();
            const words = text.split(/\s+/).filter(word => word.length > 0).length;
            const chars = text.length;
            counter.textContent = `${words} kata, ${chars} karakter`;
        }
        
        editor.addEventListener('trix-change', updateCounter);
        updateCounter();
        
        // Prevent form submission if content is empty
        form.addEventListener('submit', function(e) {
            const content = editor.textContent.trim();
            if (content.length === 0) {
                e.preventDefault();
                alert('Konten berita tidak boleh kosong!');
                editor.focus();
                return false;
            }
        });
        
        // Auto-save to localStorage (optional)
        let autoSaveTimer;
        editor.addEventListener('trix-change', function() {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(function() {
                const content = document.getElementById('konten').value;
                localStorage.setItem('berita_draft', content);
                console.log('Draft auto-saved');
            }, 2000);
        });
        
        // Restore draft on page load
        const draft = localStorage.getItem('berita_draft');
        if (draft && !document.getElementById('konten').value) {
            if (confirm('Ditemukan draft yang belum tersimpan. Muat draft?')) {
                editor.editor.loadHTML(draft);
            }
        }
        
        // Clear draft on successful submit
        form.addEventListener('submit', function() {
            localStorage.removeItem('berita_draft');
        });
        
        // Keyboard shortcuts info
        console.log('Trix Editor Shortcuts:');
        console.log('Ctrl+B: Bold');
        console.log('Ctrl+I: Italic');
        console.log('Ctrl+U: Underline');
        console.log('Ctrl+K: Add Link');
        console.log('Ctrl+Z: Undo');
        console.log('Ctrl+Shift+Z: Redo');
    });
</script>
@endpush
