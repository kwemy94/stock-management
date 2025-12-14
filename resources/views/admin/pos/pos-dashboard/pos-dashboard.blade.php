@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content">
        <div class="row pt-2">

            <div class="col-md-6">
                <!-- Buttons with Icons -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions rapides</h3>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-6">
                            <a href="{{ route('order.create') }}" type="button"
                                class="btn btn-outline-success btn-block btn-sm"><i class="fas fa-money-bill"></i> Point de vente</a>
                            <a href="{{ route('order.index') }}" type="button" class="btn btn-outline-success btn-block btn-sm"><i
                                    class="fa fa-plus"></i> Factures POS </a>
                        </div>
                        <div class="col-md-6">
                            {{-- <button type="button" class="btn btn-outline-primary btn-block btn-sm"><i
                                    class="fa fa-book"></i> .btn-block .btn-flat</button> --}}
                            {{-- <a href="{{ route('sale.invoice.create', ['type' => 'proformat']) }}" type="button"
                                class="btn btn-outline-primary btn-block btn-sm"><i class="fa fa-plus"></i> Devis</a> --}}
                            <a href="{{ route('order.rapport') }}" type="button"
                                class="btn btn-outline-success btn-block btn-sm"><i class="fa fa-plus"></i> Statistiques</a>
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
