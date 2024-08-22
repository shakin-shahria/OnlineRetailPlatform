<html>
    <ul>
        @foreach ($weburl as $title => $link)
            <li><a href="{{ $link }}" target="_blank">{{ $title }}</a></li>
        @endforeach
    </ul>
</html>
