@extends('admin.master')
@section('body')

    <div class="row mt-3">
        <div class="col-12 ">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Manage Unit</h4>
                    <div class="table-responsive m-t-40">
                        <table id="myTable" class="table table-striped border table-hover table-sm"  width="100%">
                            <thead>
                            <tr>
                                <th>SL NO </th>
                                <th>Unit Name</th>
                                <th>Unit Code</th>
                                <th>Unit Description</th>
                                <th>Publication Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php $i=1 @endphp
                            @foreach($units as $unit)
                            <tr>
                                <td>{{$i++}}</td>
                                <td>{{$unit->name}}</td>
                                <td>{{$unit->code}}</td>
                                <td>{{$unit->description}}</td>
                                <td>{{$unit->status == 1 ? 'Published' : 'Unpublished'}}</td>
                                <td  class="btn-group">
                                    <a href="{{route('unit.edit',['id'=>$unit->id]) }}" class="btn btn-success btn-sm mx-lg-2">
                                        <i class="fas fa-edit"></i>
                                    </a>
{{--                                    @if($category->status == 1)--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-warning btn-sm mx-1">Unpublished</a>--}}
{{--                                    @else--}}
{{--                                        <a href="{{route('category.status',['id'=>$category->id]) }}" class="btn btn-primary btn-sm mx-1">Published</a>--}}
{{--                                    @endif--}}

                                    <form action="{{route('unit.delete')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$unit->id}}" name="id">
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