@extends('backend.user.master')

@section('content')
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Course</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Course</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
       

        <hr />
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Thumbnail</th>
                                <th>Course Name</th>
                                <th>Category</th>
                                <th>SubCategory</th>
                                <th>Selling Price</th>
                                <th>Discount Price</th>
                                <th> show course </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($all_courses as $index=>$item)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>
                                    @if($item->course_image)
                                    <img src="{{asset('uploads/'.$item->course_image)}}"  width="140" height="70"/>
                                    @else
                                    <span>No image found</span>
                                    @endif
                                </td>
                                <td>
                                    {{$item->course_name}}
                                </td>

                                <td>{{$item->category['name'] ?? Null }}</td>
                                <td>
                                    {{$item->subCategory['name'] ?? Null}}
                                </td>
                                <td>
                                    {{$item->selling_price}}
                                </td>

                                <td>
                                    {{$item->discount_price}}
                                </td>


                               <td>
                                <a href="{{route('user.course.show',$item->id)}}" class="btn btn-primary">show course</a>
                               </td>

                            </tr>
                            @endforeach
                        </tbody>


                    </table>
                </div>
            </div>
        </div>


    </div>
@endsection

@push('scripts')

<script>
    $(document).on('click', '.delete-category', function (e) {
        e.preventDefault();

        let categoryId = $(this).data('id');
        let deleteUrl = "{{ route('instructor.course.destroy', ':id') }}".replace(':id', categoryId);

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#delete-form').attr('action', deleteUrl).submit();
            }
        });
    });
</script>

@endpush
