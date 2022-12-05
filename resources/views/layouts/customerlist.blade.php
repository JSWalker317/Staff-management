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



  
