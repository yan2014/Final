@extends('layouts.app')

@section('content')
<section class="container">
    <a href="{{ url('article/create') }}" role="btn" class="btn btn-primary pull-right">Add</a>
    <table class="table table-hover">
    	@foreach($query as $var)
        {{-- {{var_dump($var)}} --}}
    		<tr>
    			<td>{{ $var->id }}</td>
    			<td>{{ $var->title }}</td>
    			<td><a href="{{ url('article/'.$var->id.'/edit')}}" role="btn" class="btn btn-warning">Edit</a></td>
                <form action="{{ url('article/'.$var->id) }}" method="post">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
                    <input type="hidden" name="_method" value="delete"></input>
                    <td><input type="submit" role="btn" class="btn btn-danger" value="Delete"></input></td>
                </form>
    			<?php
                    $a=array();
                    array_push($a,$var->updated_at);
                    print_r($a);
                    echo "</br>";
                ?>
    		</tr>
    	@endforeach
    </table>
</section>
@endsection