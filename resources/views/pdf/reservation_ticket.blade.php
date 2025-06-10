<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Billet de Réservation #{{ $reservation->id }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif; /* Police compatible avec les caractères spéciaux */
            color: #333;
            line-height: 1.6;
        }
        .ticket-container {
            border: 2px solid #8c6e4f;
            padding: 25px;
            border-radius: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            font-family: 'DejaVu Serif', serif;
            color: #8c6e4f;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            margin: 0;
            font-size: 14px;
        }
        .content h2 {
            font-family: 'DejaVu Serif', serif;
            border-bottom: 2px solid #8c6e4f;
            padding-bottom: 5px;
            margin-bottom: 20px;
            font-size: 20px;
        }
        .details-grid {
            width: 100%;
        }
        .details-grid td {
            padding: 8px 0;
            font-size: 14px;
        }
        .details-grid .label {
            font-weight: bold;
            width: 150px;
        }
        .admin-notes {
            margin-top: 25px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
            padding: 15px;
            border-radius: 5px;
            font-size: 13px;
        }
        .admin-notes h3 {
            margin-top: 0;
            font-size: 16px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <h1>Riad</h1>
            <p>Billet de Confirmation de Réservation</p>
        </div>
        
        <div class="content">
            <h2>Votre réservation pour {{ $reservation->user->prenom }} {{ $reservation->user->nom }}</h2>
            
            <table class="details-grid">
                <tr>
                    <td class="label">Date :</td>
                    <td><strong>{{ $reservation->reservation_date->format('l d F Y') }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Heure :</td>
                    <td><strong>{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</strong></td>
                </tr>
                <tr>
                    <td class="label">Nombre de convives :</td>
                    <td><strong>{{ $reservation->guests }} personnes</strong></td>
                </tr>
                <tr>
                    <td class="label">Table assignée :</td>
                    <td><strong>{{ $reservation->table->name }} ({{ $reservation->table->zone }})</strong></td>
                </tr>
                 <tr>
                    <td class="label">Référence :</td>
                    <td>#RES-{{ str_pad($reservation->id, 6, '0', STR_PAD_LEFT) }}</td>
                </tr>
                <tr>
                    <td class="label">Client CIN :</td>
                    <td>{{ $reservation->user->cin }}</td>
                </tr>
            </table>

            {{-- C'est ici que l'on affiche les notes personnalisées de l'admin --}}
            @if($reservation->admin_notes)
                <div class="admin-notes">
                    <h3>Note de la part du restaurant :</h3>
                    <p>{!! nl2br(e($reservation->admin_notes)) !!}</p>
                </div>
            @endif
        </div>

        <div class="footer">
            <p>Merci de présenter ce billet (imprimé ou sur votre téléphone) à votre arrivée.</p>
            <p>Nous avons hâte de vous accueillir au Riad !</p>
        </div>
    </div>
</body>
</html>