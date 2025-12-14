@extends('admin.layouts.app')

@section('dashboard-content')
    <style>
        .small-box {
            border-radius: 10px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .small-box:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .small-box .inner p {
            font-weight: 600;
            color: #1f2d3d;
        }

        .small-box-footer {
            border-radius: 0 0 10px 10px;
            background: #f4f6f9;
            color: #007bff;
            font-weight: 500;
        }

        .small-box-footer:hover {
            background: #e2e6ea;
            color: #0056b3;
        }

        .icon {
            color: #28a745 !important;
            opacity: 0.65;
        }

        @media(max-width: 768px) {
            .small-box h3 {
                font-size: 1.6rem;
            }
        }
    </style>

    <section class="content mt-3">
        <div class="container-fluid">

            {{-- Stats top --}}
            <div class="row">

                @php
                    $items = [
                        ['count' => count($users), 'label' => __('dashboard.user'), 'icon' => 'fa-users', 'url' => '#'],
                        [
                            'count' => count($suppliers),
                            'label' => __('dashboard.supplier'),
                            'icon' => 'fa-industry',
                            'url' => route('supplier.index'),
                        ],
                        [
                            'count' => count($customers),
                            'label' => __('dashboard.customer'),
                            'icon' => 'ion-person-add',
                            'url' => route('customer.index'),
                        ],
                        [
                            'count' => count($categories),
                            'label' => __('dashboard.category'),
                            'icon' => 'fa-tags',
                            'url' => route('category.index'),
                        ],
                        [
                            'count' => count($products),
                            'label' => __('dashboard.product'),
                            'icon' => 'fa-boxes',
                            'url' => route('product.index'),
                        ],
                        [
                            'count' => count($orders),
                            'label' => __('dashboard.order'),
                            'icon' => 'fa-file-invoice',
                            'url' => '#',
                        ],
                        [
                            'count' => count($payments),
                            'label' => __('dashboard.payment'),
                            'icon' => 'fa-credit-card',
                            'url' => '#',
                        ],
                    ];
                @endphp

                @foreach ($items as $item)
                    <div class="col-lg-3 col-md-4 col-6 mb-3">
                        <div class="small-box bg-white">
                            <div class="inner">
                                <h3>{{ $item['count'] }}</h3>
                                <p>{{ $item['label'] }}</p>
                            </div>
                            <div class="icon">
                                <i class="fa {{ $item['icon'] }}"></i>
                            </div>
                            <a href="{{ $item['url'] }}" class="small-box-footer">
                                More info <i class="fas fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>

            {{-- Modules --}}
            <div class="row mt-4">
                <section class="col-lg-7 col-md-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white">
                            <h3 class="card-title">
                                <i class="fas fa-th-large mr-1 text-success"></i> Modules
                            </h3>
                        </div>

                        <div class="card-body">
                            <div class="row">

                                @php
                                    $modules = [
                                        [
                                            'label' => __('POS'),
                                            'icon' => 'fa-cash-register',
                                            'url' => route('order.create'),
                                        ],
                                        ['label' => __('Stock'), 'icon' => 'fa-warehouse', 'url' => '#'],
                                        ['label' => __('Bilan'), 'icon' => 'fa-chart-line', 'url' => '#'],
                                    ];
                                @endphp

                                @foreach ($modules as $mod)
                                    <div class="col-lg-2 col-4 mb-3">
                                        <div class="small-box bg-white">
                                            <div class="inner">
                                                <p>{{ $mod['label'] }}</p>
                                            </div>
                                            <div class="icon">
                                                <i class="fa {{ $mod['icon'] }}"></i>
                                            </div>
                                            <a href="{{ $mod['url'] }}" class="small-box-footer">
                                                <i class="fas fa-arrow-circle-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </section>
            </div>

        </div>
    </section>
@endsection
