<div class="modal fade" id="createUserModal" tabindex="-1" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('users.store') }}" id="formUser">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-user-plus mr-1"></i> Nouvel utilisateur
                    </h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nom complet <em class="text-danger">*</em></label>
                                <input type="text" name="name" class="form-control form-control-sm required"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Email <em class="text-danger">*</em></label>
                                <input type="email" name="email" class="form-control form-control-sm required"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Téléphone <em class="text-danger">*</em></label>
                                <input type="text" name="phone" class="form-control form-control-sm required"
                                    required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>CNI</label>
                                <input type="text" name="cni" class="form-control form-control-sm">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Role</label>
                                <select name="role" class="form-control form-control-sm required">
                                    <option value="" selected disabled>Choisir un role</option>
                                    @foreach ($roles as $role)
                                        @if ($role->name == 'super-admin')
                                            @continue
                                        @endif
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if (auth()->user()->company->email == 'tigod2302@gmail.com')
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Etablissement <em class="text-danger">*</em></label>
                                    <select name="etablissement_id" class="form-control form-control-sm required">
                                        <option value="" selected disabled>Sélectionner la structure</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                        {{-- <div class="col-md-6">
                            <div class="form-group">
                                <label>Mot de passe <em class="text-danger">*</em></label>
                                <input type="password" name="password" class="form-control form-control-sm required" required>
                            </div>
                        </div> --}}

                    </div>

                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            Annuler
                        </button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnUserCreate">
                            Enregistrer
                        </button>
                    </div>
                </div>
        </form>
    </div>
</div>
