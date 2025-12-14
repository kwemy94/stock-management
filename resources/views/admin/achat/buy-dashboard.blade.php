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
                <div class="row">

                    {{-- Bon de commande --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="{{ route('buy-command-order.index') }}"
                            class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-file-alt fa-2x mb-2"></i>
                                <h6 class="card-title">BON DE COMMANDE</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Réception fournisseur --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="{{ route('buy-reception.index') }}" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-truck-loading fa-2x mb-2"></i>
                                <h6 class="card-title">RÉCEPTION FOURNISSEUR</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Mouvement de stock --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <h6 class="card-title">MOUVEMENT DE STOCK</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Inventaire --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-boxes fa-2x mb-2"></i>
                                <h6 class="card-title">INVENTAIRE</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Bon de réception --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-receipt fa-2x mb-2"></i>
                                <h6 class="card-title">BON DE RÉCEPTION</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Facture fournisseur --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-file-invoice fa-2x mb-2"></i>
                                <h6 class="card-title">FACTURE FOURNISSEUR</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Paiement --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-money-check-alt fa-2x mb-2"></i>
                                <h6 class="card-title">PAIEMENT</h6>
                            </div>
                        </a>
                    </div>

                    {{-- Rapport --}}
                    <div class="col-6 col-sm-6 col-md-6 mb-3">
                        <a href="#" class="card text-center text-decoration-none purchase-card">
                            <div class="card-body">
                                <i class="fas fa-chart-line fa-2x mb-2"></i>
                                <h6 class="card-title">RAPPORT</h6>
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
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th style="width: 10px">#</th> --}}
                                    <th>Numéro facture</th>
                                    <th>Date</th>
                                    {{-- <th>Montant</th> --}}
                                    <th>Montant encaissé</th>
                                    <th>Montant dû</th>
                                    <th style="width: 40px">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @forelse ($confirmInvoices->take(4) as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_number }}</td>
                                    <td>{{ $invoice->date }}</td>
                                    <td>{{ $invoice->montant_encaisse }}</td>
                                    <td>{{ $invoice->montant_du }}</td>
                                    <td><span
                                            class="badge bg-{{ $invoice->status == 'Payé' ? 'success' : 'primary' }}">{{ $invoice->status }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center">Aucune facture confirmée</td>
                                </tr>
                            @endforelse --}}
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
