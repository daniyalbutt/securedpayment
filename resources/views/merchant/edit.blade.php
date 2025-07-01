@extends('layouts.front-app')
@section('content')

<div class="container-fluid">
	<div class="row page-titles">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:void(0)">Merchant</a></li>
			<li class="breadcrumb-item active"><a href="javascript:void(0)">Edit Merchant - {{ $data->name }}</a></li>
		</ol>
	</div>
	<div class="row">
		<div class="col-lg-12 col-12">
		    <div class="card">
		        <div class="card-header">
					<h4 class="card-title">Edit Merchant Form - {{ $data->name }}</h4>
		        </div>
		        <!-- /.box-header -->
				<div class="card-body">
					<div class="basic-form">
						<form class="form" method="post" action="{{ route('merchant.update', $data->id) }}" enctype="multipart/form-data">
							@csrf
							@method('PUT')
							<div class="box-body">
								@if($errors->any())
									{!! implode('', $errors->all('<div class="alert alert-danger">:message</div>')) !!}
								@endif
								@if(session()->has('success'))
								<div class="alert alert-success">
									{{ session()->get('success') }}
								</div>
								@endif
								<div class="row">
									<div class="col-md-4">
										<div class="form-group mb-3">
											<label class="form-label">Name</label>
											<input type="text" class="form-control" name="name" value="{{ $data->name }}" required value="{{ old('name') }}">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group mb-3">
											<label class="form-label">Type</label>
											<select name="type" id="type" class="form-control" required>
												<option value="">Select Merchant</option>
												<option value="0" {{ $data->merchant == 0 ? 'selected' : '' }}>STRIPE</option>
												<option value="4" {{ $data->merchant == 4 ? 'selected' : '' }}>AUTHORIZE</option>
												<option value="5" {{ $data->merchant == 5 ? 'selected' : '' }}>PAYPAL</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group mb-3">
											<label class="form-label">Status</label>
											<select name="status" id="status" class="form-control">
												<option value="0" {{ $data->status == 0 ? 'selected' : '' }}>Active</option>
												<option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Deactive</option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-3">
											<label class="form-label">Publishable key / Login ID / Client ID</label>
											<input type="text" class="form-control" name="public_key" required value="{{ old('public_key', $data->public_key) }}">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-3">
											<label class="form-label">Secret key / Transaction Key / Client Secret</label>
											<input type="text" class="form-control" name="private_key" required value="{{ old('private_key', $data->private_key) }}">
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-3">
											<label class="form-label">Production/Sandbox</label>
											<select name="sandbox" id="sandbox" class="form-control">
												<option value="0" {{ $data->sandbox == 0 ? 'selected' : '' }}>Production</option>
												<option value="1" {{ $data->sandbox == 1 ? 'selected' : '' }}>Sandbox</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="box-footer">
								<button type="button" class="btn btn-warning me-1">
								<i class="ti-trash"></i> Cancel
								</button>
								<button type="submit" class="btn btn-primary">
								<i class="ti-save-alt"></i> Save
								</button>
							</div>
						</form>
					</div>
				</div>
		    </div>
		    <!-- /.box -->			
		</div>
	</div>
</div>
@endsection

@push('scripts')
@endpush