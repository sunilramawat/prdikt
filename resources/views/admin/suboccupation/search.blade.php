@forelse($subOccupationList as $no => $occupation)
    <tr>
        <td> {{ $no+1 }}</td>
        <td> {{ $occupation->sub_occuption_name }}</td>
        <td> 
            <img src="{{ URL('public/images/suboccupation') }}/{{ $occupation->sub_occuption_image }}" alt="" height="30px" width="30px">


        </td>
        <td>
            {{ $occupation->occuption_name}}
        </td>

        <td> {{ date('d-M-Y',strtotime($occupation->created_at)) }}</td>


        <td>
            <a href="{{ route('suboccupation.detail',$occupation->sub_occuption_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('suboccupation.edit',$occupation->sub_occuption_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('suboccupation.delete',$occupation->sub_occuption_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>   

    </tr>
 @empty
    <tr class="text-center">
        <td colspan="6">No record found </td>
    </tr>
@endforelse 