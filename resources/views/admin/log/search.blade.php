@forelse($usersList as $no => $user)
<tr>
    <td> {{ $no+1 }}</td>
    <td> {{ $user->name }}</td>
    <td> {{ $user->email }} </td>
    <td> {{ date('d-M-Y',strtotime($user->created_at)) }}</td>
    <td> 
        @if($user->status == 0)
            <a onClick="ChangeStatus({{$user->id}}, 1)" style="cursor:pointer">
                <button class="btn btn-success btn-sm">
                  Active
                </button>
            </a>    
        @else
            <a onClick="ChangeStatus({{$user->id}}, 0)" style="cursor:pointer">

               <button class="btn btn-danger btn-sm">
                Block
                </button>
            </a>    
        @endif()  
    </td>
    
    <td>
        <a href="{{ route('users.detail',$user->id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
        &nbsp;
        <a href="{{ route('users.edit',$user->id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
        &nbsp;
        <a href="{{ route('users.delete',$user->id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
    </td>   

</tr>
@empty
<tr class="text-center">
    <td colspan="6">No record found </td>
</tr>
@endforelse 