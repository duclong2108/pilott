@extends('admin.layouts.table')
@section('content')
<div class="content-wrapper">
  <div class="container-fluid">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title">Danh Sách</h4>

      </div>
      <div class="col-sm-3">
        <div class="btn-group float-sm-right">
          <a role="button" data-toggle="modal" data-target="#exampleModalCenter" href="javascript:void(0)" class="btn btn-light waves-effect waves-light"><i class="fa fa-plus"></i> Tạo</a>

        </div>
      </div>
    </div>
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Tạo Trò Chơi</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form action="{{ url('/admin/create-game') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">

              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tên:</label>
                <input type="text" required name="name" class="form-control" id="recipient-name">
              </div>
              <div class="form-group">
                <label for="message-text" class="col-form-label">Ảnh:</label>
                <input type="file" name="image" onchange="loadfile(event)" required class="form-control">
                <div class="" id="preview">

                </div>
              </div>
              <div class="form-group">
                <label for="recipient-name" class="col-form-label">Tình Trạng:</label>
                <input type="radio" name="status" value="1" checked>Hoạt Động
                <input type="radio" name="status" value="0">Không Hoạt Động
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
              <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
          </form>
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
                    <th>Ảnh</th>
                    <th>Tên</th>
                    <th>Trạng Thái</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($games as $key => $game)
                  <tr>
                    <td>{{ ++$key }}</td>
                    <td>
                      <input type="image" src="{{ $game['image'] }}" width="80px" height="80px">
                    </td>
                    <td>{{ $game['name'] }}</td>
                    <center>
                      <td style="width: 50px">
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter{{ $game['id'] }}"><i style="color: green" class="fa fa-2x fa-edit"></i></a>&nbsp;&nbsp;
                        <a href="{{ url('/admin/delete-game/' . $game['id']) }}"><i style="color: red" class="fa fa-2x fa-trash"></i></a>
                        <div class="modal fade" id="exampleModalCenter{{ $game['id'] }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Chỉnh
                                  Sửa Trò Chơi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ url('/admin/edit-game/' . $game['id']) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">

                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Tên:</label>
                                    <input type="text" required name="name" value="{{ $game['name'] }}" class="form-control" id="recipient-name">
                                  </div>
                                  <div class="form-group">
                                    <label for="message-text" class="col-form-label">Ảnh:</label>
                                    <input type="file" name="image" class="form-control">
                                    <div class="" id="preview">
                                      <img src="{{$game['image']}}" width="100px" height="100px">
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label for="recipient-name" class="col-form-label">Tình Trạng:</label>
                                    @if ($game['status'] == 1)
                                    <input type="radio" name="status" value="1" checked>Hoạt Động
                                    <input type="radio" name="status" value="0">Không Hoạt Động
                                    @else
                                    <input type="radio" name="status" value="1">Hoạt Động
                                    <input type="radio" name="status" value="0" checked>Không Hoạt Động
                                    @endif
                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                  <button type="submit" class="btn btn-primary">Lưu</button>
                                </div>
                              </form>
                            </div>
                          </div>
                        </div>
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