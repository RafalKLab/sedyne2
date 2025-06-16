<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Space Preview – {{ $space->name }}</title>
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
            background: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .container {
            width: 600px;
            height: 600px;
            border: 4px solid #333;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(8, 1fr);
            background-color: #333;
        }

        .cell {
            background: #fff;
            position: relative;
            border: none;
        }

        .chair {
            width: 100%;
            height: 100%;
            position: relative;
            transform-origin: center center;
        }

        .seat {
            position: absolute;
            width: 50%;
            height: 50%;
            background: #444;
            border-radius: 4px;
            top: 25%;
            left: 25%;
        }

        .backrest {
            position: absolute;
            width: 40%;
            height: 10%;
            background: #222;
            border-radius: 2px;
            top: 5%;
            left: 30%;
        }

        .armrest-left,
        .armrest-right {
            position: absolute;
            width: 8%;
            height: 25%;
            background: #222;
            border-radius: 2px;
            top: 32.5%;
            z-index: 2;
        }

        .armrest-left {
            left: 10%;
        }

        .armrest-right {
            right: 10%;
        }


        .table {
            width: 100%;
            height: 100%;
            background: #bbb;
            position: absolute;
            top: 0;
            left: 0;
            border-radius: 6px;
            box-shadow: inset 0 0 4px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .monitor {
            width: 40%;
            height: 25%;
            background: #222;
            position: absolute;
            top: 15%;
            left: 30%;
            border-radius: 4px;
            z-index: 2;
        }

        .keyboard {
            width: 45%;
            height: 10%;
            background: #666;
            position: absolute;
            top: 50%;
            left: 20%;
            border-radius: 3px;
            z-index: 2;
        }

        .mouse {
            width: 10%;
            height: 12%;
            background: #888;
            position: absolute;
            top: 50%;
            left: 75%;
            border-radius: 50%;
            z-index: 2;
        }
    </style>
</head>
<body>

<h1>Space: {{ $space->name }}</h1>

@php
    $cells = json_decode($space->layout, true);

    // Index seats by their layout index (as string)
    $seats = collect($space->seats)->keyBy('index');
@endphp

<div class="container">
    @foreach ($cells as $index => $cell)
        <div class="cell">
            @php
                $seat = $seats->get((string) $index);
            @endphp

            @if ($cell['type'] === 'chair')
                <div class="chair" style="transform: rotate({{ $cell['rotation'] }}deg);">
                    <div class="seat"></div>
                    <div class="backrest"></div>
                    <div class="armrest-left"></div>
                    <div class="armrest-right"></div>
                    @if ($seat)
                        {{-- Example visual marker for an assigned seat --}}
                        <div style="
                        position: absolute;
                        bottom: 4px;
                        right: 4px;
                        background: #28a745;
                        color: white;
                        font-size: 10px;
                        padding: 2px 4px;
                        border-radius: 3px;
                        z-index: 5;
                    ">
                            ID: {{ $seat['id'] }}
                        </div>
                    @endif
                </div>
            @elseif ($cell['type'] === 'table')
                <div class="table" style="transform: rotate({{ $cell['rotation'] }}deg);"></div>
            @elseif ($cell['type'] === 'table-monitor')
                <div style="width: 100%; height: 100%; position: relative; transform: rotate({{ $cell['rotation'] }}deg);">
                    <div class="table"></div>
                    <div class="monitor"></div>
                    <div class="keyboard"></div>
                    <div class="mouse"></div>
                </div>
            @endif
        </div>
    @endforeach
</div>

</body>
</html>
