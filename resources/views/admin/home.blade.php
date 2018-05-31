@extends('layouts.master')

@section('content')

        <section class="content-header">
                <h1>
                  Dashboard
                  <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                  <li class="active">Dashboard</li>
                </ol>
        </section>
          
              <!-- Main content -->
              <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">

                  <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <h3>{{ $numclientes }}</h3>
          
                        <p> Clientes</p>
                      </div>
                      <div class="icon">
                        <i class="ion ion-person-add"></i>
                      </div>
                      <a href="/admin/listclientes" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>


                  
                    <div class="col-lg-3 col-xs-6">
                   
                        <div class="small-box bg-green">
                        <div class="inner">
                            <h3>{{ $numasociados }}</h3>
            
                            <p>Asociados / Proveedores</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="/admin/listasociados" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                  

                    <div class="col-lg-3 col-xs-6">
                    <!-- small box -->
                        <div class="small-box bg-yellow">
                        <div class="inner">
                            <h3>{{ $cerrados }}</h3>
            
                            <p>Solicitudes Cerradas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="/admin/listsolicitudes" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                    <div class="col-lg-3 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                          <div class="inner">
                            <h3>{{ $solicitados }}</h3>
              
                            <p>Peticiones</p>
                          </div>
                          <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                          </div>
                          <a href="/admin/listsolicitudes" class="small-box-footer">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>


                </div>
                
          
              
            <div class="row">
                <section class="col-lg-7 connectedSortable">
                        <div class="box box-primary">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Solicitudes Cerradas</h3>
                    
                                  <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                  </div>
                                </div>
                                <div class="box-body chart-responsive">
                                  <div class="chart" id="revenue-chart" style="height: 300px;"></div>
                                </div>
                                <!-- /.box-body -->
                        </div>
                </section>

                <div class="col-md-5">
                            <div class="info-box bg-yellow">
                                <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>
                    
                                <div class="info-box-content">
                                  <span class="info-box-text">Importe Total</span>
                                  <span class="info-box-number">5,200</span>
                    
                                  <div class="progress">
                                    <div class="progress-bar" style="width: 100%"></div>
                                  </div>
                                  <span class="progress-description">
                                       Importe mensual
                                      </span>
                                </div>
                                
                            </div>
                </div>
            </div>
</section>

@endsection

