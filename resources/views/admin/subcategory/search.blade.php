 @forelse($subCategoryList as $no => $category)
    <tr>
    <td> {{ $no+1 }}</td>
    <td> {{ $category->sub_category_name }}</td>
    <td> 
        <img src="{{ URL('public/images/subcategory') }}/{{ $category->sub_category_image }}" alt="" height="30px" width="30px">


    </td>
    <td>
        {{ $category->category_name}}
    </td>

    <td> {{ date('d-M-Y',strtotime($category->created_at)) }}</td>


    <td>
        <a href="{{ route('subcategory.detail',$category->sub_category_id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
        &nbsp;
        <a href="{{ route('subcategory.edit',$category->sub_category_id) }}"><i class="fa fa-edit"  aria-hidden="true"></i></a>
        &nbsp;
        <a href="{{ route('subcategory.delete',$category->sub_category_id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
    </td>   

    </tr>
    @empty
    <tr class="text-center">
    <td colspan="6">No record found </td>
    </tr>
    @endforelse 