@extends('admin.layouts.app')

@section('dashboard-content')
<style>
    .inner >p{
        color: rgb(11, 47, 211);
        font-weight: bold;
    }

    .small-box-footer{
        /* background-color: rgba(20, 29, 70, 1) !important; */
        /* color: rgb(11, 47, 211) !important; */
        border-radius: 0 0 4px 4px;
    }
    .bg-white>a {
        color: rgb(11, 47, 211) !important;
    }
    .small-box {
        
    }
</style>
    <section class="content mt-2">
        <div class="container-fluid">
            {{-- Small boxes (Stat box) --}}
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\User::count()}}</h3>

                            <p>{{__('dashboard.user')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-users"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Supplier::count()}}<sup style="font-size: 20px"></sup></h3>

                            <p>{{__('dashboard.supplier')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('supplier.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Customer::count()}}</h3>

                            <p >{{__('dashboard.customer')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{route('customer.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Category::count()}}</h3>

                            <p>{{__('dashboard.category')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('category.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Product::count()}}</h3>

                            <p>{{__('dashboard.product')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('product.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Order::count()}}</h3>

                            <p>{{__('dashboard.order')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-white">
                        <div class="inner">
                            <h3>{{\App\Models\Payment::count()}}</h3>

                            <p>{{__('dashboard.payment')}}</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

            </div>

            {{-- Main row --}}
            <div class="row">

                <section class="col-lg-7">
                    {{-- Custom tabs (Charts with tabs) --}}
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-chart-pie mr-1"></i>
                                Modules
                            </h3>
                            
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-2 col-4">
                                    <div class="small-box bg-white">
                                        <div class="inner">
                                            <p>{{__('POS')}}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-card"></i>
                                        </div>
                                        <a href="" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <div class="small-box bg-white">
                                        <div class="inner">
                                            <p>{{__('Stock')}}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-cubes sidebar-left-icon"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-4">
                                    <div class="small-box bg-white">
                                        <div class="inner">
                                            <p>{{__('Bilan')}}</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                        <a href="#" class="small-box-footer"> <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div><!-- /.card-body -->
                    </div>
                </section>


            </div>

        </div>
    </section>
@endsection
