@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
@endsection
@section('dashboard-content')
    {{-- <div class="content-wrapper"> --}}

    {{-- HEADER --}}
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Plans de licence</h1>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#planModal">
                    <i class="fas fa-plus"></i> Nouveau plan
                </button>
            </div>
        </div>
    </section>

    {{-- CONTENT --}}
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="row">

                @forelse($plans as $plan)
                    <div class="col-lg-4 col-md-6">
                        <div class="card card-outline card-primary shadow-sm h-100">
                            <div class="card-header bg-light">
                                <h5 class="card-title mb-0 font-weight-bold">
                                    {{ $plan->name }}
                                </h5>
                                <div class="card-tools">
                                    <span class="badge badge-info">
                                        {{ number_format($plan->price, 0, ',', ' ') }} FCFA
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                {{-- Durée --}}
                                <p class="text-muted mb-2">
                                    <i class="far fa-clock"></i>
                                    Durée : {{ $plan->duration_days }} jours
                                </p>

                                {{-- LIMITES --}}
                                <ul class="list-group list-group-flush mb-3">
                                    <li class="list-group-item px-0">
                                        <i class="fas fa-users text-primary"></i>
                                        Utilisateurs : {{ $plan->limits['users'] ?? 'Illimité' }}
                                    </li>
                                    <li class="list-group-item px-0">
                                        <i class="fas fa-box text-primary"></i>
                                        Produits : {{ $plan->limits['products'] ?? 'Illimité' }}
                                    </li>
                                </ul>

                                {{-- FEATURES --}}
                                <h6 class="text-muted mb-2">Fonctionnalités</h6>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($plan->features as $feature => $enabled)
                                        <li class="{{ $enabled ? 'text-dark' : 'text-muted' }}">
                                            <i
                                                class="fas {{ $enabled ? 'fa-check text-success' : 'fa-times text-danger' }}"></i>
                                            {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- ACTIONS --}}
                            <div class="card-footer bg-light text-right">
                                <div class="dropdown">
                                    <i class="fas fa-ellipsis-v text-primary" data-toggle="dropdown"
                                        style="cursor:pointer"></i>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <a class="dropdown-item text-danger" href="#">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light text-center">
                            Aucun plan disponible
                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </section>
    {{-- </div> --}}

    {{-- MODAL : CRÉATION PLAN --}}
    <div class="modal fade" id="planModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="{{ route('plans.store') }}" id="formPlan">
                @csrf
                <div class="modal-content">

                    <div class="modal-header bg-light">
                        <h5 class="modal-title">
                            <i class="fas fa-layer-group"></i> Nouveau plan
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">

                            {{-- Nom --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nom du plan <em class="color-danger">*</em></label>
                                    <input type="text" name="name" class="form-control required" required>
                                </div>
                            </div>

                            {{-- Prix --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Prix <em class="color-danger">*</em></label>
                                    <input type="number" name="price" class="form-control required" required>
                                </div>
                            </div>

                            {{-- Durée --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Durée (jours) <em class="color-danger">*</em></label>
                                    <input type="number" name="duration_days" class="form-control required" required>
                                </div>
                            </div>

                            {{-- LIMITES --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Limite utilisateurs <em class="color-danger">*</em></label>
                                    <input type="number" name="limits[users]" class="form-control required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Limite produits <em class="color-danger">*</em></label>
                                    <input type="number" name="limits[products]" class="form-control required">
                                </div>
                            </div>

                            {{-- FEATURES --}}
                            <div class="col-12">
                                <label>Fonctionnalités</label>
                                <div class="row">
                                    @foreach (['reports', 'multi_store', 'api_access'] as $feature)
                                        <div class="col-md-4">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="{{ $feature }}"
                                                    name="features[{{ $feature }}]" value="1">
                                                <label class="custom-control-label" for="{{ $feature }}">
                                                    {{ ucfirst(str_replace('_', ' ', $feature)) }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" id="btnSavePlan" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection

@section('dashboard-js')
    <script src="{{ asset('js/custom.js') }}"></script>

    <script>
        function deletePlan(id) {
            if (confirm('Voulez-vous supprimer ce plan de licence ?')) {
                document.getElementById('form-delete-plan-' + id).submit();
            }
        }

        $("#btnSavePlan").click(function(event) {
            event.preventDefault();
            if (!ControlRequiredFields($('#formPlan .required'))) {
                // alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            $("#formPlan").submit();
        });
    </script>
@endsection
