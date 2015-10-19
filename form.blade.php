@extends('layout')

@section('css')

    <style>

            .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
            .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
            .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}

    </style>

@endsection

@section('content')

    <div class="container">
        <div class="row">

            <div class=" col-md-12">

                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">FILE</h3>
                    </div>

                    <div class="panel-body">
                        @include('partials.errors')
                        {!! Form::open(['route'=> 'attachment.store', 'method' => 'POST', 'files'=>'true']) !!}

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">


                        {!! Form::hidden('user_id', $user->id) !!}

                        <div class="progress">
                            <div class="bar"></div >
                            <div class="percent">0%</div >
                        </div>

                        <div class="form-group">
                            <input name="poster" id="poster" type="file" class="form-control"><br/>
                            <input type="submit"  value="Submit" class="btn btn-success">
                        </div>


                        {!!Form::close()!!}
                    </div>
                </div>


            </div>
        </div>
    </div>




@endsection

@section('scripts')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>

function validate(formData, jqForm, options) {

    var form = jqForm[0];

    // Validate Not Null file input

    if (!form.poster.value) {
        alert('File not found');
        return false;
    }
}

(function() {

var bar = $('.bar');
var percent = $('.percent');
var status = $('#status');

$('form').ajaxForm({

    beforeSubmit: validate,

    beforeSend: function() {
        status.empty();
        var percentVal = '0%';
        var posterValue = $('input[name=poster]').fieldValue();
        bar.width(percentVal)
        percent.html(percentVal);
    },
    uploadProgress: function(event, position, total, percentComplete) {
        var percentVal = percentComplete + '%';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    success: function() {
        var percentVal = 'Wait, Saving';
        bar.width(percentVal)
        percent.html(percentVal);
    },
    complete: function(xhr) {
        status.html(xhr.responseText);
        window.location.href = "/home";

    }
});

})();
</script>

@endsection
