@extends('admin.layouts.app')

@section('dashboard-content')
    @php $confEntreprise = getCompanyInfo(); @endphp

    <section class="content">
        <div class="container-fluid py-3">

            {{-- === Ligne 1 : Chiffre d’affaires === --}}
            <div class="row g-3">
                @foreach ([['label' => 'Vente du Jour', 'value' => $chiffreAffaire['ca_day'], 'color' => 'success', 'icon' => 'fa-shopping-cart'], ['label' => 'Vente de la Semaine', 'value' => $chiffreAffaire['ca_week'], 'color' => 'info', 'icon' => 'fa-calendar-week'], ['label' => 'Vente du Mois', 'value' => $chiffreAffaire['ca_month'], 'color' => 'primary', 'icon' => 'fa-calendar-alt'], ['label' => 'Vente Annuelle', 'value' => $chiffreAffaire['ca_year'], 'color' => 'warning', 'icon' => 'fa-coins']] as $item)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div
                                    class="p-3 rounded-circle bg-{{ $item['color'] }} bg-opacity-25 text-{{ $item['color'] }}">
                                    <i class="fas {{ $item['icon'] }} fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem;">
                                        {{ $item['label'] }}</h6>
                                    <h4 class="fw-bold mb-0">{{ number_format($item['value'], 0, ',', ' ') }}
                                        {{ $confEntreprise->devise ?? '' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- === Ligne 2 : Bénéfices === --}}
            <div class="row g-3 mt-2">
                @foreach ([['label' => 'Revenu Journalier', 'value' => $chiffreAffaire['benefice_day'], 'color' => 'success'], ['label' => 'Revenu Semaine', 'value' => $chiffreAffaire['benefice_week'], 'color' => 'info'], ['label' => 'Revenu Mois', 'value' => $chiffreAffaire['benefice_month'], 'color' => 'primary'], ['label' => 'Revenu Annuel', 'value' => $chiffreAffaire['benefice_year'], 'color' => 'warning']] as $rev)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card text-center border-0 shadow-sm bg-dark text-white">
                            <div class="card-body">
                                <h4 class="fw-bold">{{ number_format($rev['value'], 0, ',', ' ') }}
                                    {{ $confEntreprise->devise ?? '' }}</h4>
                                <p class="text-uppercase small mb-0 text-{{ $rev['color'] }}">{{ $rev['label'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- === Ligne 3 : Encaissements === --}}
            <div class="row g-3 mt-2">
                @foreach ([['label' => 'Encaissement du Jour', 'value' => $encaissements['totalDay'], 'color' => 'success', 'icon' => 'fa-wallet'], ['label' => 'Encaissement de la Semaine', 'value' => $encaissements['totalWeek'], 'color' => 'info', 'icon' => 'fa-calendar-week'], ['label' => 'Encaissement du Mois', 'value' => $encaissements['totalMonth'], 'color' => 'primary', 'icon' => 'fa-calendar-alt'], ['label' => 'Encaissement Annuel', 'value' => $encaissements['totalYear'], 'color' => 'warning', 'icon' => 'fa-coins']] as $enc)
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="card shadow-sm border-0">
                            <div class="card-body d-flex align-items-center">
                                <div
                                    class="p-3 rounded-circle bg-{{ $enc['color'] }} bg-opacity-25 text-{{ $enc['color'] }}">
                                    <i class="fas {{ $enc['icon'] }} fa-2x"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="text-muted mb-1 text-uppercase" style="font-size: 0.75rem;">
                                        {{ $enc['label'] }}</h6>
                                    <h4 class="fw-bold mb-0">{{ number_format($enc['value'], 0, ',', ' ') }}
                                        {{ $confEntreprise->devise ?? '' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>
@endsection
