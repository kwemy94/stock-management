@extends('admin.layouts.app')

@section('dashboard-datatable-css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('dashboard-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dashboard-template/dist/css/adminlte.min.css') }}">
@endsection

@section('dashboard-content')
    <section class="content pt-3">
        <div class="container-fluid">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">
                    <i class="fas fa-users mr-1"></i> Utilisateurs
                </h5>

                @can('create user')
                    @if ($canCreateUser)
                        <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createUserModal">
                            <i class="fas fa-plus mr-1"></i> Nouvel utilisateur
                        </button>
                    @endif
                @endcan
            </div>

            @forelse ($usersByCompany as $companyName => $companyUsers)
                {{-- Nom de l’entreprise --}}
                <div class="mb-2 mt-4">
                    <h6 class="text-primary font-weight-bold">
                        <i class="fas fa-building mr-1"></i>
                        {{ $companyName }}
                        <span class="badge badge-secondary ml-1">
                            {{ $companyUsers->count() }}
                        </span>
                    </h6>
                    <hr class="mt-1 mb-3">
                </div>

                {{-- Utilisateurs --}}
                <div class="row">
                    @foreach ($companyUsers as $user)
                        <x-user-card :user="$user" :adminCompany="$adminCompany" />
                    @endforeach
                </div>

            @empty
                <div class="alert alert-info text-center">
                    Aucun utilisateur enregistré
                </div>
            @endforelse


        </div>

        @include('admin.users.partials.edit-modal', ['roles' => $roles])
        @include('admin.users.partials.create-modal', ['roles' => $roles])
    </section>
@endsection



@section('dashboard-datatable-js')
    <!-- jQuery -->
    <script src="{{ asset('dashboard-template/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->

    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dashboard-template/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard-template/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel", "pdf"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        });
    </script>
@endsection

@section('dashboard-js')
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        $('#editUserModal').on('show.bs.modal', function(e) {
            console.log('Modal opened');
            let button = $(e.relatedTarget);
            let userId = button.data('id');
            let modal = $(this);

            modal.find('form').attr('action', `/dashboard/users/${userId}`);

            $.get(`/dashboard/users/${userId}`, function(user) {
                modal.find('[name=name]').val(user.name);
                modal.find('[name=email]').val(user.email);
                modal.find('[name=phone]').val(user.phone);
                modal.find('[name=cni]').val(user.cni);
            });
        });


        $('#btnUserCreate').click((e) => {
            e.preventDefault();
            if (ControlRequiredFields($('#formUser .required'))) {
                $('#formUser').submit()
            }
        });
    </script>
@endsection
