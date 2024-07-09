@extends('admin.master')
@section('body')
    <div class="row mt-3">
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Brand</h4>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-striped border table-hover table-sm"  width="100%">
                            <thead>
                            <tr>
                                <th>SL NO </th>
                                <th>Brand Name</th>
                                <th>Brand Description</th>
                                <th>Brand Image</th>
                                <th>Brand Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach($brands as $brand)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$brand->name}}</td>
                                <td>{{$brand->description}}</td>
                                <td>
                                <img src="{{ asset ($brand->image)}}" class="img-fluid" style="width:50px;height:40px;border-radius:50%;" alt="">
                                </td>
                                <td>{{$brand->status == 1 ? 'Published' : 'Unpublished'}}</td>

                                <td  class="btn-group">
                                    <a href="{{route('brand.edit',['id'=>$brand->id]) }}" class="btn btn-success btn-sm mx-lg-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
{{--                                    @if($category->status == 1)--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-warning btn-sm mx-1">Unpublished</a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-primary btn-sm mx-1">Published</a>--}}
{{--                                    @endif--}}

                                    <form action="{{route('brand.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$brand->id}}" name="id">
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