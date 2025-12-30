<div class="col-xl-3 col-lg-4 col-md-6 mb-3">
    <div class="card card-outline card-primary shadow-sm h-100">
        <div class="card-body d-flex align-items-start">

            {{-- Icône --}}
            <span class="badge badge-primary p-3 mr-3">
                <i class="fas fa-user"></i>
            </span>

            {{-- Infos --}}
            <div class="flex-fill">
                <strong>{{ $user->name }}</strong>

                <small class="text-muted d-block">
                    <i class="fas fa-building mr-1"></i>
                    {{ $user->company->name ?? '—' }}
                </small>

                <small class="text-muted d-block">
                    <i class="fas fa-envelope mr-1"></i>
                    {{ $user->email }}
                </small>

                <small class="text-muted d-block">
                    <i class="fas fa-phone mr-1"></i>
                    {{ $user->phone ?? '—' }}
                </small>

                <small class="text-muted d-block">
                    <i class="fas fa-id-card mr-1"></i>
                    {{ $user->cni ?? '—' }}
                </small>
            </div>

            
             @php
                $canEditUser = $adminCompany;
            @endphp

            @if ($canEditUser)
                {{-- <button class="btn btn-tool text-danger" data-toggle="modal" data-target="#editUserModal"
                    data-id="{{ $user->id }}">
                    <i class="fas fa-trash"></i>
                </button> --}}
                <a class=" text-primary"
                    href="{{ route('users.permissions.edit', $user->id) }}">
                    <i class="fas fa-pen"></i>
                </a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Supprimer cet utilisateur ?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-trash-alt mr-2"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
</div>
