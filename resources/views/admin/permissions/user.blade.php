@extends('admin.layouts.app')


@section('dashboard-datatable-css')
    <style>
        .permission-item label {
            cursor: pointer;
            font-size: 0.95rem;
        }

        .card-header {
            min-height: 56px;
        }

        .sticky-bottom {
            position: sticky;
            bottom: 0;
            z-index: 10;
        }
    </style>
@endsection
@section('dashboard-content')
    <section class="content pt-3">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                <h5 class="mb-2 mb-md-0">
                    <i class="fas fa-user-shield text-primary mr-1"></i>
                    Permissions de l’utilisateur :
                    <strong>{{ $user->name }}</strong>
                </h5>
            </div>

            <form method="POST" action="{{ route('users.permissions.update', $user) }}">
                @csrf

                @foreach ($permissions as $group => $groupPermissions)
                    <div class="card shadow-sm border-0 mb-4">

                        {{-- Card header --}}
                        <div
                            class="card-header bg-white border-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <strong class="text-uppercase text-primary mb-2 mb-md-0">
                                <i class="fas fa-folder-open mr-1"></i>
                                {{ ucfirst($group) }}
                            </strong>

                            <div class="btn-group btn-group-sm">
                                <button type="button" class="btn btn-outline-success check-all"
                                    data-group="{{ $group }}">
                                    <i class="fas fa-check"></i>
                                    <span class="d-none d-md-inline">Tout cocher</span>
                                </button>

                                <button type="button" class="btn btn-outline-secondary uncheck-all"
                                    data-group="{{ $group }}">
                                    <i class="fas fa-times"></i>
                                    <span class="d-none d-md-inline">Tout décocher</span>
                                </button>
                            </div>
                        </div>

                        {{-- Card body --}}
                        <div class="card-body py-3">
                            <div class="row">

                                @foreach ($groupPermissions as $permission)
                                    <div class="col-12 col-sm-6 col-lg-4 mb-2">
                                        <div class="custom-control custom-checkbox permission-item">
                                            <input type="checkbox" class="custom-control-input permission-checkbox"
                                                id="perm_{{ $permission->id }}" name="permissions[]"
                                                value="{{ $permission->id }}" data-group="{{ $group }}"
                                                {{ in_array($permission->id, $userPermissions) ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="perm_{{ $permission->id }}">
                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Footer --}}
                <div class="card shadow-sm border-0 sticky-bottom bg-white">
                    <div class="card-body d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="fas fa-save mr-1"></i>
                            Enregistrer les permissions
                        </button>
                    </div>
                </div>

            </form>

        </div>
    </section>
@endsection



@section('dashboard-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Tout cocher
            document.querySelectorAll('.check-all').forEach(button => {
                button.addEventListener('click', function() {
                    const group = this.dataset.group;

                    document
                        .querySelectorAll('.permission-checkbox[data-group="' + group + '"]')
                        .forEach(checkbox => checkbox.checked = true);
                });
            });

            // Tout décocher
            document.querySelectorAll('.uncheck-all').forEach(button => {
                button.addEventListener('click', function() {
                    const group = this.dataset.group;

                    document
                        .querySelectorAll('.permission-checkbox[data-group="' + group + '"]')
                        .forEach(checkbox => checkbox.checked = false);
                });
            });

        });
    </script>
@endsection
