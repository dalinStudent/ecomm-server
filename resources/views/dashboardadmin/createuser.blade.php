@extends('dashboardadmin.adminpage')
	@section('content')
    <div id="page-wrapper">
			<div class="main-page">
				<div class="forms">
					<h2 class="title1">Create User</h2>
					<div class="form-grids row widget-shadow" data-example-id="basic-forms"> 
						<div class="form-title">
                        <a href="{!!url('/userlist')!!}" type="sumit"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back</a>
						</div>
						<div class="form-body">
							<form>
                                <div class="form-group"> 
                                    <label for="exampleInputEmail1">Email address</label> 
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email"> 
                                </div> 
                                <div class="form-group"> 
                                    <label for="exampleInputPassword1">Password</label> 
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"> 
                                </div> 
                                <div class="form-group"> 
                                    <label for="exampleInputFile">File input</label> 
                                    <input type="file" id="exampleInputFile"> <p class="help-block">Example block-level help text here.</p> 
                                </div>
                                 <button type="submit" class="btn btn-primary">Submit</button> 
                            </form> 
						</div>
					</div>
				</div>
			</div>
		</div>
    @endsection