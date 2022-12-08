
{!! $users->withQueryString()->links('pagination::bootstrap-5') !!}

<table class="table table-bordered table-striped">
    <thead class="bg-danger text-light">
        <tr>
            <th>#</th>
            <th>Họ tên</th>
            <th>Email</th>
            <th>Nhóm</th>
            <th>Trạng thái</th>
            <th></th>
        </tr>
    </thead>
    <tbody id="bodyTable">    
        @if ($users->count() > 0) 
            @foreach($users as $key => $value)
                <tr>
                    <th class="id">{{$value['id']}}</th>
                    <td class="name">{{$value['name']}}</td>
                    <td>{{$value['email']}}</td>
                    <td>{{$value['group_role']}}</td>
                    @if($value['is_active'] == 1)
                        <td class="text-success status">Đang hoạt động</td>
                    @else
                        <td class="text-danger status">Tạm khóa</td>
                    @endif
                    
                    <td>
                        <a href="" class="mr-3 edit_btn" title="Edit User" data-id="{{$value['id']}}" data-toggle="modal" data-target="#addEditUser"><span class="fa fa-pencil "></span></a>
                        <a href="" class="mr-3 delete_btn" title="Delete User" data-id="{{$value['id']}}" data-name="{{$value['name']}}" data-toggle="modal" data-target="#deleteUser"><span class="fa fa-trash" style="color:red"></span></a>
                        <a href="" class="status_btn" title="Status Users" data-id="{{$value['id']}}" data-name="{{$value['name']}}" data-status="{{$value['is_active']}}" data-toggle="modal" data-target="#statusUser"><span class="fa fa-user-times" style="color:black"></span></a>
                    </td>
                </tr>

            @endforeach
        @else
            <b class="text-center">Oops! Không có dữ liệu !</b>
        @endif
    </tbody>
</table>

<div class="d-flex justify-content-center">
    {{ $users->links() }}
</div>



  
