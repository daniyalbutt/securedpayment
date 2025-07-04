@extends('layouts.front-app')
@section('content')
<div class="container-fluid">
	<div class="row page-titles">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
			<li class="breadcrumb-item"><a href="javascript:void(0)">Invoice #{{ $data->id }}</a></li>
			<li class="breadcrumb-item active"><a href="javascript:void(0)">Show Response</a></li>
		</ol>
	</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Response <strong>Details</strong></h4>
                </div>
                <div class="card-body">
                    @if($data->merchants->merchant == 0)
                    @php
                    $getdata = json_decode($data->return_response, true);
                    $getcarddata = json_decode($data->payment_data, true);
                    @endphp
                    @if($getcarddata != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getcarddata as $key => $value)
                        <li>{{ $key }} => {{ is_array($value) ? '' : $value }}</li>
                        @endforeach
                        <li>}</li>
                    </ul>
                    @endif
                    @if($getdata != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getdata as $key => $value)
                        <li>{{ $key }} => 
                        @if(is_array($value))
                        </li>
                        <ul class="nested">
                            <li>{</li>
                            @foreach ($value as $inner_key => $inner_value)
                            <li>{{ $inner_key }} => {{ is_array($inner_value) ? '' : $inner_value }}</li>
                            @endforeach
                            <li>}</li>
                        </ul>
                        @else
                        {{ $value }} </li>
                        @endif
                        @endforeach
                        <li>}</li>
                    </ul>
                    @else
                    @php
                    $getdata_one = json_decode($data->square_response, true);
                    @endphp
                    @if($getdata_one != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getdata_one as $key => $value)
                        <li>{{ $key }} => 
                        @if(is_array($value))
                        </li>
                        <ul class="nested">
                            <li>{</li>
                            @foreach ($value as $inner_key => $inner_value)
                            <li>{{ $inner_key }} => {{ is_array($inner_value) ? '' : $inner_value }}</li>
                            @endforeach
                            <li>}</li>
                        </ul>
                        @else
                        {{ $value }} </li>
                        @endif
                        @endforeach
                        <li>}</li>
                    </ul>
                    @else
                    {{ $data->return_response }}
                    @endif
                    @endif
                    @elseif($data->merchants->merchant == 3)
                    @php
                    $getdata = json_decode($data->payment_data, true);
                    @endphp
                    @if($getdata != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getdata as $key => $value)
                        <li>{{ $key }} => {{ $value }}</li>
                        @endforeach
                        <li>}</li>
                    </ul>
                    @else
                    @php
                    $getdata = json_decode($data->square_response, true);
                    @endphp
                    @endif
                    @endif
                    @php
                    $getdata = json_decode($data->authorize_response, true);
                    @endphp
                    @if($data->merchants->merchant == 4)
                    @if($getdata != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getdata as $key => $value)
                        <li>{{ $key }} => 
                        @if(is_array($value))
                        </li>
                        <ul class="nested">
                            <li>{</li>
                            @foreach ($value as $inner_key => $inner_value)
                            <li>{{ $inner_key }} => {{ is_array($inner_value) ? '' : $inner_value }}
                            @if(is_array($inner_value))
                            </li>
                            <ul class="nested">
                                <li>{</li>
                                @foreach ($inner_value as $inner_inner_key => $inner_inner_value)
                                <li>{{ $inner_inner_key }} => {{ is_array($inner_inner_value) ? '' : $inner_inner_value }}
                                @if(is_array($inner_value))
                                </li>
                                <ul class="nested">
                                    <li>{</li>
                                    @foreach ($inner_inner_value as $inner_inner_inner_key => $inner_inner_inner_value)
                                    <li>{{ $inner_inner_inner_key }} => {{ is_array($inner_inner_inner_value) ? '' : $inner_inner_inner_value }}</li>
                                    @endforeach
                                    <li>}</li>
                                </ul>
                                @endif
                                @endforeach
                                <li>}</li>
                            </ul>
                            @endif
                            @endforeach
                            <li>}</li>
                        </ul>
                        @else
                        {{ $value }} </li>
                        @endif
                        @endforeach
                        <li>}</li>
                    </ul>
                    @endif
                    @php
                    $payment_data = json_decode($data->payment_data, true);
                    @endphp
                    @if($payment_data != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($payment_data as $key => $value)
                        <li>{{ $key }} => {{ $value }}</li>
                        @endforeach
                        <li>}</li>
                    </ul>
                    @endif
                    @endif
                    
                    @if($data->merchants->merchant == 2)
                    @php
                    $getdata = json_decode($data->return_response, true);
                    @endphp
                    @if($getdata != null)
                    <ul class="return-response">
                        <li>{</li>
                        @foreach ($getdata as $key => $value)
                        <li>{{ $key }} => 
                        @if(is_array($value))
                        </li>
                        <ul class="nested">
                            <li>{</li>
                            @foreach ($value as $inner_key => $inner_value)
                            <li>{{ $inner_key }} => {{ is_array($inner_value) ? '' : $inner_value }}</li>
                            @endforeach
                            <li>}</li>
                        </ul>
                        @else
                        {{ $value }} </li>
                        @endif
                        @endforeach
                        <li>}</li>
                    </ul>
                    @endif
                    @endif

                    @if($data->merchants->merchant == 5)
                    @php
                    $return_data = json_decode($data->return_response, true);
                    $payment_data = json_decode($data->payment_data, true);
                    function displayData($data, $level = 0) {
                        $output = '';
                        foreach($data as $key => $value) {
                            $indent = str_repeat('&nbsp;', $level * 4);
                            $output .= '<div class="mb-2">';
                            $output .= $indent . '<strong class="text-capitalize">' . str_replace('_', ' ', $key) . ':</strong> ';
                            
                            if(is_array($value)) {
                                $output .= '<div class="ms-4">' . displayData($value, $level + 1) . '</div>';
                            } else {
                                $output .= '<span>' . ($value ?? 'N/A') . '</span>';
                            }
                            
                            $output .= '</div>';
                        }
                        return $output;
                    }
                    
                    $paymentArray = json_decode(json_encode($return_data), true);
                    $paymentDataArray = json_decode(json_encode($payment_data), true);
                    @endphp
                    @if($return_data != null)
                    @if($data->status == 2)
                        {!! displayData($paymentArray) !!}
                        <hr>
                        {!! displayData($paymentDataArray) !!}
                    @endif
                    @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush