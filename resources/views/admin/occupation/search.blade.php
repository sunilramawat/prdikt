@forelse($occuptionList as $no => $occuption)
    <tr>
        <td> {{ $no+1 }}</td>
        <td> {{ $occuption->occuption_name }}</td>
        <td> 
            <div  class="profile-img"> 
                <img src="{{ URL('public/images/occupation') }}/{{ $occuption->occuption_image }}" alt="" height="30px" width="30px">
            </div>

        </td>
        <td> {{ date('d-M-Y',strtotime($occuption->created_at)) }}</td>
        <td>
            <a href="{{ route('occupation.detail',$occuption->occuption_id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('occupation.edit',$occuption->occuption_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('occupation.delete',$occuption->occuption_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>   

    </tr>
 @empty
    <tr class="text-center">
        <td colspan="6">No record found </td>
    </tr>
@endforelse