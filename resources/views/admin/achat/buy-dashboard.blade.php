@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <style>
        .purchase-card {
            background-color: #ffffff;
            border: 1px solid #e5e5e5;
            border-radius: 10px;
            color: #1f2d3d;
            transition: 0.2s;
            padding: 20px 0;
        }

        .purchase-card i {
            color: #0d6efd;
            transition: 0.2s;
        }

        .purchase-card .card-title {
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 5px;
        }

        .purchase-card:hover {
            background-color: #0d6efd;
            color: #ffffff;
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
            text-decoration: none;
        }

        .purchase-card:hover i {
            color: #ffffff;
        }

        @media (max-width: 576px) {
            .purchase-card .card-title {
                font-size: 0.75rem;
            }

            .purchase-card i {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection


@section('dashboard-content')
    <section class="content">
        <div class="row pt-2">

            <div class="col-md-6">
                <div class="row g-3">

                    {{-- Bon de commande --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('buy-command-order.index') }}"
                            class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                <div class="card-title">BON DE COMMANDE</div>
                            </div>
                        </a>
                    </div>

                    {{-- Réception fournisseur --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('buy-reception.index') }}"
                            class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-truck-loading fa-2x mb-2"></i>
                                <div class="card-title">RÉCEPTION</div>
                            </div>
                        </a>
                    </div>

                    {{-- Mouvement de stock --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="{{ route('listing.index') }}" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <div class="card-title">MOUVEMENT</div>
                            </div>
                        </a>
                    </div>

                    {{-- Inventaire --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <div class="card-title">INVENTAIRE</div>
                            </div>
                        </a>
                    </div>

                    {{-- Rapport --}}
                    <div class="col-6 col-md-4 col-lg-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <div class="card-title">RAPPORT</div>
                            </div>
                        </a>
                    </div>

                </div>

            </div>


            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <span class="badge badge-primary right">1</span> Factures confirmées</h3>

                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link" href="#">Plus</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th>Facture</th>
                                        <th class="d-none d-md-table-cell">Date</th>
                                        <th>Encaissé</th>
                                        <th class="d-none d-lg-table-cell">Dû</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">
                                            Aucune facture confirmée
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
