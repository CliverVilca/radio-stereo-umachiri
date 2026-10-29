@extends('layouts.app')

@section('title', $gallery->title . ' - Galería - Stereo Umachiri')
@section('description', Str::limit(strip_tags($gallery->description), 160))

@section('content')

{{-- ── HERO ── --}}
<div style="background:#0f172a;padding:3rem 0 2rem;position:relative;overflow:hidden;">
    @if($gallery->images && count($gallery->images) > 0)
        <div style="position:absolute;inset:0;z-index:0;">
            <img src="{{ asset('storage/'.$gallery->images[0]) }}" alt="{{ $gallery->title }}"
                 style="width:100%;height:100%;object-fit:cover;opacity:0.1;filter:blur(4px);transform:scale(1.05);">
        </div>
    @endif
    <div style="position:absolute;inset:0;background:rgba(15,23,42,0.85);z-index:1;"></div>
    <div class="container position-relative" style="z-index:2;">
        <nav aria-label="breadcrumb" class="mb-3">
            <ol class="breadcrumb mb-0" style="font-size:0.82rem;">
                <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('public.galleries.index') }}" class="text-white-50 text-decoration-none">Galería</a></li>
                <li class="breadcrumb-item active text-white">{{ Str::limit($gallery->title, 40) }}</li>
            </ol>
        </nav>
        <div class="d-flex align-items-start gap-3">
            <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:52px;height:52px;background:rgba(255,255,255,0.1);">
                <i class="fas fa-camera text-white fa-lg"></i>
            </div>
            <div>
                <h1 class="text-white fw-black mb-1" style="font-size:clamp(1.4rem,3.5vw,2.2rem);">{{ $gallery->title }}</h1>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    @if($gallery->images)
                        <span class="badge rounded-pill py-1 px-3" style="background:rgba(255,255,255,0.1);color:white;font-weight:600;">
                            <i class="fas fa-images me-1"></i>{{ count($gallery->images) }} fotos
                        </span>
                    @endif
                    <span class="badge rounded-pill py-1 px-3" style="background:rgba(255,255,255,0.1);color:white;font-weight:600;">
                        <i class="far fa-calendar me-1"></i>{{ $gallery->created_at->format('d/m/Y') }}
                    </span>
                    @if($gallery->is_featured)
                        <span class="badge rounded-pill py-1 px-3" style="background:#f59e0b;color:#1a1a1a;font-weight:700;">
                            <i class="fas fa-star me-1"></i>Destacada
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @if($gallery->description)
            <p class="text-white-50 mt-3 mb-0" style="max-width:700px;font-size:0.95rem;">{{ $gallery->description }}</p>
        @endif
    </div>
</div>

{{-- ── PHOTOS GRID ── --}}
<section style="background:#111;padding:2rem 0 3rem;">
    <div class="container">
        @if($gallery->images && count($gallery->images) > 0)
            <div class="row g-2 g-md-3">
                @foreach($gallery->images as $index => $image)
                    <div class="{{ $index === 0 ? 'col-12 col-md-8' : 'col-6 col-md-4' }}" style="{{ $index > 4 ? '' : '' }}">
                        <div class="gallery-thumb position-relative rounded-3 overflow-hidden"
                             style="height:{{ $index === 0 ? '340px' : '180px' }};cursor:pointer;background:#1a1a1a;"
                             onclick="openLightbox({{ $index }})">
                            <img src="{{ asset('storage/'.$image) }}"
                                 alt="{{ $gallery->title }} - Foto {{ $index+1 }}"
                                 class="gallery-grid-img"
                                 style="width:100%;height:100%;object-fit:cover;transition:transform 0.5s ease,opacity 0.3s ease;display:block;">
                            <div class="gallery-thumb-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                                 style="background:rgba(0,0,0,0.4);opacity:0;transition:opacity 0.3s ease;">
                                <i class="fas fa-search-plus fa-2x text-white"></i>
                            </div>
                            <div class="position-absolute bottom-0 end-0 m-2">
                                <span class="badge" style="background:rgba(0,0,0,0.6);font-size:0.68rem;">{{ $index+1 }}/{{ count($gallery->images) }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Share --}}
            <div class="d-flex align-items-center justify-content-between mt-4 flex-wrap gap-2">
                <a href="{{ route('public.galleries.index') }}" class="btn btn-sm rounded-pill px-4" style="background:rgba(255,255,255,0.1);color:white;border:1px solid rgba(255,255,255,0.2);font-weight:600;">
                    <i class="fas fa-arrow-left me-1"></i> Volver a Galerías
                </a>
                <div class="d-flex gap-2">
                    <small class="text-white-50 me-2 align-self-center">Compartir:</small>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                       target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold" style="background:#1877f2;color:white;">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($gallery->title.' '.request()->fullUrl()) }}"
                       target="_blank" class="btn btn-sm rounded-pill px-3 fw-semibold" style="background:#25d366;color:white;">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                <h5 class="text-white-50">No hay imágenes en esta galería aún.</h5>
            </div>
        @endif
    </div>
</section>

{{-- ── LIGHTBOX MODAL ── --}}
<div id="lightbox" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,0.97);align-items:center;justify-content:center;flex-direction:column;">
    <button onclick="closeLightbox()" style="position:absolute;top:1rem;right:1.5rem;background:none;border:none;color:white;font-size:2rem;cursor:pointer;z-index:2;">✕</button>

    {{-- Prev/Next --}}
    <button onclick="prevImage()" style="position:absolute;left:1rem;top:50%;transform:translateY(-50%);background:rgba(255,255,255,0.1);border:none;color:white;width:50px;height:50px;border-radius:50%;font-size:1.2rem;cursor:pointer;z-index:2;">‹</button>
    <button onclick="nextImage()" style="position:absolute;right:1rem;top:50%;transform:translateY(-50%);background:rgba(255,255,255,0.1);border:none;color:white;width:50px;height:50px;border-radius:50%;font-size:1.2rem;cursor:pointer;z-index:2;">›</button>

    <img id="lightboxImg" src="" alt="" style="max-width:90vw;max-height:85vh;object-fit:contain;border-radius:8px;">
    <div id="lightboxCounter" style="color:rgba(255,255,255,0.6);margin-top:1rem;font-size:0.9rem;"></div>
</div>

@push('scripts')
<script>
const images = @json(array_map(fn($img) => asset('storage/'.$img), $gallery->images ?? []));
let current = 0;

function openLightbox(index) {
    current = index;
    document.getElementById('lightbox').style.display = 'flex';
    document.body.style.overflow = 'hidden';
    updateLightbox();
}
function closeLightbox() {
    document.getElementById('lightbox').style.display = 'none';
    document.body.style.overflow = '';
}
function updateLightbox() {
    document.getElementById('lightboxImg').src = images[current];
    document.getElementById('lightboxCounter').textContent = (current+1) + ' / ' + images.length;
}
function prevImage() { current = (current - 1 + images.length) % images.length; updateLightbox(); }
function nextImage() { current = (current + 1) % images.length; updateLightbox(); }

document.addEventListener('keydown', e => {
    const lb = document.getElementById('lightbox');
    if(lb.style.display !== 'flex') return;
    if(e.key === 'ArrowLeft') prevImage();
    if(e.key === 'ArrowRight') nextImage();
    if(e.key === 'Escape') closeLightbox();
});
document.getElementById('lightbox').addEventListener('click', e => { if(e.target.id==='lightbox') closeLightbox(); });

document.querySelectorAll('.gallery-thumb').forEach(el => {
    const img = el.querySelector('.gallery-grid-img');
    const overlay = el.querySelector('.gallery-thumb-overlay');
    el.addEventListener('mouseenter', () => { if(img) img.style.transform='scale(1.06)'; if(overlay) overlay.style.opacity='1'; });
    el.addEventListener('mouseleave', () => { if(img) img.style.transform='scale(1)'; if(overlay) overlay.style.opacity='0'; });
});
</script>
@endpush

@endsection
