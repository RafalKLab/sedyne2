<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Preview – {{ $space->name }}</title>
    <link rel="stylesheet" href="{{ asset('assets/space-builder.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/space-preview.css') }}">
</head>
<body>

<h1>Space: {{ $space->name }}</h1>

@php
    $layout = json_decode($space->layout, true);

    $cells = $layout['layout'];
    $cols = $layout['cols'];
    $rows = $layout['rows'];

    $grid = [];
    foreach ($layout['layout'] as $cell) {
        $grid[$cell['row']][$cell['col']] = $cell;
    }

    // Index seats by their layout index (as string)
    $seats = collect($space->seats)->keyBy('index');
@endphp

<div class="container" style="display: grid; grid-template-columns: repeat({{ $cols }}, 60px); grid-template-rows: repeat({{ $rows }}, 60px);">
    @for ($r = 0; $r < $rows; $r++)
        @for ($c = 0; $c < $cols; $c++)
            @php
                $cell = $grid[$r][$c] ?? null;
                $index = $r * $cols + $c;
                $seat = $seats->get((string) $index);
            @endphp

            <div class="cell">
                @if ($cell)
                    @switch($cell['type'])
                        @case('chair')
                            <div class="chair" style="transform: rotate({{ $cell['rotation'] }}deg);">
                                <div class="seat"></div>
                                <div class="backrest"></div>
                                <div class="armrest-left"></div>
                                <div class="armrest-right"></div>
{{--                                @if ($seat)--}}
{{--                                    <div style="position: absolute; bottom: 4px; right: 4px; background: #28a745; color: white; font-size: 10px; padding: 2px 4px; border-radius: 3px; z-index: 5;">--}}
{{--                                        ID: {{ $seat['id'] }}--}}
{{--                                    </div>--}}
{{--                                @endif--}}
                            </div>
                            @break

                        @case('table')
                            <div class="table" style="transform: rotate({{ $cell['rotation'] }}deg);"></div>
                            @break

                        @case('table-monitor')
                            <div style="width: 100%; height: 100%; position: relative; transform: rotate({{ $cell['rotation'] }}deg);">
                                <div class="table"></div>
                                <div class="monitor"></div>
                                <div class="keyboard"></div>
                                <div class="mouse"></div>
                            </div>
                            @break
                    @endswitch
                @endif
            </div>
        @endfor
    @endfor
</div>


</body>
</html>
