<div class="form-group">
    @php
        $uniqueId = random_letters(60);
    @endphp

    <label for="{{$type}}__{{$name}}">{{$name}}</label>

    <textarea id="{{$uniqueId}}" rows="15" type="text" class="form-control" name="{{$type}}__{{$name}}" data-type="{{$type}}">{{$content}}</textarea>


    <script>
        if(window.ckeditorIds === undefined) window.ckeditorIds = [];

        ckeditorIds.push('{{$uniqueId}}');
    </script>
</div>
