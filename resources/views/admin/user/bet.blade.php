@extends('admin.layouts.table')
@section('content')
<?php
use App\Models\User;
use Carbon\Carbon;
// dd(date('d/m/Y', strtotime(Carbon::now())));
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title"><i class="fa fa-table"></i> Danh Sách</h4>

      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">

        </div>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header"> 
            <div class="row">
                <div class="col-3" style="position:relative;top:1vh;font-size:1vw">Số người chơi đánh trong ngày</div>
                <div class="col-3">
                    <input type="date" class="form-control click-date" value="{{date('Y-m-d', strtotime(Carbon::now()))}}">
                </div>
                <div class="col-3">
                    <input type="text" class="form-control" id="count-date" readonly>
                </div>
                <div class="col-3">
                    <button class="btn btn-primary winner-count">Đếm số người chơi</button>
                </div>
            </div>
          </div>
          
          
          <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Loại chơi</th>
                    <th>Số đánh</th>
                    <th>Xu đánh</th>
                    <th>Ngày đánh</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($winners as $key=>$winner)
                    <tr>
                        <td>{{++$key}}</td>
                        <td>{{User::find($winner['user_id'])->email}}</td>
                        <td>{{User::find($winner['user_id'])->mobile}}</td>
                        <td>{{($winner['type']==1?"Đặc biệt":"Lô tô")}}</td>
                        <td>{{$winner['result_prediction']}}</td>
                        <td>{{$winner['money']}}</td>
                        <td>{{date('d/m/Y', strtotime($winner['created_at']))}}</td>
                    </tr>
                  @endforeach
                </tbody>

              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Row-->



    <!-- End Row-->
    <!--start overlay-->
    <div class="overlay"></div>
    <!--end overlay-->
  </div>
  <!-- End container-fluid-->

</div>
@endsection