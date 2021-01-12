<div class="form-group">
    <label for="{{$type}}__{{$name}}">{{$name}}</label>
    <input
            type="file"
            id="{{$type}}__{{$name}}"
            name="{{$type}}__{{$name}}"
            class="dropify"
            data-height="100"
            data-allowed-file-extensions="svg png jpg jpeg"
            data-default-file="@if($content) {{url($content)}}@endif">

    <input type="hidden" name="{{$type}}__{{$name}}" value="{{$content ?? ''}}">


</div>
