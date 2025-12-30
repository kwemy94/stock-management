@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <style>
        .action-card {
            border-radius: 8px;
            transition: all 0.2s ease-in-out;
        }

        .action-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
@endsection
@section('dashboard-content')
    <section class="content">
        <div class="row pt-2">

            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-layer-group text-primary mr-1"></i>
                            Actions commerciales
                        </h3>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Facture client --}}
                            <div class="col-md-6 col-12 mb-3">
                                <a href="{{ route('sale.invoice.create', ['type' => 'facture']) }}" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-primary">
                                            <i class="fas fa-file-invoice-dollar"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Facture client</span>
                                            <span class="info-box-number text-muted">Créer une facture</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{-- Commande --}}
                            <div class="col-md-6 col-12 mb-3">
                                <a href="#" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-warning">
                                            <i class="fas fa-shopping-cart"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Commande</span>
                                            <span class="info-box-number text-muted">Nouvelle commande</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{-- Devis --}}
                            <div class="col-md-6 col-12 mb-3">
                                <a href="{{ route('sale.invoice.create', ['type' => 'proformat']) }}" class="text-dark">
                                    <div class="info-box shadow-sm action-card">
                                        <span class="info-box-icon bg-info">
                                            <i class="fas fa-file-alt"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Devis</span>
                                            <span class="info-box-number text-muted">Proforma client</span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            {{-- Rapport --}}
                            @can('view sales report')
                                <div class="col-md-6 col-12">
                                    <a href="{{ route('sale.invoice.rapport') }}" class="text-dark">
                                        <div class="info-box shadow-sm action-card">
                                            <span class="info-box-icon bg-success">
                                                <i class="fas fa-chart-pie"></i>
                                            </span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Rapports</span>
                                                <span class="info-box-number text-muted">Analyse & stats</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endcan

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    {{-- Header --}}
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title m-0">
                            <i class="fas fa-check-circle text-primary mr-1"></i>
                            Factures confirmées
                            <span class="badge badge-primary ml-2">
                                {{ count($confirmInvoices) }}
                            </span>
                        </h3>

                        <a href="{{ route('sale.invoice', [true]) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-arrow-right"></i> Voir tout
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Facture</th>
                                        <th>Date</th>
                                        <th class="text-right">Encaissé</th>
                                        <th class="text-right">Reste</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($confirmInvoices->take(4) as $invoice)
                                        <tr>
                                            <td>
                                                <strong>{{ $invoice->invoice_number }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-right text-success font-weight-bold">
                                                {{ number_format($invoice->montant_encaisse, 0, ',', ' ') }}
                                            </td>
                                            <td class="text-right text-danger">
                                                {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-{{ $invoice->status == 'Payé' ? 'success' : 'warning' }}">
                                                    {{ $invoice->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-folder-open mb-2 d-block"></i>
                                                Aucune facture confirmée
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card card-outline card-danger">
                    {{-- Header --}}
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title m-0">
                            <i class="fas fa-exclamation-circle text-danger mr-1"></i>
                            Factures ouvertes
                            <span class="badge badge-danger ml-2">
                                {{ count($draftInvoices) }}
                            </span>
                        </h3>

                        <a href="{{ route('sale.invoice', ['draft' => true]) }}" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-arrow-right"></i> Voir tout
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Facture</th>
                                        <th>Date</th>
                                        <th class="text-right">Encaissé</th>
                                        <th class="text-right">Reste</th>
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($draftInvoices->take(4) as $invoice)
                                        <tr>
                                            <td>
                                                <strong>{{ $invoice->invoice_number }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-right text-success font-weight-bold">
                                                {{ number_format($invoice->montant_encaisse, 0, ',', ' ') }}
                                            </td>
                                            <td class="text-right text-danger font-weight-bold">
                                                {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-danger">
                                                    {{ $invoice->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-folder-open mb-2 d-block"></i>
                                                Aucune facture ouverte
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    {{-- Header --}}
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h3 class="card-title m-0">
                            <i class="fas fa-file-signature text-warning mr-1"></i>
                            Factures proforma
                            <span class="badge badge-warning ml-2">
                                {{ count($devisInvoices) }}
                            </span>
                        </h3>

                        <a href="{{ route('sale.invoice', ['type' => 'proformat']) }}"
                            class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-arrow-right"></i> Voir tout
                        </a>
                    </div>

                    {{-- Table --}}
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-sm mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Proforma</th>
                                        <th>Date</th>
                                        <th class="text-right">Montant</th>
                                        {{-- <th class="text-right">Reste</th> --}}
                                        <th class="text-center">Statut</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($devisInvoices->take(4) as $invoice)
                                        <tr>
                                            <td>
                                                <strong>{{ $invoice->invoice_number }}</strong>
                                            </td>
                                            <td>
                                                <span class="text-muted">
                                                    {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}
                                                </span>
                                            </td>
                                            <td class="text-right font-weight-bold">
                                                {{ number_format($invoice->montant_facture, 0, ',', ' ') }}
                                            </td>
                                            {{-- <td class="text-right text-danger">
                                                {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                            </td> --}}
                                            <td class="text-center">
                                                <span class="badge badge-warning">
                                                    {{ $invoice->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-file-alt mb-2 d-block"></i>
                                                Aucun proforma disponible
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>



        </div>

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
