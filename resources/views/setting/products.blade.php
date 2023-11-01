@extends('layouts.master')
@section('css')
@section('title')
	Products
@endsection
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">Setting</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ Products</span>
						</div>
					</div>
					
				</div>
				<!-- breadcrumb -->
@endsection
@section('content')

				<!-- row -->
				@if (session()->has('Add'))
                <div class="alert alert-primary alert-dismissable fade show" role="alert">
						<strong>{{session()->get('Add')}}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="close">
					   <span aria-hidden="true">&times;</span>
					   </button>
	          	
                </div>

				@endif
				@if (session()->has('Edit'))
                <div class="alert alert-primary alert-dismissable fade show" role="alert">
						<strong>{{session()->get('Edit')}}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="close">
					   <span aria-hidden="true">&times;</span>
					   </button>
	          	
                </div>

				@endif
				@if (session()->has('delete'))
                <div class="alert alert-danger alert-dismissable fade show" role="alert">
						<strong>{{session()->get('delete')}}</strong>
						<button type="button" class="close" data-dismiss="alert" aria-label="close">
					   <span aria-hidden="true">&times;</span>
					   </button>
	          	
                </div>

                @endif
				<div class="row">
                    	<div class="col-xl-12">
								<div class="card mg-b-20">
										<div class="card-header pb-0">
												<div class="d-flex justify-content-between">
														<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#exampleModal">Add Product</a>
												</div>
											</div>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50';>
												<thead>
													<tr>
														<th class="border-bottom-0">#</th>
														<th class="border-bottom-0">Product Name</th>
														<th class="border-bottom-0">Section Name</th>
														<th class="border-bottom-0">Description</th>
														<th class="border-bottom-0">Operations</th>

													
													</tr>
												</thead>
												<tbody>
													<?php $i =0;?>
												
													
														@foreach ($products as $product)
														<?php $i++?>
													
														<tr>
														   <td>{{$i}}</td>
														   <td>{{$product->Product_name}}</td>
														   <td>{{$product->section->section_name}}</td>
															<td>{{$product->description}}</td>
															<td>
																<button class="btn btn-outline-success btn-sm"data-name="{{$product->Product_name}}" data-pro_id="{{$product->id}}"  data-section_name="{{$product->section->section_name}}"data-description="{{$product->description}}"data-toggle="modal"data-target="#editForm">Edit
																</button>
															    <button class="btn btn-outline-danger btn-sm"data-name="{{$product->Product_name}}" data-pro_id="{{$product->id}}" data-toggle="modal"data-target="#deleteForm">Delete
															    </button>
															</td>
														</tr>
															
														
														@endforeach
												
												
												</tbody>
											</table>
										</div>
									</div>
								</div>
						</div>
						   <!-- add -->
						   <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Add Product </h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
											<form action="{{route('products.store')}}" method="post">
										
											@csrf
											<div class="modal-body">
												<div class="form-group">
													<label for="exampleInputEmail1"> Product Name</label>
													<input type="text" class="form-control" id="product_name" name="Product_name" required >
		
												</div>
											
		
												<label class="my-1 mr-2" for="inlineFormCustomSelectPref">Section</label>
												<select name="section_id" id="section_id" class="form-control" required>
													<option value="" selected disabled> Select Section</option>
													@foreach ($sections as $section)
														<option value="{{ $section->id }}">{{ $section->section_name }}</option>
													@endforeach
												</select>
		
												<div class="form-group">
													<label for="exampleFormControlTextarea1">Description</label>
													<textarea class="form-control" id="product_description" name="description" rows="3"></textarea>
												</div>
		
											</div>
											<div class="modal-footer">
												<button type="submit" class="btn btn-success">Confirm</button>
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							   <!-- edit -->
							   <div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
								  <div class="modal-content">
								   <div class="modal-header">
									   <h5 class="modal-title" id="exampleModalLabel">Edit Partition</h5>
									   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
										   <span aria-hidden="true">&times;</span>
									   </button>
								   </div>
								<form action="products/update" method="post" autocomplete="off">
									   {{ method_field('patch') }}
									   {{ csrf_field() }}
									   <div class="modal-body">
			   
										   <div class="form-group">
											   <input type="hidden" name="pro_id" id="pro_id" value="">
											   <label for="recipient_name" class="col-from-label">Product Name</label>
											   <input type="text" class="form-control" name="Product_name" id="product_name">
										   </div>
										   <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Section</label>
										   <select name="section_name" id="section_name" class="form-control" required>
											   @foreach ($sections as $section)
												   <option>{{ $section->section_name }}</option>
											   @endforeach
										   </select>
										   <div class="form-group">
												<label for="message_text" class="col-from-label">Description</label>
												<textarea name="description" id="product_description" class="form-control"></textarea>
											</div>
									   </div>
									   <div class="modal-footer">
										   <button type="submit" class="btn btn-primary"> Edit Data</button>
										   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									   </div>
								   </form>
								  </div>
							   </div>
						</div>
				
					   <!-- delete -->
					   <div class="modal" id="deleteForm">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content modal-content-demo">
                                <div class="modal-header">
									<h6 class="modal-title">Delete Product</h6>
									<button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form action="products/destroy" method="post">
                                    {{method_field('delete')}}
                                    {{csrf_field()}}
                                    <div class="modal-body">
                                        <p>Are you sure to delete this section?</p><br>
                                        <input type="hidden" name="pro_id" id="pro_id" value="">
                                        <input class="form-control" name="Product_name" id="product_name" type="text" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Confirm</button>
                                    </div>
                            </div>
                            </form>
                        </div>
                    </div>
					
		

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
        $('#editForm').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_name = button.data('name')
			var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
			var product_description = button.data('description')

            var modal = $(this)
            modal.find('.modal-body #product_name').val(product_name);
			modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #product_description').val(product_description);
			modal.find('.modal-body #pro_id').val(pro_id);//# mean id not name

        });

	$('#deleteForm').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var product_name = button.data('name')
		var pro_id = button.data('pro_id')
		var modal = $(this)
		modal.find('.modal-body #pro_id').val(pro_id);
		modal.find('.modal-body #product_name').val(product_name);
	})
</script>

@endsection