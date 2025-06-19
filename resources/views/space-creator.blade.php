<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Grid - Chair/Table Setup</title>
    <link rel="stylesheet" href="{{ asset('assets/space-body.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/space-builder.css') }}">
</head>
<body>

<div class="dimension-input" style="margin: 10px 0; display: flex; align-items: center; gap: 8px;">
    <label for="gridWidth">Width:</label>
    <input
        type="number"
        id="gridWidth"
        min="1"
        max="32"
        value="8"
        style="width: 60px; padding: 4px;"
    />

    <label for="gridHeight">Height:</label>
    <input
        type="number"
        id="gridHeight"
        min="1"
        max="32"
        value="8"
        style="width: 60px; padding: 4px;"
    />

    <button id="applyGridBtn" class="tool-button">Apply</button>
</div>

<div class="toolbar">
    <div class="toolbar-left">
        <button data-mode="chair" class="tool-button active">Chair</button>
        <button data-mode="table" class="tool-button">Table</button>
        <button data-mode="table-monitor" class="tool-button">Table + Monitor</button>
        <button data-mode="eraser" class="tool-button">Eraser</button>
    </div>

    <div class="toolbar-center">
        <div id="preview" class="cell preview"></div>
        <button id="rotateBtn" class="tool-button">Rotate (0°)</button>
    </div>

    <div class="toolbar-right">
        <button id="exportBtn" class="tool-button gray">Export</button>
        <button id="importBtn" class="tool-button gray">Import</button>
        <input type="file" id="importFileInput" accept=".json" style="display: none;">


        <form id="saveForm" method="POST">
            @csrf
            <input type="hidden" name="layoutJson" id="layoutJson">
            <button type="submit" class="tool-button green">Save Layout</button>
        </form>
    </div>
</div>

<div class="office-container" id="grid"></div>

<script src="{{ asset('js/space-builder.js') }}"></script>
</body>
</html>
