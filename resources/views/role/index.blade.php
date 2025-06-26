@extends('layouts.front-app')
@section('content')
<div class="container-fluid">
	<div class="row page-titles">
		<div class="col-md-8">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
				<li class="breadcrumb-item active"><a href="javascript:void(0)">Roles</a></li>
			</ol>
		</div>
		<div class="col-md-4">
			<div class="text-end">
                @can('create role')
				<a href="{{ route('roles.create') }}" class="btn btn-primary btn-xs">Create Role</a>
                @endcan
			</div>
		</div>
	</div>
	<div class="row page-titles p-0 pt-3 pb-3">
		<div class="col-md-12">
			<form method="get" action="{{ route('roles.index') }}">
				<div class="box">
					<div class="box-header">
						<div class="row">
							<div class="col-md">
								<input type="text" name="name" class="form-control" placeholder="Name" value="{{ Request::get('name') }}">
							</div>
							<div class="col-md-2">
								<button class="btn btn-primary" type="submit" style="width: 100%;">Search</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Roles</h4>
				</div>
				<div class="card-body">
					@if($errors->any())
					{!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
					@endif
					@if(session()->has('success'))
					<div class="alert alert-success">
						{{ session()->get('success') }}
					</div>
					@endif
					<div class="table-responsive">
						<table class="table table-responsive-md">
							<thead>
								<tr>
                                    <th><strong>SNO</strong></th>
									<th><strong>NAME</strong></th>
									<th><strong>CREATED AT</strong></th>
									<th class="text-end"><strong>Action</strong></th>
								</tr>
							</thead>
							<tbody>
								@foreach($data as $key => $value)
								<tr>
                                    <td>{{ ++$key }}</td>
									<td>{{ $value->name }}</td>
									<td>{{ $value->created_at->format('d M, Y g:i A') }}</td>
									<td class="text-end">
										<div class="d-flex justify-content-end mt-2">
                                            @can('edit role')
											<a href="{{ route('roles.edit', $value->id) }}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                            @endcan
                                            @can('delete role')
											<form action="{{ route('roles.destroy', $value->id) }}" method="post">
												@csrf
												@method('DELETE')
												<button type="submit" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></button>
											</form>
                                            @endcan
										</div>
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
@endsection

@push('scripts')
   <!-- <script type="text/javascript">-->
   <!-- 	$(function () {-->
   <!-- 		'use strict';-->
   <!-- 		$('#example1').DataTable({-->
		 <!-- 		'paging'      : true,-->
		 <!-- 		'lengthChange': false,-->
		 <!-- 		'searching'   : false,-->
		 <!-- 		'ordering'    : true,-->
		 <!-- 		'info'        : true,-->
		 <!-- 		'autoWidth'   : false-->
			<!--});-->
   <!-- 	});-->
   <!-- </script>-->
@endpush