@extends('admin.layouts.create_edit')
@section('content')
<div class="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumb-->
            <div class="row pt-2 pb-2">
                <div class="col-sm-9">
                    
                </div>
            </div>
            <!-- End Breadcrumb-->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-uppercase">Điều Khoản Chính Sách</div>
                        <div class="card-body">
                            <form action="{{url('/admin/policy')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                
                                <label>Mô Tả</label>
                                <textarea id="summernoteEditor" name="description" required>
                                   @if(isset($policy)) {{$policy['description']}} @endif
                                </textarea>
                                <hr>
                                
                                <button type="reset" class="btn btn-behance">Làm Mới</button>
                                <button type="submit" class="btn btn-dribbble">Cập nhật</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Row-->


            <!--End Row-->


            <!--End Row-->





            <!--End Row-->



            <!--End Row-->


            <!--End Row-->
            <!--start overlay-->
            <div class="overlay"></div>
            <!--end overlay-->
        </div>
        <!-- End container-fluid-->

    </div>
@endsection