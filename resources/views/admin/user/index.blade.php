@extends('admin.layouts.table')
@section('content')
<?php
use App\Models\History;
?>
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Danh Sách</h4>

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
          <div class="card-header"><i class="fa fa-table"></i> Danh sách</div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Số tiền</th>
                    <th>Trạng Thái</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($users as $key => $user)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $user['email'] }}</td>
                    <td>{{ $user['mobile'] }}</td>
                    <td>{{ $user['money'] }} xu</td>
                    <center>
                      <td style="width: 50px">
                      @if(!empty(History::where('user_id', $user['id'])->orderBy('id','desc')->first()))
                      @if(History::where('user_id', $user['id'])->orderBy('id','desc')->first()->status==0)
                        <a href="{{ url('/admin/recharge-user/' . $user['id']) }}"><i style="color: yellow"
                            class="fa fa-2x fa-money"></i></a>
                      @else
                      <a href="javascript:void(0)"><i style="color: green"
                            class="fa fa-2x fa-money"></i></a>
                      @endif
                      @else
                      <a href="javascript:void(0)"><i style="color: green"
                            class="fa fa-2x fa-money"></i></a>
                      @endif
                        &nbsp;&nbsp;
                        <a href="{{ url('/admin/delete-game/' . $user['id']) }}"><i style="color: red"
                            class="fa fa-2x fa-trash"></i></a>
                      </td>
                    </center>
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