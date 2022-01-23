@extends('layouts.master')
@section('title')
المنتجات
@endsection
@section('css')

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
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/المنتجات</span>
						</div>
					</div>
					</div>
@endsection
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

				<!-- row -->
				<div class="row">

				@if(Session::has('success'))
        <div class="alert alert-success" role="alert">
        {{Session::get('success')}}
</div>

@endif


<!-- تاكيد الحذف -->
@if(Session::has('delete'))
        <div class="alert alert-danger" role="alert">
        {{Session::get('delete')}}
</div>

@endif
		




<!--div-->
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
							<div class="col-sm-6 col-md-4 col-xl-3">
								
										<a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">اضافة منتج</a>
									
								</div>
								
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example1" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
												<th class="border-bottom-0">الرقم</th>
												<th class="border-bottom-0">اسم المنتج </th>
												<th class="border-bottom-0">اسم القسم </th>
												<th class="border-bottom-0">الوصف </th>
												<th class="border-bottom-0">العمليات </th>
												
											</tr>
										</thead>

										<tbody>
											@foreach($productes as $product)
											<tr>
												<td>{{$product->id}}</td>
												<td>{{$product->Product_name}}</td>
												<td>{{$product->section->section_name}}</td>
												<td>{{$product->description}}</td>
												<td>
												


												<button class="btn btn-outline-success btn-sm"
                                                    data-name="{{  $product->Product_name }}"data-pro_id="{{ $product->id }}"
                                                    data-section_name="{{$product->section->section_name}}"
                                                    data-description="{{  $product->description }}" data-toggle="modal"
                                                    data-target="#modaldemo9">تعديل</button>
													
													<button class="btn btn-outline-danger btn-sm"
                                                    data-name="{{  $product->Product_name }}" data-pro_id="{{ $product->id }}"
                                                    data-section_name="{{  $product->section->section_name }}"
                                                    data-description="{{  $product->description }}" data-toggle="modal"
                                                    data-target="#modaldemo7">حذف</button>




                                                     


</td>

												</tr>

@endforeach
										<tbody>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!--/div-->

					<!--div-->
					
				</div>

				</div>

				<div class="modal" id="modaldemo8">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form action="{{ route('insertproduct') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم  المنتج</label>
                            <input type="text" class="form-control" id="section_name" name="Product_name">
							@error('section_name')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                        </div>

						
						<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="section_id" id="section_id" class="form-control" required>
                                <option value="" selected disabled> --حدد القسم--</option>
                                @foreach ($sections as $section)
                                    <option value="{{ $section->id }}">{{ $section->section_name }}</option>
                                @endforeach
                            </select>


                           
							@error('section_name')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                       
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
							@error('description')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->
		
  
   <div class="modal" id="modaldemo9">

			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
					<form action="{{route('updateproduct')}}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
						
                            <label for="exampleInputEmail1">اسم  المنتج</label>
							<input type="hidden" class="form-control" name="pro_id" id="pro_id" value="">
                            <input type="text" class="form-control" id="Product_name" name="Product_name">
							@error('section_name')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                        </div>

						
						<label class="my-1 mr-2" for="inlineFormCustomSelectPref">القسم</label>
                            <select name="section_id" id="section_name" class="form-control" required>
                                <option value="" selected disabled> --حدد القسم--</option>
                                @foreach ($sections as $section)
                                    <option>{{ $section->section_name }}</option>
                                @endforeach
                            </select>


                           
							@error('section_name')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                       
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">ملاحظات</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
							@error('description')
    <small  class="form-text text-danger">{{$message}}</small>
    @enderror

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success">تعديل البيانات</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>
                    </form>
					</div>
				</div>
			</div>
		</div>
		<!-- End Basic modal --> 


		
        <!-- delete -->
        <div class="modal fade" id="modaldemo7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">حذف المنتج</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('deleteproduct')}}" >
                     
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <p>هل انت متاكد من عملية الحذف ؟</p><br>
                            <input type="text" name="pro_id" id="pro_id" value="">
                            <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حذف المنتج</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق </button>
                            
                        </div>
                    </form>
                </div>
            </div>
       



			
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



 <script>
        $('#modaldemo9').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var Product_name = button.data('name')
            var section_name = button.data('section_name')
            var pro_id = button.data('pro_id')
            var description = button.data('description')
            var modal = $(this)
            modal.find('.modal-body #Product_name').val(Product_name);
            modal.find('.modal-body #section_name').val(section_name);
            modal.find('.modal-body #description').val(description);
            modal.find('.modal-body #pro_id').val(pro_id);
        })

$('#modaldemo7').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var pro_id = button.data('pro_id')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #pro_id').val(pro_id);
            modal.find('.modal-body #product_name').val(name);
        });
</script>




@endsection