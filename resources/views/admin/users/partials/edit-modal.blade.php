<div class="modal fade" id="editUserModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form method="POST">
            @csrf
            @method('PUT')

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-edit mr-1"></i> Modifier utilisateur
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom complet <em class="text-danger">*</em></label>
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
                                <label>Téléphone <em class="text-danger">*</em></label>
                                <input type="text" name="phone" class="form-control form-control-sm" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNI</label>
                                <input type="text" name="cni" class="form-control form-control-sm">
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Mettre à jour
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
