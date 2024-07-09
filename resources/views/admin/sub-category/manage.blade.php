@extends('admin.master')
@section('body')

    <div class="row mt-3">
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage  Sub Category</h4>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-striped border table-hover table-sm"  width="100%">
                            <thead>
                            <tr>
                                <th>SL NO </th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach($sub_categories as $sub_category)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$sub_category->category->name}}</td>
                                <td>{{$sub_category->name}}</td>
                                <td>{{$sub_category->description}}</td>
                                <td>
                                <img src="{{ asset ($sub_category->image)}}" class="img-fluid" style="width:50px;height:40px;border-radius:50%;" alt="">
                                </td>
                                <td>{{$sub_category->status == 1 ? 'Published' : 'Unpublished'}}</td>

                                <td  class="btn-group">
                                    <a href="{{route('sub-category.edit',['id'=>$sub_category->id]) }}" class="btn btn-success btn-sm mx-lg-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
{{--                                    @if($category->status == 1)--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-warning btn-sm mx-1">Unpublished</a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-primary btn-sm mx-1">Published</a>--}}
{{--                                    @endif--}}

                                    <form action="{{route('sub-category.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$sub_category->id}}" name="id">
                                        <button type="submit" class="btn btn-danger btn-sm mx-lg-2" onclick="return confirm('Are you sure Delete this !!')"><i class="fas fa-trash"></i></button>

                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection