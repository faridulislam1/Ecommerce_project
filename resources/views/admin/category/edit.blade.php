@extends('admin.master')
@section('body')
    <div class="row mt-3">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Category Form</h4>
                    <hr>
                    <form class="form-horizontal p-t-20" action="{{route('category.update')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ $category->id }}">
                        <div class="form-group row">
                            <label for="exampleInputuname3" class="col-sm-3 control-label">Category Name <span class="text-danger"></span>*</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="name"  value="{{$category ->name }}" id="exampleInputuname3" placeholder="Category Name">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="exampleInputEmail3" class="col-sm-3 control-label">Category Description <span class="text-danger"></span>*</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="exampleInputEmail3" value="{{$category ->description }}"  name="description" placeholder="Category Description ">

                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="form-label col-sm-3 control-label" for="web">Category Image</label>
                            <div class="col-sm-9">
                                <input type="file" name="image" id="input-file-now" class="dropify" />
                                <img src="{{ asset ($category->image)}}" class="img-fluid" style="width:80px;height:50px;border-radius:50%;" alt="">
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
                                <button type="submit" class="btn btn-success waves-effect waves-light text-white">Create New Category</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection