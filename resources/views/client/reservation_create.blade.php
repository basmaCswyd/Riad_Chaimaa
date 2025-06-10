@extends('layouts.app')

@section('title', 'Réserver une Table')

@section('content')
<h2 class="page-title">Réserver Votre Table</h2>
<form class="form-elegant" id="reservationForm" action="{{ route('client.reservations.store') }}" method="POST" style="max-width: 700px;">
    @csrf
    <div class="form-section">
        <h3><i class="fas fa-calendar-day"></i> 1. Choisissez votre créneau</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div class="form-group">
                <label for="reservation_date">Date</label>
                <input type="date" id="reservation_date" name="reservation_date" value="{{ old('reservation_date', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="reservation_time">Heure</label>
                <select id="reservation_time" name="reservation_time" required>
                    <option value="">-- --:-- --</option>
                    <optgroup label="Midi">
                        <option value="12:00">12:00</option>
                        <option value="12:30">12:30</option>
                        <option value="13:00">13:00</option>
                        <option value="13:30">13:30</option>
                    </optgroup>
                    <optgroup label="Soir">
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                    </optgroup>
                </select>
            </div>
            <div class="form-group">
                <label for="guests">Nombre de personnes</label>
                <select id="guests" name="guests" required>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ $i }} personne{{ $i > 1 ? 's' : '' }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" id="checkAvailabilityBtn">Voir les tables disponibles</button>
    </div>

    <div class="form-section" id="tableSelectionSection" style="display:none; margin-top: 30px;">
        <h3><i class="fas fa-chair"></i> 2. Choisissez votre table</h3>
        <div id="tablesContainer" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px; margin-top: 10px;">
            {{-- Les tables disponibles seront injectées ici par JavaScript --}}
        </div>
        <input type="hidden" id="table_id" name="table_id" required>
    </div>
    
    <div class="form-actions" id="submitButtonContainer" style="display:none; margin-top: 30px;">
        <button type="submit" class="btn btn-full-width">Confirmer ma réservation</button>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const checkBtn = document.getElementById('checkAvailabilityBtn');
    const tableSection = document.getElementById('tableSelectionSection');
    const tablesContainer = document.getElementById('tablesContainer');
    const tableInput = document.getElementById('table_id');
    const submitContainer = document.getElementById('submitButtonContainer');
    const dateInput = document.getElementById('reservation_date');
    const timeInput = document.getElementById('reservation_time');
    const guestsInput = document.getElementById('guests');

    checkBtn.addEventListener('click', async () => {
        const date = dateInput.value;
        const time = timeInput.value;
        const guests = guestsInput.value;

        if (!date || !time || !guests) {
            alert('Veuillez remplir la date, l\'heure et le nombre de convives.');
            return;
        }

        tablesContainer.innerHTML = '<p>Recherche des tables disponibles...</p>';
        tableSection.style.display = 'block';
        submitContainer.style.display = 'none';
        tableInput.value = '';

        try {
            const response = await fetch(`{{ route('client.availability.check') }}?reservation_date=${date}&reservation_time=${time}&guests=${guests}`);
            
            if (!response.ok) {
                tablesContainer.innerHTML = '<p style="color:red; font-weight:bold;">Aucune table n\'est disponible pour ce créneau. Veuillez en essayer un autre.</p>';
                return;
            }

            const tables = await response.json();
            tablesContainer.innerHTML = '';

            if (tables.length === 0) {
                tablesContainer.innerHTML = '<p style="color:red; font-weight:bold;">Aucune table n\'est disponible pour ce créneau. Veuillez en essayer un autre.</p>';
                return;
            }

            tables.forEach(table => {
                const card = document.createElement('div');
                card.classList.add('table-card');
                card.innerHTML = `
                    <h4>${table.name}</h4>
                    <p>Zone: ${table.zone}</p>
                    <p>Capacité: ${table.capacity} personnes</p>
                `;
                card.onclick = () => {
                    document.querySelectorAll('.table-card.selected').forEach(c => c.classList.remove('selected'));
                    card.classList.add('selected');
                    tableInput.value = table.id;
                    submitContainer.style.display = 'block';
                };
                tablesContainer.appendChild(card);
            });
        } catch (error) {
            console.error('Erreur:', error);
            tablesContainer.innerHTML = '<p style="color:red;">Une erreur est survenue. Veuillez réessayer.</p>';
        }
    });
});
</script>
<style>
    .table-card { border: 2px solid #ddd; padding: 15px; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; }
    .table-card:hover { border-color: #a08569; background: #fdf8f3; }
    .table-card.selected { border-color: #8c6e4f; background: #fdf8f3; box-shadow: 0 0 10px rgba(140, 110, 79, 0.3); transform: scale(1.02); }
    .table-card h4 { margin: 0 0 5px 0; font-family: 'Playfair Display', serif; }
    .table-card p { margin: 0; font-size: 0.9rem; color: #555; }
</style>
@endpush