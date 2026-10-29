<div class="container my-5">
    <h2 class="text-center mb-4">Nuestros Locutores</h2>
    <div id="djsCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach($djs->chunk(4) as $chunk)
                <div class="carousel-item @if($loop->first) active @endif">
                    <div class="row">
                        @foreach($chunk as $dj)
                            <div class="col-md-3 text-center">
                                <img src="{{ asset('storage/' . $dj->photo_path) }}" class="rounded-circle mb-2" alt="{{ $dj->name }}" width="150" height="150" style="object-fit: cover;">
                                <h5>{{ $dj->name }}</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#djModal-{{ $dj->id }}">
                                    Ver Bio
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#djsCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#djsCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>

@foreach($djs as $dj)
<!-- Modal -->
<div class="modal fade" id="djModal-{{ $dj->id }}" tabindex="-1" aria-labelledby="djModalLabel-{{ $dj->id }}" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="djModalLabel-{{ $dj->id }}">{{ $dj->name }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img src="{{ asset('storage/' . $dj->photo_path) }}" class="rounded-circle mb-3 mx-auto d-block" alt="{{ $dj->name }}" width="150" height="150" style="object-fit: cover;">
        <p>{{ $dj->bio }}</p>
      </div>
    </div>
  </div>
</div>
@endforeach
