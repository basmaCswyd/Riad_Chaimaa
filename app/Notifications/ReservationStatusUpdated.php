<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationStatusUpdated extends Notification implements ShouldQueue // Implémente ShouldQueue pour envoyer en arrière-plan
{
    use Queueable;

    public Reservation $reservation;

    /**
     * Create a new notification instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // On veut envoyer par email ET stocker dans la base de données (pour la cloche de notif)
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $statusText = $this->reservation->status === 'confirmed' ? 'Confirmée' : 'Refusée';
        $subject = 'Mise à jour de votre réservation au Riad (#' . $this->reservation->id . ') : ' . $statusText;

        $mailMessage = (new MailMessage)
                    ->subject($subject)
                    ->greeting('Bonjour ' . $notifiable->prenom . ',')
                    ->line('Le statut de votre demande de réservation a été mis à jour.');

        if ($this->reservation->status === 'confirmed') {
            $mailMessage->line('Bonne nouvelle ! Votre réservation est confirmée pour le **' . $this->reservation->reservation_date->format('d/m/Y') . '** à **' . \Carbon\Carbon::parse($this->reservation->reservation_time)->format('H:i') . '**.')
                        ->line('Table assignée : ' . $this->reservation->table->name . ' (' . $this->reservation->table->zone . ')')
                        ->line('Nous avons hâte de vous accueillir.')
                        ->action('Voir mes réservations', url('/reservations'));
        } else { // Si 'refused'
            $mailMessage->line('Nous sommes au regret de vous informer que nous ne pouvons pas honorer votre demande de réservation pour le ' . $this->reservation->reservation_date->format('d/m/Y') . ' à ' . \Carbon\Carbon::parse($this->reservation->reservation_time)->format('H:i') . '.')
                        ->line('Cela est généralement dû à une forte demande. N\'hésitez pas à essayer un autre créneau.')
                        ->line($this->reservation->admin_notes ?? 'L\'équipe du Riad vous remercie de votre compréhension.') // Affiche les notes de l'admin si elles existent
                        ->action('Tenter une autre réservation', route('client.reservations.create'));
        }

        return $mailMessage->salutation('Cordialement, L\'équipe du Riad');
    }

    /**
     * Get the array representation of the notification. (Pour la base de données)
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $statusText = $this->reservation->status === 'confirmed' ? 'confirmée' : 'refusée';
        
        return [
            'reservation_id' => $this->reservation->id,
            'status' => $this->reservation->status,
            'message' => 'Votre réservation pour le ' . $this->reservation->reservation_date->format('d/m/Y') . ' a été ' . $statusText . '.',
            'url' => route('client.reservations.index'), // Lien vers la page des réservations
        ];
    }
}