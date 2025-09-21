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
                            <a href="{{ route('sale.invoice.create', ['type' => 'facture']) }}" type="button"
                                class="btn btn-outline-primary btn-block btn-sm"><i class="fa fa-plus"></i> Facture
                                client</a>
                            <a href="#" type="button" class="btn btn-outline-primary btn-block btn-sm"><i
                                    class="fa fa-plus"></i> Commande</a>
                        </div>
                        <div class="col-md-6">
                            {{-- <button type="button" class="btn btn-outline-primary btn-block btn-sm"><i
                                    class="fa fa-book"></i> .btn-block .btn-flat</button> --}}
                            <a href="{{ route('sale.invoice.create', ['type' => 'proformat']) }}" type="button" class="btn btn-outline-primary btn-block btn-sm"><i
                                    class="fa fa-plus"></i> Devis</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Factures confirmées</h3>

                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link" href="{{ route('buy.invoice.create') }}">Plus</a>
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
                                    <th>Montant</th>
                                    <th>Montant encaissé</th>
                                    <th>Montant dû</th>
                                    <th style="width: 40px">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($confirmInvoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->date }}</td>
                                        <td>{{ $invoice->montant_facture }}</td>
                                        <td>{{ $invoice->montant_encaisse }}</td>
                                        <td>{{ $invoice->montant_du }}</td>
                                        <td><span class="badge bg-primary">{{ $invoice->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center">Aucune facture confirmée</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Factures ouvertes</h3>

                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link" href="{{ route('buy.invoice.create') }}">Plus</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Numéro facture</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    <th>Montant encaissé</th>
                                    <th>Montant dû</th>
                                    <th style="width: 40px">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($draftInvoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->date }}</td>
                                        <td>{{ $invoice->montant_facture }}</td>
                                        <td>{{ $invoice->montant_encaisse }}</td>
                                        <td>{{ $invoice->montant_du }}</td>
                                        <td><span class="badge bg-danger">{{ $invoice->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center">Aucune facture brouillon</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Factures proformat</h3>

                        <div class="card-tools">
                            <ul class="pagination pagination-sm float-right">
                                <li class="page-item"><a class="page-link" href="{{ route('buy.invoice.create') }}">Plus</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Numéro facture</th>
                                    <th>Date</th>
                                    <th>Montant</th>
                                    {{-- <th>Montant encaissé</th> --}}
                                    <th>Montant dû</th>
                                    <th style="width: 40px">Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($devisInvoices as $invoice)
                                    <tr>
                                        <td>{{ $invoice->invoice_number }}</td>
                                        <td>{{ $invoice->date }}</td>
                                        <td>{{ $invoice->montant_facture }}</td>
                                        {{-- <td>{{ $invoice->montant_encaisse }}</td> --}}
                                        <td>{{ $invoice->montant_du }}</td>
                                        <td><span class="badge bg-warning">{{ $invoice->status }}</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center">Aucun proformat disponible</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <div class="col-md-6">
                <div class="card card-secondary">
                    <div class="card-header">
                        <h3 class="card-title">Budget</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEstimatedBudget">Estimated budget</label>
                            <input type="number" id="inputEstimatedBudget" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputSpentBudget">Total amount spent</label>
                            <input type="number" id="inputSpentBudget" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="inputEstimatedDuration">Estimated project duration</label>
                            <input type="number" id="inputEstimatedDuration" class="form-control">
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

    </section>
@endsection

@section('dashboard-js')
    <script></script>
@endsection
