@extends('layout.layout')
@section('content')
<div class="container">
    <div class="row justify-content-center">
    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                   <h2> {{ __('Contact Data') }}</h2>
                </div>
                <div class="card-body">
                <div class="row row-sm">
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
								<div class="card">
									<a href="#">
									<div class="card-body iconfont text-left">
										<div class="d-flex justify-content-between">
											<h6 class="card-title mb-3">Todays</h6>
										</div>
										<div class="d-flex mb-0">
											<div class="">
                                            @if(isset($Todays))
												<h4 class="mb-1 font-weight-bold">{{$Todays}}</h4>
											@endif
												</div>
											<div class="card-chart bg-primary-transparent brround ml-auto mt-0">
												<i class="typcn typcn-group-outline text-primary tx-24"></i>
											</div>
										</div>
									</div></a>
								</div>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
								<div class="card">
								<a href="#">
									<div class="card-body iconfont text-left">
										<div class="d-flex justify-content-between">
											<h6 class="card-title mb-3">Week</h6>
										</div>
										<div class="d-flex mb-0">
											<div class="">
                                                @if(isset($Week))
												<h4 class="mb-1 font-weight-bold">{{$Week}}</h4>
											@endif
                                        </div>
											<div class="card-chart bg-primary-transparent brround ml-auto mt-0">
												<i class="typcn typcn-shopping-cart text-primary tx-24"></i>
											</div>
										</div>
									</div>
								</a>
								</div>
							</div>
							<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12">
								<div class="card">
								<a href="#">
									<div class="card-body iconfont text-left">
										<div class="d-flex justify-content-between">
											<h6 class="card-title mb-3">Month</h6>
										</div>
										<div class="d-flex mb-0">
											<div class="">
                                            @if(isset($Month))
												<h4 class="mb-1 font-weight-bold">{{$Month}}</h4>
											@endif
											</div>
											<div class="card-chart bg-primary-transparent brround ml-auto mt-0">
												<i class="typcn typcn-shopping-cart text-primary tx-24"></i>
											</div>
										</div>
									</div>
								</div>
								</a>
							</div>
						</div>
						
            </div>
        </div>
    </div>
</div>

@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">

</script>
