@extends('admin.layouts.app')

@section('dashboard-content')
    @php
        $confEntreprise = getCompanyInfo();

        $statusClasses = [
            'draft' => 'danger',
            'confirmed' => 'primary',
            'proformat' => 'warning',
            'Payé' => 'success',
        ];
    @endphp

    <section class="content mt-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-9 col-md-10 col-sm-12">

                    {{-- ================= HEADER PRINCIPAL ================= --}}
                    <div class="card shadow-sm mb-1">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-center">

                            <div>
                                <h4 class="mb-1">
                                    Facture #{{ $invoice->invoice_number }}
                                    <span class="badge bg-{{ $statusClasses[$invoice->status] ?? 'secondary' }} ms-2">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </h4>
                                <small class="text-muted">
                                    Date : {{ $invoice->date }}
                                </small>
                            </div>

                            <div class="text-md-end mt-3 mt-md-0">
                                <h3 class="fw-bold text-danger mb-0">
                                    {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                    {{ $confEntreprise->devise }}
                                </h3>
                                <small class="text-muted">Reste à payer</small>
                            </div>

                        </div>
                    </div>

                    {{-- ================= RÉSUMÉ FINANCIER ================= --}}
                    <div class="row mb-1">
                        <div class="col-md-4 col-sm-6 mb-2">
                            <div class="info-box bg-light shadow-sm">
                                <span class="info-box-icon bg-primary">
                                    <i class="fas fa-file-invoice"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total TTC</span>
                                    <span class="info-box-number">
                                        {{ number_format($invoice->montant_facture, 0, ',', ' ') }}
                                        {{ $confEntreprise->devise }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-6 mb-2">
                            <div class="info-box bg-light shadow-sm">
                                <span class="info-box-icon bg-success">
                                    <i class="fas fa-check-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Montant encaissé</span>
                                    <span class="info-box-number">
                                        {{ number_format($invoice->montant_encaisse, 0, ',', ' ') }}
                                        {{ $confEntreprise->devise }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 mb-2">
                            <div class="info-box bg-light shadow-sm">
                                <span class="info-box-icon bg-danger">
                                    <i class="fas fa-exclamation-circle"></i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Reste dû</span>
                                    <span class="info-box-number">
                                        {{ number_format($invoice->montant_du, 0, ',', ' ') }}
                                        {{ $confEntreprise->devise }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= CLIENT / ENTREPRISE ================= --}}
                    <div class="row mb-1">
                        <div class="col-md-6 mb-2">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <small class="text-muted">Entreprise</small><br>
                                    <strong>{{ $confEntreprise->app_name }}</strong><br>
                                    {{ $confEntreprise->phone }}<br>
                                    {{ $confEntreprise->email }}
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-2">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body">
                                    <small class="text-muted">Client</small><br>
                                    <strong>{{ $invoice->customer->name }}</strong><br>
                                    {{ $invoice->customer->phone }}<br>
                                    {{ $invoice->customer->email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ================= TABLE PRODUITS ================= --}}
                    <div class="card shadow-sm mb-2">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-sm mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Produit</th>
                                            <th class="text-center">Qté</th>
                                            <th class="text-end">P.U</th>
                                            <th class="text-center">Remise</th>
                                            <th class="text-end">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->invoiceLines as $line)
                                            @php
                                                $total =
                                                    $line->quantity * $line->unit_price * (1 - $line->remise / 100);
                                            @endphp
                                            <tr>
                                                <td>{{ $line->product->product_name }}</td>
                                                <td class="text-center">{{ $line->quantity }}</td>
                                                <td class="text-end">
                                                    {{ number_format($line->unit_price, 0, ',', ' ') }}
                                                </td>
                                                <td class="text-center">{{ $line->remise }}%</td>
                                                <td class="text-end fw-bold">
                                                    {{ number_format($total, 0, ',', ' ') }}
                                                    {{ $confEntreprise->devise }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- ================= ACTION PRINCIPALE ================= --}}
                    <div class="text-end mb-5">
                        @switch($invoice->status)
                            @case('draft')
                                <a href="{{ route('sale.invoice.confirm', $invoice->id) }}" onclick="return confirmInvoice()"
                                    class="btn btn-primary btn-sm">
                                    <i class="fas fa-check"></i> Confirmer la commande
                                </a>
                            @break

                            @case('confirmed')
                                <button class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-pay"
                                    onclick="openPaymentModal({{ $invoice->id }}, {{ $invoice->montant_du }})">
                                    <i class="fas fa-money-bill-wave"></i> Encaisser le paiement
                                </button>
                            @break

                            @case('proformat')
                                <a href="{{ route('sale.invoice.confirm', $invoice->id) }}" onclick="return confirmProformat()"
                                    class="btn btn-warning btn-sm">
                                    <i class="fas fa-sync"></i> Convertir en commande
                                </a>
                            @break
                        @endswitch
                    </div>

                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal-pay" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">

                <form action="{{ route('sale.invoice.payment') }}" method="POST" id="pay-form">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-cash-register"></i> Encaissement facture
                        </h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label>Montant dû</label>
                                <input type="text" id="amount_du" class="form-control" readonly>
                                <input type="hidden" name="amount" value="{{ $invoice->montant_du }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Montant encaissé <span class="text-danger">*</span></label>
                                <input type="number" name="amount_encaisse" id="amount_encaisse"
                                    class="form-control required" min="0" step="0.01">
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Mode de paiement <span class="text-danger">*</span></label>
                                <select name="mode_id" class="form-control required">
                                    <option value="">-- Choisir --</option>
                                    @foreach ($paymentModes as $mode)
                                        <option value="{{ $mode->id }}">
                                            {{ $mode->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 mb-2">
                                <label>Date de paiement <span class="text-danger">*</span></label>
                                <input type="date" name="date_pay" class="form-control required"
                                    value="{{ date('Y-m-d') }}">
                            </div>
                        </div>

                        <input type="hidden" name="invoice_id" id="invoice_id">

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-success" id="save-pay">
                            Enregistrer le paiement
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection


@section('dashboard-js')
    <script>
        let montantInitial = 0;

        function openPaymentModal(invoiceId, montantDu) {
            montantInitial = parseFloat(montantDu) || 0;

            $('#invoice_id').val(invoiceId);
            $('#amount_du').val(montantInitial.toFixed(0));
            $('#amount_encaisse').val('');
        }

        $('#amount_encaisse').on('input', function() {
            let encaisse = parseFloat($(this).val()) || 0;
            let reste = montantInitial - encaisse;

            if (reste < 0) reste = 0;

            $('#amount_du').val(reste.toFixed(0));
        });

        $('#save-pay').click(function(e) {
            e.preventDefault();
            if (ControlRequiredFields()) {
                $('#pay-form').submit();
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
