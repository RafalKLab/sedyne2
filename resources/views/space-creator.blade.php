<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Interactive Grid - Chair/Table Setup</title>
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

        .toolbar {
            margin-bottom: 10px;
        }

        .toolbar button {
            margin: 0 5px;
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        .toolbar button.active {
            background: #0056b3;
        }

        .container {
            width: 600px;
            height: 600px;
            border: 4px solid #333;
            display: grid;
            grid-template-columns: repeat(8, 1fr);
            grid-template-rows: repeat(8, 1fr);
            gap: 1px;
            background-color: #333;
        }

        .cell {
            background: #fff;
            position: relative;
            transition: background 0.2s;
        }

        .cell:hover {
            background: #cce5ff;
            cursor: pointer;
        }

        .chair {
            width: 100%;
            height: 100%;
            position: relative;
            transform-origin: center center;
            transition: transform 0.2s ease;
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
            width: 30%;
            height: 10%;
            background: #222;
            border-radius: 2px;
            top: 5%;
            left: 35%;
        }

        .armrest-left,
        .armrest-right {
            position: absolute;
            width: 8%;
            height: 35%;
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

        .toolbar form {
            display: inline;
        }

        #saveForm button {
            margin: 0 5px;
            padding: 8px 16px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            background: #28a745;
            color: white;
            cursor: pointer;
        }


    </style>
</head>
<body>

<div class="toolbar">
    <button data-mode="chair" class="active">Chair</button>
    <button data-mode="table">Table</button>
    <button data-mode="table-monitor">Table + Monitor</button>
    <button data-mode="eraser">Eraser</button>
    <button id="rotateBtn">Rotate (0°)</button>
    <button id="exportBtn">Export Layout</button>
    <button id="importBtn">Import Layout</button>

    <form id="saveForm" method="POST">
        @csrf
        <input type="hidden" name="layoutJson" id="layoutJson">
        <button type="submit">Save Layout</button>
    </form>

</div>

<div class="container" id="grid"></div>

<script>
    const container = document.getElementById('grid');
    const buttons = document.querySelectorAll('.toolbar button[data-mode]');
    const rotateBtn = document.getElementById('rotateBtn');

    let currentMode = 'chair';
    let currentRotation = 0;

    // Handle mode switching
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentMode = btn.getAttribute('data-mode');
        });
    });

    // Handle rotation
    rotateBtn.addEventListener('click', () => {
        currentRotation = (currentRotation + 90) % 360;
        rotateBtn.innerText = `Rotate (${currentRotation}°)`;
    });

    // Create grid
    for (let i = 0; i < 64; i++) {
        const cell = document.createElement('div');
        cell.className = 'cell';

        cell.addEventListener('click', () => {
            cell.innerHTML = '';

            if (currentMode === 'chair') {
                const chair = document.createElement('div');
                chair.className = 'chair';
                chair.style.transform = `rotate(${currentRotation}deg)`;

                const seat = document.createElement('div');
                seat.className = 'seat';

                const backrest = document.createElement('div');
                backrest.className = 'backrest';

                const armrestL = document.createElement('div');
                armrestL.className = 'armrest-left';

                const armrestR = document.createElement('div');
                armrestR.className = 'armrest-right';

                chair.appendChild(seat);
                chair.appendChild(backrest);
                chair.appendChild(armrestL);
                chair.appendChild(armrestR);
                cell.appendChild(chair);

            } else if (currentMode === 'table') {
                const table = document.createElement('div');
                table.className = 'table';
                table.style.transform = `rotate(${currentRotation}deg)`;
                cell.appendChild(table);

            } else if (currentMode === 'table-monitor') {
                const wrapper = document.createElement('div');
                wrapper.style.width = '100%';
                wrapper.style.height = '100%';
                wrapper.style.position = 'relative';
                wrapper.style.transform = `rotate(${currentRotation}deg)`;

                const table = document.createElement('div');
                table.className = 'table';

                const monitor = document.createElement('div');
                monitor.className = 'monitor';

                const keyboard = document.createElement('div');
                keyboard.className = 'keyboard';

                const mouse = document.createElement('div');
                mouse.className = 'mouse';

                wrapper.appendChild(table);
                wrapper.appendChild(monitor);
                wrapper.appendChild(keyboard);
                wrapper.appendChild(mouse);
                cell.appendChild(wrapper);
            } else if (currentMode === 'eraser') {
                cell.innerHTML = '';
            }
        });

        container.appendChild(cell);
    }

    document.getElementById('exportBtn').addEventListener('click', () => {
        const cells = document.querySelectorAll('.cell');
        const layout = [];

        cells.forEach((cell, index) => {
            let type = 'empty';
            let rotation = 0;

            const content = cell.firstChild;
            if (content) {
                if (content.classList.contains('chair')) {
                    type = 'chair';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                } else if (content.querySelector && content.querySelector('.monitor')) {
                    type = 'table-monitor';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                } else if (content.classList.contains('table')) {
                    type = 'table';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                }
            }

            const row = Math.floor(index / 8);
            const col = index % 8;

            layout.push({
                row,
                col,
                type,
                rotation
            });
        });

        console.log(JSON.stringify(layout, null, 2));
        alert("Full layout (with empty cells) exported to console!");
    });

    document.getElementById('importBtn').addEventListener('click', () => {
        const json = prompt("Paste layout JSON:");
        try {
            const layout = JSON.parse(json);
            importLayout(layout);
        } catch (e) {
            alert("Invalid JSON!");
        }
    });

    function importLayout(layout) {
        const cells = document.querySelectorAll('.cell');

        layout.forEach(item => {
            const { row, col, type, rotation } = item;
            const index = row * 8 + col;
            const cell = cells[index];
            cell.innerHTML = '';

            if (type === 'empty') return;

            if (type === 'chair') {
                const chair = document.createElement('div');
                chair.className = 'chair';
                chair.style.transform = `rotate(${rotation}deg)`;

                const seat = document.createElement('div');
                seat.className = 'seat';

                const backrest = document.createElement('div');
                backrest.className = 'backrest';

                const armrestL = document.createElement('div');
                armrestL.className = 'armrest-left';

                const armrestR = document.createElement('div');
                armrestR.className = 'armrest-right';

                chair.appendChild(seat);
                chair.appendChild(backrest);
                chair.appendChild(armrestL);
                chair.appendChild(armrestR);
                cell.appendChild(chair);

            } else if (type === 'table') {
                const table = document.createElement('div');
                table.className = 'table';
                table.style.transform = `rotate(${rotation}deg)`;
                cell.appendChild(table);

            } else if (type === 'table-monitor') {
                const wrapper = document.createElement('div');
                wrapper.style.width = '100%';
                wrapper.style.height = '100%';
                wrapper.style.position = 'relative';
                wrapper.style.transform = `rotate(${rotation}deg)`;

                const table = document.createElement('div');
                table.className = 'table';

                const monitor = document.createElement('div');
                monitor.className = 'monitor';

                const keyboard = document.createElement('div');
                keyboard.className = 'keyboard';

                const mouse = document.createElement('div');
                mouse.className = 'mouse';

                wrapper.appendChild(table);
                wrapper.appendChild(monitor);
                wrapper.appendChild(keyboard);
                wrapper.appendChild(mouse);
                cell.appendChild(wrapper);
            }
        });
    }

    document.getElementById('saveForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const cells = document.querySelectorAll('.cell');
        const layout = [];

        cells.forEach((cell, index) => {
            let type = 'empty';
            let rotation = 0;

            const content = cell.firstChild;
            if (content) {
                if (content.classList.contains('chair')) {
                    type = 'chair';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                } else if (content.querySelector && content.querySelector('.monitor')) {
                    type = 'table-monitor';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                } else if (content.classList.contains('table')) {
                    type = 'table';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                }
            }

            const row = Math.floor(index / 8);
            const col = index % 8;

            layout.push({
                row,
                col,
                type,
                rotation
            });
        });

        document.getElementById('layoutJson').value = JSON.stringify(layout);
        this.submit();
    });


</script>

</body>
</html>
