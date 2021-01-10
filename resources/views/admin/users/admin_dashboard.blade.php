@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
	<!-- Main Container -->
    <div class="main-container">    	    	
        <div class="row mb-3 justify-content-center">
        	<div class="card mb-3 col-md-8 card-margin-top">
                <div class="card-body">
                    <h4 class="card-title">Dashboard</h4>
                    <table class="table table-bordered">
                        <thead>
	                        <tr>
	                            <th scope="col">Total Users</th>
	                            <td scope="col">{{ $total_users }}</th>
	                        </tr>
                        </thead>
                        <tbody>
	                        <tr>
	                            <th scope="col">Last Active User</th>
	                            <td scope="col">
	                            	@if ($last_active_user == null)
							    		0 Active Users
						    		@else
								    	{{ $last_active_user->name }} at {{ $last_active_user->last_logged_in_at }}
							    	@endif
	                            </th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Number of Uploads last day</th>
	                            <td scope="col">{{ $number_of_image_uploads_for_the_last_day }}</th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Number of Uploads last week</th>
	                            <td scope="col">{{ $number_of_image_uploads_for_the_last_week }}</th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Number of Uploads last month</th>
	                            <td scope="col">{{ $number_of_image_uploads_for_the_last_month }}</th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Number of Uploads last quarter</th>
	                            <td scope="col">{{ $number_of_image_uploads_for_the_last_quarter }}</th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Number of Uploads last year</th>
	                            <td scope="col">{{ $number_of_image_uploads_for_the_last_year }}</th>
	                        </tr>
	                        <tr>
	                            <th scope="col">Total number of uploads</th>
	                            <td scope="col">{{ $total_number_of_image_uploads }}</th>
	                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        	
    </div>
@endsection