<div class="row mt-2" >
    <div class="col-4"></div>
    <div class="col-4 d-flex justify-content-center">
        {{ $customers->links() }}
    </div>
    <div class="col-4 d-flex justify-content-end">
        <div class="hint-text">Showing <b>{{$customers->count()}}</b> out of <b>{{$customers->total()}}</b> entries</div>
    </div>        
</div>

<table class="table table-bordered table-striped">
    <thead class="bg-danger text-light">
        <tr>
            <th>#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th></th>
        </tr>
    </thead>
    
    <tbody id="customerList"> 
        @if ($customers->count() > 0) 
            @foreach($customers as $key => $value)
                <tr>
                    <th class="customer_id">{{$value['customer_id']}}</th>
                    <td class="customer_name">{{$value['customer_name']}}</td>
                    <td>{{$value['email']}}</td>
                    <td>{{$value['address']}}</td>
                    <td>{{$value['tel_num']}}</td>            
                    <td>
                        <a href="" class="mr-3 edit_btn" title="Edit User" data-customer_id="{{$value['customer_id']}}" data-toggle="modal" data-target="#addEditCustomer"><span class="fa fa-pencil "></span></a>
                    </td>
                </tr>

            @endforeach
        @else
            <b class="text-center">Oops! Không có dữ liệu !</b>
        @endif
    </tbody>
</table>
            
<div class="d-flex justify-content-center">
    {{ $customers->links() }}
</div>





  
