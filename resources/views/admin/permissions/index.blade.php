@extends('admin.layouts.app')

@section('dashboard-content')
    <section class="content pt-3">
        <div class="container-fluid">

            <h5 class="mb-3">
                <i class="fas fa-shield-alt mr-1"></i> Gestion des permissions
            </h5>

            @foreach ($permissions as $group => $groupPermissions)
                <div class="card card-outline card-primary mb-4">
                    <div class="card-header">
                        <strong class="text-uppercase">
                            <i class="fas fa-folder-open mr-1"></i>
                            {{ ucfirst($group) }}
                        </strong>
                    </div>

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Permission</th>

                                        @foreach ($roles as $role)
                                            <th class="text-center">
                                                {{ ucfirst($role->name) }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($groupPermissions as $permission)
                                        <tr>
                                            <td>
                                                {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                            </td>

                                            @foreach ($roles as $role)
                                                <td class="text-center">
                                                    <input type="checkbox" class="permission-toggle"
                                                        data-role="{{ $role->id }}"
                                                        data-permission="{{ $permission->id }}"
                                                        {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </section>
@endsection
