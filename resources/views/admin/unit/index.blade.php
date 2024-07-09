@extends('admin.master')
@section('body')
    <div class="row mt-3">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Unit Form</h4>
                    <hr>
                    <h4 class="text-center text-success">{{session('message')}}</h4>
                    <form class="form-horizontal p-t-20" action="{{route('unit.new')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Unit Name <span class="text-danger"></span>*</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name" id="exampleInputuname3" placeholder="unit Name">
                            </div>
                        </div>
                            <div class="form-group row">
                                <label for="exampleInputuname3" class="col-sm-3 control-label">Unit code <span class="text-danger"></span>*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="code" id="" placeholder="unit code">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Unit Description <span class="text-danger"></span>*</label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="exampleInputEmail3" name="description" placeholder="Unit Description "></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword4" class="col-sm-3 control-label">Publication Status</label>
                            <div class="col-sm-9">
                                <label class="me-3"> <input  type="radio" value="1" name="status" checked> Published</label>
                                <label> <input  type="radio" value="2" name="status"> UnPublished</label>
                            </div>
                        </div>
                            <div class="form-group row m-b-0">
                            <div class="offset-sm-3 col-sm-9">
                                <button type="submit" class="btn btn-success waves-effect waves-light text-white">Create New Unit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection