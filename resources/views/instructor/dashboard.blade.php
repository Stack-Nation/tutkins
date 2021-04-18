@extends('layouts.authApp')
@section("title","Instructor Dashboard")
@section('content')
<div class="ml-4">
<div class="box bg-primary-light">
						<div class="box-body d-flex px-0">
							<div class="flex-grow-1 p-30 flex-grow-1 bg-img dask-bg bg-none-md" style="background-position: right bottom; background-size: auto 100%; background-image: url(https://www.multipurposethemes.com/admin/eduadmin-template/images/svg-icon/color-svg/custom-1.svg)">
								<div class="row">
									<div class="col-12 col-xl-7"> <?php $user = Auth::user(); ?>
										<h2>Welcome back, <strong>{{$user->name}}!</strong></h2>

										<p class="text-dark my-10 font-size-16">
											You have created <strong class="text-warning">{{$user->courses->count()}}</strong> Courses.
										</p>
										<p class="text-dark my-10 font-size-16">
											Let's Create <strong class="text-warning">Mentoring Program</strong>
										</p>
									</div>
									<div class="col-12 col-xl-5"></div>
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
						<div class="col-xl-6">
							<div class="box">
								<div class="box-body d-flex p-0">
									<div class="flex-grow-1 bg-danger p-30 flex-grow-1 bg-img" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 100%; background-image: url(https://www.multipurposethemes.com/admin/eduadmin-template/images/svg-icon/color-svg/custom-3.svg)">

										<h4 class="font-weight-400">User Activity</h4>

										<p class="my-10 font-size-16">
											Grow marketing &amp; sales<br>through product.
										</p>

										<a href="#" class="btn btn-danger-light">Read More</a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6">
							<div class="box">
								<div class="box-body d-flex p-0">
								<div class="flex-grow-1 bg-primary p-30 flex-grow-1 bg-img" style="background-position: calc(100% + 0.5rem) bottom; background-size: auto 100%; background-image: url(https://www.multipurposethemes.com/admin/eduadmin-template/images/svg-icon/color-svg/custom-4.svg)">

									<h4 class="font-weight-400">Based On</h4>

									<div class="mt-5">
										<div class="d-flex mb-10 font-size-16">
											<span class="icon-Arrow-right mt-5 mr-10"><span class="path1"></span><span class="path2"></span></span>
											<span class="text-white">Activities</span>
										</div>

										<div class="d-flex mb-10 font-size-16">
											<span class="icon-Arrow-right mt-5 mr-10"><span class="path1"></span><span class="path2"></span></span>
											<span class="text-white">Sales</span>
										</div>

										<div class="d-flex mb-10 font-size-16">
											<span class="icon-Arrow-right mt-5 mr-10"><span class="path1"></span><span class="path2"></span></span>
											<span class="text-white">Releases</span>
										</div>
									</div>
								</div>
								</div>
							</div>
						</div>
					</div>
                    <div class="box">
						<div class="box-body">							
							<div class="box no-shadow mb-0">
								<div class="box-body px-0 pt-0">
									<div id="calendar" class="dask evt-cal min-h-400"></div>
								</div>
							</div>
                            <div class="box no-shadow mb-0 px-10">
								<div class="box-header no-border">
									<h4 class="box-title">Lessons</h4>							
									<div class="box-controls pull-right d-md-flex d-none">
									  <a href="#">View All</a>
									</div>
								</div>
							</div>
							<div class="px-10">
								<div class="box mb-15">
									<div class="box-body">
										<div class="d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="mr-15 bg-warning h-50 w-50 l-h-60 rounded text-center">
													<span class="icon-Book-open font-size-24"><span class="path1"></span><span class="path2"></span></span>
												</div>
												<div class="d-flex flex-column font-weight-500">
													<a href="#" class="text-dark hover-primary mb-1 font-size-16">Informatic Course</a>
													<span class="text-fade">Johen Doe, 19 April</span>
												</div>
											</div>
											<a href="#">
												<span class="icon-Arrow-right font-size-24"><span class="path1"></span><span class="path2"></span></span>
											</a>
										</div>
									</div>
								</div>
								<div class="box mb-15">
									<div class="box-body">
										<div class="d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="mr-15 bg-primary h-50 w-50 l-h-60 rounded text-center">
													<span class="icon-Mail font-size-24"></span>
												</div>
												<div class="d-flex flex-column font-weight-500">
													<a href="#" class="text-dark hover-primary mb-1 font-size-16">Live Drawing</a>
													<span class="text-fade">Micak Doe, 12 June</span>
												</div>
											</div>
											<a href="#">
												<span class="icon-Arrow-right font-size-24"><span class="path1"></span><span class="path2"></span></span>
											</a>
										</div>
									</div>
								</div>
								<div class="box mb-0">
									<div class="box-body">
										<div class="d-flex align-items-center justify-content-between">
											<div class="d-flex align-items-center">
												<div class="mr-15 bg-danger h-50 w-50 l-h-60 rounded text-center">
													<span class="icon-Book-open font-size-24"><span class="path1"></span><span class="path2"></span></span>
												</div>
												<div class="d-flex flex-column font-weight-500">
													<a href="#" class="text-dark hover-primary mb-1 font-size-16">Contemporary Art</a>
													<span class="text-fade">Potar doe, 27 July</span>
												</div>
											</div>
											<a href="#">
												<span class="icon-Arrow-right font-size-24"><span class="path1"></span><span class="path2"></span></span>
											</a>
										</div>
									</div>
								</div>
							</div>
                            
</div>
                    </div>
@endsection