@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <style>
        .action-card {
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
        }
    </style>
@endsection
@section('dashboard-content')
    <section class="content">
        <div class="row pt-2">

            <div class="col-md-6">
                <div class="card card-outline card-success">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-bolt text-success mr-1"></i>
                            Actions rapides
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Point de vente --}}
                            <div class="col-md-6 col-12 mb-3">
                                <a href="{{ route('order.create') }}" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-success">
                                            <i class="fas fa-cash-register"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Point de vente</span>
                                            <span class="info-box-number text-muted">Nouvelle vente</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{-- Factures POS --}}
                            <div class="col-md-6 col-12 mb-3">
                                <a href="{{ route('order.index') }}" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-primary">
                                            <i class="fas fa-file-invoice"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Factures POS</span>
                                            <span class="info-box-number text-muted">Liste & gestion</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{-- Statistiques --}}
                            <div class="col-md-6 col-12">
                                <a href="{{ route('order.rapport') }}" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-chart-line"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Statistiques</span>
                                            <span class="info-box-number text-muted">Rapports & ventes</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"> <span class="badge badge-primary right">{{ 'X1' }}</span>
                            Factures confirmées</h3>

                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link"
                                        href="{{ route('sale.invoice', [true]) }}">Plus</a>
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



        </div>

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
