@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <link rel="stylesheet" href="{{ asset('css/customer.css') }}">
@endsection

@section('dashboard-content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Gestion des licences</h1>
                <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#licenseModal">
                    <i class="fas fa-plus"></i> Nouveau
                </button>
            </div>
        </div>
    </section>

    {{-- Content --}}
    <section class="content mt-3">
        <div class="container-fluid">
            <div class="card card-outline card-primary shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Entreprise</th>
                                <th>Plan</th>
                                <th>Clé</th>
                                <th>Expiration</th>
                                <th>Statut</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($licenses as $license)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $license->company->name }}</td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $license->plan->name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="license-key" data-key="{{ $license->license_key }}">
                                            ••••••••••••••••
                                        </span>

                                        <i class="fas fa-eye ml-2 text-primary toggle-license-key" style="cursor:pointer"
                                            title="Afficher / masquer"></i>
                                    </td>

                                    <td>
                                        {{ \Carbon\Carbon::parse($license->expires_at)->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @if ($license->status === 'active')
                                            <span class="badge badge-success">Active</span>
                                        @elseif($license->status === 'expired')
                                            <span class="badge badge-danger">Expirée</span>
                                        @else
                                            <span class="badge badge-warning">Suspendue</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <i class="fas fa-ellipsis-v text-primary" data-toggle="dropdown"
                                                style="cursor:pointer"></i>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                                <a class="dropdown-item" href="#">
                                                    <i class="fas fa-edit"></i> Modifier
                                                </a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item text-danger" href="#">
                                                    <i class="fas fa-trash"></i> Supprimer
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Aucune licence enregistrée
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-3">
                        {{ $licenses->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- </div> --}}

    {{-- MODAL : Nouvelle licence --}}
    <div class="modal fade" id="licenseModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <form method="POST" action="{{ route('licenses.store') }}" id="formLicence">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">
                            <i class="fas fa-key"></i> Nouvelle licence
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            {{-- Entreprise --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Entreprise <em class="color-danger">*</em></label>
                                    <select name="company_id" class="form-control required" required>
                                        <option value="">-- Sélectionner --</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Plan --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Plan <em class="color-danger">*</em></label>
                                    <select name="plan_id" class="form-control required" required>
                                        <option value="">-- Sélectionner --</option>
                                        @foreach ($plans as $plan)
                                            <option value="{{ $plan->id }}">
                                                {{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Date d'expiration --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Date d'expiration <em class="color-danger">*</em></label>
                                    <input type="date" name="expires_at" class="form-control required" required>
                                </div>
                            </div>

                            {{-- Statut --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Statut</label>
                                    <select name="status" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="expired">Expirée</option>
                                        <option value="suspended" selected>Suspendue</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" id="btnSaveLicence" class="btn btn-primary btn-sm">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    </section>
@endsection

@section('dashboard-js')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $("#btnSaveLicence").click(function(event) {
            event.preventDefault();
            if (!ControlRequiredFields($('#formLicence .required'))) {
                // alert('Veuillez remplir tous les champs obligatoires.');
                return;
            }
            $("#formLicence").submit();
        });
    </script>

    <script>
        document.querySelectorAll('.toggle-license-key').forEach(icon => {
            icon.addEventListener('click', function() {

                document.querySelectorAll('.license-key').forEach(span => {
                    span.textContent = '•••••••••••••••';
                });

                document.querySelectorAll('.toggle-license-key').forEach(i => {
                    i.classList.remove('fa-eye-slash');
                    i.classList.add('fa-eye');
                });

                const keySpan = this.previousElementSibling;
                keySpan.textContent = keySpan.dataset.key;
                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');
            });
        });
    </script>
@endsection
