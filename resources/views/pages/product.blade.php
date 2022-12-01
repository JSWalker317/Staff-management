@extends('base')

@section('content')
    <h3>Sản Phẩm</h3>
    <div class="mt-2 text-center">
        @if ($products != null) 
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Mô tả</th>
                        <th>Giá</th>
                        <th>Tình trạng</th>
                        <th></th>
                    </tr>
                </thead>
                
                <tbody>
                    @foreach($products as $key => $value)
                    <tr>
                        <th class="product_id">{{$value['product_id']}}</th>
                        <td>{{$value['product_name']}}</td>
                        <td>{{$value['description']}}</td>
                        <td>{{$value['product_price']}}</td>
                        <td>{{$value['is_sales']}}</td>
                        <td>
                            <a href="" class="mr-3 edit_btn" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>
                            <a href="" class="delete_btn" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                  
        
        @else
             <span>Oops! Something went wrong. Please try again later</span>
        @endif


       
   
    </div>
@endsection

