<div class="contact-form container py-5" style="max-width: 600px;">
    @if($success)
        <div class="alert alert-success d-flex align-items-center" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <div>{{ $success ? '¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.' : '' }}</div>
        </div>
    @endif

    @if($error)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <div>{{ $error }}</div>
        </div>
    @endif

    <form wire:submit.prevent="submit" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre *</label>
            <input type="text" id="name" wire:model="name" placeholder="Tu nombre completo" class="form-control @error('name') is-invalid @enderror" />
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email *</label>
            <input type="email" id="email" wire:model="email" placeholder="tu@email.com" class="form-control @error('email') is-invalid @enderror" />
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="subject" class="form-label">Asunto *</label>
            <input type="text" id="subject" wire:model="subject" placeholder="Asunto del mensaje" class="form-control @error('subject') is-invalid @enderror" />
            @error('subject') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label for="message" class="form-label">Mensaje *</label>
            <textarea id="message" wire:model="message" rows="5" placeholder="Escribe tu mensaje aquí..." class="form-control @error('message') is-invalid @enderror"></textarea>
            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled">
            <span wire:loading.remove>Enviar Mensaje</span>
            <span wire:loading>Enviando...</span>
            <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>
    </form>
</div>
