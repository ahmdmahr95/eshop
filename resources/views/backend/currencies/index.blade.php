@extends('backend.layouts.master')

@section('content')

<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2><a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth"><i class="fa fa-arrow-left"></i></a> Currencies <a href="{{route('admin.currencies.create')}}" class="btn btn-sm btn-outline-secondary"><i class="icon-plus"></i> Create Currency</a></h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"><i class="icon-home"></i></a></li>                            
                        <li class="breadcrumb-item active">Currencies</li>
                    </ul>
                    <p class="float-right">Total Currencies:{{$currencies->count()}}</p>
                </div>            
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Currency</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S.N</th>
                                        <th>Name</th>
                                        <th>Symbol</th>
                                        <th>Exchange Rate(1USD = ?)</th>
                                        <th>Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    @foreach ($currencies as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>{{$item->symbol}}</td>
                                        <td>{{$item->exchange_rate}}</td>
                                        <td>{{$item->code}}</td>
                                        <td>
                                            <input type="checkbox"  name="toogle" value="{{$item->id}}" data-toggle="switchbutton"  {{$item->status == 'active'?'checked':''}} data-onlabel="Active" data-offlabel="Inactive" 
                                            data-size="sm"
                                            data-onstyle="success" data-offstyle="danger">
                                        </td>
                                        <td>
                                            <a href="{{route('admin.currencies.edit',$item->id)}}" data-toggle="tooltip" class="btn btn-sm btn-outline-primary mr-2" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>

                                            <form  action="{{route('admin.currencies.destroy',$item->id)}}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <a href="" data-toggle="tooltip" class="  dltBtn btn btn-sm btn-outline-danger" title="delete" data-id="{{$item->id}}" data-placement="bottom"><i class="fas fa-trash-alt "></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>

    </div>
</div>

@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });
    $('.dltBtn').click(function (e){
        var form=$(this).closest('form');
        var dataID=$(this).data('id');
        e.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! Your imaginary file has been deleted!", {
                icon: "success",
                });
            } else {
                swal("Your imaginary file is safe!");
            }
        });
    });
</script>
<script>
    $('input[name=toogle]').change(function(){
        var mode = $(this).prop('checked');
        var id = $(this).val();
        // alert(mode);
        $.ajax({
            url:"{{ route('admin.currencies.status') }}",
            type:"POST",
            data:{
                _token:'{{ csrf_token() }}',
                'id':id
            },
            success:function(response){
                if(response.status){
                    alert(response.success)
                }
                else{
                    alert('Please try again!')
                }
            }
        })
    });
</script>
@endsection