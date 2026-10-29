<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\ContactMessage;

class ContactForm extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';
    public $success = false;
    public $error = '';

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:1000',
    ];

    protected $messages = [
        'name.required' => 'El nombre es obligatorio.',
        'email.required' => 'El email es obligatorio.',
        'email.email' => 'El email debe tener un formato válido.',
        'subject.required' => 'El asunto es obligatorio.',
        'message.required' => 'El mensaje es obligatorio.',
    ];

    public function submit()
    {
        $this->validate();

        try {
            // Guardar en base de datos
            DB::table('contact_messages')->insert([
                'name' => $this->name,
                'email' => $this->email,
                'subject' => $this->subject,
                'message' => $this->message,
                'status' => 'new',
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Intentar enviar email (opcional, no bloqueante)
            try {
                Mail::to('admin@radioumachiri.com')
                    ->send(new ContactMessage([
                        'name' => $this->name,
                        'email' => $this->email,
                        'subject' => $this->subject,
                        'message' => $this->message
                    ]));
            } catch (\Exception $e) {
                // Logear error pero dejar pasar al usuario
                \Log::error('Error enviando email de contacto: ' . $e->getMessage());
            }

            $this->success = true;
            $this->reset(['name', 'email', 'subject', 'message']);
            $this->error = '';
            
        } catch (\Exception $e) {
            $this->error = 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.';
            $this->success = false;
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}