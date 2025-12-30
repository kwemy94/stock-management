@extends('admin.layouts.app')

@section('dashboard-content')
    <div class="content mt-4">

        <!-- Titre centré -->
        <h3 class="text-center mb-4 fw-bold" style="font-weight: bold">
            Détails commande : {{ $commande->reference }}
        </h3>

        <div class="container d-flex justify-content-center">

            <div class="col-lg-9 col-md-10">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <!-- Informations fournisseur -->
                        <h5 class="mb-3 text-primary">Fournisseur</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th style="width: 200px">Nom</th>
                                <td>{{ $commande->supplier->name }}</td>
                            </tr>
                            <tr>
                                <th>Téléphone</th>
                                <td>{{ $commande->supplier->phone }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $commande->supplier->email ?? '—' }}</td>
                            </tr>
                        </table>

                        <!-- Informations commande -->
                        <h5 class="mt-4 mb-3 text-primary">Informations Commande</h5>
                        <table class="table table-sm table-bordered">
                            <tr>
                                <th style="width: 200px">Date </th>
                                <td>{{ $commande->date_command }}</td>
                            </tr>
                            <tr>
                                <th>Mode Paiement</th>
                                <td>{{ $commande->paymentMode->name ?? '—' }}</td>
                            </tr>
                            <tr>
                                <th>Statut</th>
                                <td>
                                    @if ($commande->status == 'validated')
                                        <span class="badge bg-success">Validée</span>
                                    @elseif ($commande->status == 'draft')
                                        <span class="badge bg-danger">Brouillon</span>
                                    @else
                                        <span class="badge bg-primary">Confirmée</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Montant Total</th>
                                <td><b>{{ number_format($commande->amount, 2, ',', ' ') }} FCFA</b></td>
                            </tr>
                            {{-- <tr>
                            <th>Montant Encaisse</th>
                            <td>{{ number_format($commande->montantEncaisse, 2, ',', ' ') }} FCFA</td>
                        </tr>
                        <tr>
                            <th>Montant Dû</th>
                            <td>{{ number_format($commande->montantDu, 2, ',', ' ') }} FCFA</td>
                        </tr> --}}
                        </table>

                        <!-- Lignes d'articles -->
                        <h5 class="mt-4 mb-3 text-primary">Articles</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>Article</th>
                                        <th>Description</th>
                                        <th>Qté</th>
                                        <th>Unité</th>
                                        <th>P.U</th>
                                        <th>Remise (%)</th>
                                        <th>Montant HT</th>
                                        <th>Taxe</th>
                                        <th>Total TTC</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($commande->purchaseOrderLines as $line)
                                        @php
                                            $montantHT =
                                                $line->quantity * $line->unit_price * (1 - $line->remise / 100);
                                            $taxe = $montantHT * ($line->taxe / 100);
                                            $ttc = $montantHT + $taxe;
                                        @endphp
                                        <tr>
                                            <td>{{ $line->product->product_name }}</td>
                                            <td>{{ $line->product->description ?? '' }}</td>
                                            <td>{{ $line->quantity }}</td>
                                            <td>{{ $line->product->unit_measure->name ?? '—' }}</td>
                                            <td>{{ number_format($line->unit_price, 0, ',', ' ') }}</td>
                                            <td>{{ $line->remise }}</td>
                                            <td>{{ number_format($montantHT, 0, ',', ' ') }}</td>
                                            <td>{{ number_format($taxe, 0, ',', ' ') }}</td>
                                            <td>{{ number_format($ttc, 0, ',', ' ') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Boutons -->
                        <div class="mt-4 text-end">
                            <a href="{{ route('buy-command-order.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Retour
                            </a>
                            @if ($commande->status == 'draft')
                                <a href="{{ route('confirm.command', $commande->id) }}" class="btn btn-success btn-sm"
                                    onclick="return confirm('Voulez-vous vraiment confirmer cette commande ?')">
                                    <i class=""></i> Confirmer
                                </a>
                                <a href="{{ route('buy-command-order.edit', $commande->id) }}" class="btn btn-primary btn-sm">
                                    <i class=""></i> Modifier
                                </a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
