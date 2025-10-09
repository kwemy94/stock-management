@extends('admin.layouts.app')

@section('dashboard-content')
    @php
        $confEntreprise = getCompanyInfo();
    @endphp
    <section class="content mt-4">
        <div class="container-fluid">
            <div class="invoice p-3 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h4 class="text-center">
                            @switch($invoice->status)
                                @case('draft')
                                    <i class="fas fa-globe float-center"></i> Détails commande #{{ $invoice->invoice_number }}
                                    <span class="badge bg-danger">{{ $invoice->status }}</span>
                                @break

                                @case('confirmed')
                                    <i class="fas fa-globe float-center"></i> Détails facture #{{ $invoice->invoice_number }}
                                    <span class="badge bg-primary">{{ $invoice->status }}</span>
                                @break

                                @case('proformat')
                                    <i class="fas fa-globe float-center"></i> Détails dévis #{{ $invoice->invoice_number }}
                                    <span class="badge bg-warning">{{ $invoice->status }}</span>
                                @break

                                @case('Payé')
                                    <i class="fas fa-globe float-center"></i> Détails facture #{{ $invoice->invoice_number }}
                                    <span class="badge bg-success">{{ $invoice->status }}</span>
                                @break

                                @default
                            @endswitch
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <div class="row invoice-info">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>{{ $confEntreprise->app_name }}</strong><br>
                            Tél : {{ $confEntreprise->phone }}<br>
                            Email : {{ $confEntreprise->email }}<br>
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        To
                        <address>
                            <strong>{{ $invoice->customer->name }}</strong><br>
                            Tél: {{ $invoice->customer->phone }}<br>
                            Email: {{ $invoice->customer->email }}
                        </address>
                    </div>

                    <div class="col-sm-4 invoice-col">
                        <b>Invoice #{{ $invoice->invoice_number }}</b><br>
                        <b>Date:</b> {{ $invoice->date }}<br>
                        <i>Montant TTC : </i><b>{{ $invoice->montant_facture }}
                        </b><i>{{ $confEntreprise->devise }}</i><br>
                        <i>Montant Encaissé : </i><b>{{ $invoice->montant_encaisse }}
                        </b><i>{{ $confEntreprise->devise }}</i><br>
                        <i>Montant du : </i> <b>{{ $invoice->montant_du }} </b><i>{{ $confEntreprise->devise }}</i>
                    </div>

                </div>
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                    <th>P.U</th>
                                    <th>Remise</th>
                                    <th>Taxe</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->invoiceLines as $line)
                                    @php
                                        $total = $line->quantity * $line->unit_price * (1 - $line->remise / 100);
                                    @endphp
                                    <tr>
                                        <td>{{ $line->product->product_name }}</td>
                                        <td>{{ $line->quantity }}</td>
                                        <td>{{ $line->unit_price }}</td>
                                        <td>{{ $line->remise }}</td>
                                        <td>{{ $line->taxe }}</td>
                                        <td>{{ $total }} {{ $confEntreprise->devise }}</td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="row text-center">
                    <div class="col-12 d-flex justify-content-center">

                        @switch($invoice->status)
                            @case('draft')
                                <a href="{{ route('sale.invoice.confirm', $invoice->id) }}" onclick="return confirmInvoice()"
                                    class="btn btn-outline-primary" id="conf-cmd">Confirmer la commande</a>
                            @break

                            @case('confirmed')
                                <button data-target="#modal-pay" data-toggle="modal" class="btn btn-outline-success"
                                    id="pay-invoice">Payer cette facture</button>
                            @break

                            @case('proformat')
                                <a href="{{ route('sale.invoice.confirm', $invoice->id) }}" onclick="return confirmProformat()"
                                    class="btn btn-outline-primary" id="valid-proformat">Valider le
                                    proformat</a>
                            @break

                            @default
                        @endswitch
                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="modal-pay">
            <div class="modal-dialog">
                <div class="modal-content bg-white">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: flex; justify-content: center; align-items: center;">
                            Règlement facture {{ $invoice->invoice_number }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('sale.invoice.payment') }}" method="post" id="pay-form">
                        @csrf
                        <div class="modal-body">
                            <div class="row" style="display:flex;gap:10px">
                                <div class="form-group">
                                    <label for="name">{{ __('Montant dû') }}</label>
                                    <input type="text" readonly
                                        class="form-control form-control-border border-width-2 required" name="amount"
                                        id="amount_du" value="{{ $invoice->montant_du }}">
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ __('Montant encaissé') }}
                                        <em>*</em></label>
                                    <input type="text" class="form-control form-control-border border-width-2 required"
                                        name="amount_encaisse" id="amount_encaisse" value="{{ $invoice->montant_du }}">
                                </div>
                                <div class="form-group">
                                    <label for="mode">Mode de paiement <em>*</em></label>
                                    <select name="mode_id" class="custom-select form-control-border border-width-2 required"
                                        id="mode">
                                        <option value="" disabled selected>Mode de paiement
                                        </option>
                                        @forelse ($paymentModes as $mode)
                                            <option value="{{ $mode->id }}">{{ $mode->name }}
                                            </option>
                                        @empty
                                            <option value="" disabled>Aucun mode de paiement
                                                trouvé</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ __('Date de paiement') }}
                                        <em>*</em></label>
                                    <input type="date" class="form-control form-control-border border-width-2 required"
                                        name="date_pay" id="date_pay" value="{{ date('Y-m-d') }}">
                                </div>
                                <input type="hidden" name='invoice_id' id="invoice_id" value="{{ $invoice->id }}">


                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-outline-light" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-outline-success" id="save-pay">Enregistrer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('dashboard-js')
    <script>
        $('#save-pay').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#pay-form').submit()
            }
        });

        function confirmInvoice() {
            return confirm("Voulez-vous vraiment confirmer cette commande ?");
        }

        function confirmProformat() {
            return confirm("Voulez-vous vraiment valider ce devis ?");
        }
    </script>
@endsection
