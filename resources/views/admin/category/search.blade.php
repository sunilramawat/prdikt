@forelse($categoryList as $no => $category)
    <tr>
        <td> {{ $no+1 }}</td>
        <td> {{ $category->category_name }}</td>
        <td> 
            <div  class="profile-img"> 
                <img src="{{ URL('public/images/category') }}/{{ $category->category_image }}" alt="" height="30px" width="30px">
            </div>

        </td>
        <td> {{ date('d-M-Y',strtotime($category->created_at)) }}</td>
        <td>
            <a href="{{ route('category.detail',$category->category_id) }}"><i class="fa fa-eye " aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('category.edit',$category->category_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
            &nbsp;
            <a href="{{ route('category.delete',$category->category_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
        </td>   

    </tr>
 @empty
    <tr class="text-center">
        <td colspan="6">No record found </td>
    </tr>
@endforelse