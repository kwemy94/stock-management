<div class="modal fade" id="createEtablissementModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <form method="POST" action="{{ route('etablissements.store') }}" id="formEtablissement">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-building mr-1"></i> Nouvel établissement
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    {{-- Identité --}}
                    <h6 class="text-primary mb-2">Informations générales</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom de l’établissement <em class="text-danger">*</em></label>
                                <input type="text" name="name" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <em class="text-danger">*</em></label>
                                <input type="email" name="email" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Téléphone</label>
                                <input type="text" name="phone" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Activité</label>
                                <input type="text" name="activity" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Localisation --}}
                    <h6 class="text-primary mt-3 mb-2">Localisation</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Pays</label>
                                <input type="text" name="country" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Région</label>
                                <input type="text" name="region" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Ville</label>
                                <input type="text" name="city" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Adresse</label>
                                <input type="text" name="address" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Boîte postale</label>
                                <input type="text" name="postal_box" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Infos légales --}}
                    <h6 class="text-primary mt-3 mb-2">Informations légales</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Numéro contribuable</label>
                                <input type="text" name="taxpayer_number" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Registre de commerce</label>
                                <input type="text" name="trade_register_number" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>

                    {{-- Web --}}
                    <h6 class="text-primary mt-3 mb-2">Présence en ligne</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Domaine</label>
                                <input type="text" name="domain" class="form-control form-control-sm">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Site web</label>
                                <input type="text" name="website" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Enregistrer
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
