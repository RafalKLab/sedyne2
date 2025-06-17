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
        updatePreview();
    });
});

// Handle rotation
rotateBtn.addEventListener('click', () => {
    currentRotation = (currentRotation + 90) % 360;
    rotateBtn.innerText = `Rotate (${currentRotation}°)`;
    updatePreview();
});

// Create grid
let gridRows = 8;
let gridCols = 8;

function createGrid(rows, cols, callback = null) {
    container.innerHTML = '';

    // Set the CSS grid size
    container.style.gridTemplateColumns = `repeat(${cols}, 60px)`;
    container.style.gridTemplateRows = `repeat(${rows}, 60px)`;

    for (let row = 0; row < rows; row++) {
        for (let col = 0; col < cols; col++) {
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

        if (typeof callback === 'function') {
            // Delay to ensure browser renders DOM changes first
            setTimeout(() => callback(), 0);
        }
    }
}

document.getElementById('applyGridBtn').addEventListener('click', () => {
    const widthInput = document.getElementById('gridWidth');
    const heightInput = document.getElementById('gridHeight');

    const cols = parseInt(widthInput.value, 10);
    const rows = parseInt(heightInput.value, 10);

    if (
        Number.isInteger(cols) && cols > 0 && cols <= 32 &&
        Number.isInteger(rows) && rows > 0 && rows <= 32
    ) {
        gridRows = rows;
        gridCols = cols;
        createGrid(rows, cols);
    } else {
        alert("Width and height must be between 1 and 32.");
    }
});


document.getElementById('exportBtn').addEventListener('click', () => {

    alert('in progress');

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

        const row = Math.floor(index / gridCols);
        const col = index % gridCols;

        layout.push({
            row,
            col,
            type,
            rotation
        });
    });

    const exportData = {
        rows: gridRows,
        cols: gridCols,
        layout: layout
    };

    const blob = new Blob([JSON.stringify(exportData, null, 2)], { type: 'application/json' });
    const url = URL.createObjectURL(blob);

    const link = document.createElement('a');
    link.href = url;
    link.download = 'layout.json';
    link.click();

    URL.revokeObjectURL(url);
});

document.getElementById('importBtn').addEventListener('click', () => {
    document.getElementById('importFileInput').click();
});

document.getElementById('importFileInput').addEventListener('change', (event) => {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        try {
            const json = JSON.parse(e.target.result);
            if (!json.rows || !json.cols || !json.layout) {
                alert("Invalid file format.");
                return;
            }

            gridRows = json.rows;
            gridCols = json.cols;

            createGrid(gridRows, gridCols, () => {
                importLayout(json.layout);
            });

        } catch (err) {
            alert("Failed to parse JSON: " + err.message);
        }
    };

    reader.readAsText(file);
});


function importLayout(layout) {
    const cells = document.querySelectorAll('.cell');

    layout.forEach(item => {
        const {row, col, type, rotation} = item;
        const index = row * gridCols + col;
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

    const container = document.getElementById('grid');
    const cells = container.querySelectorAll('.cell');

    const layout = [];

    for (let r = 0; r < gridRows; r++) {
        for (let c = 0; c < gridCols; c++) {
            const index = r * gridCols + c;
            const cell = cells[index];
            if (!cell) continue;

            let type = 'empty';
            let rotation = 0;

            const content = cell.firstChild;
            if (content) {
                if (content.classList.contains('chair')) {
                    type = 'chair';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                    console.log(`Detected CHAIR at row: ${r}, col: ${c}, rotation: ${rotation}`);
                } else if (content.querySelector && content.querySelector('.monitor')) {
                    type = 'table-monitor';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                    console.log(`Detected TABLE-MONITOR at row: ${r}, col: ${c}, rotation: ${rotation}`);
                } else if (content.classList.contains('table')) {
                    type = 'table';
                    const match = content.style.transform.match(/rotate\((\d+)deg\)/);
                    rotation = match ? parseInt(match[1]) : 0;
                    console.log(`Detected TABLE at row: ${r}, col: ${c}, rotation: ${rotation}`);
                } else {
                    console.log(`Detected UNKNOWN element at row: ${r}, col: ${c}`);
                }
            } else {
                console.log(`EMPTY cell at row: ${r}, col: ${c}`);
            }

            layout.push({ row: r, col: c, type, rotation });
        }
    }


    const fullLayout = {
        rows: gridRows,
        cols: gridCols,
        layout: layout
    };

    document.getElementById('layoutJson').value = JSON.stringify(fullLayout);
    this.submit();
});

function updatePreview() {
    const preview = document.getElementById('preview');
    preview.innerHTML = '';

    let element;

    if (currentMode === 'chair') {
        element = document.createElement('div');
        element.className = 'chair';
        element.style.transform = `rotate(${currentRotation}deg)`;

        const seat = document.createElement('div');
        seat.className = 'seat';

        const backrest = document.createElement('div');
        backrest.className = 'backrest';

        const armrestL = document.createElement('div');
        armrestL.className = 'armrest-left';

        const armrestR = document.createElement('div');
        armrestR.className = 'armrest-right';

        element.appendChild(seat);
        element.appendChild(backrest);
        element.appendChild(armrestL);
        element.appendChild(armrestR);

    } else if (currentMode === 'table') {
        element = document.createElement('div');
        element.className = 'table';
        element.style.transform = `rotate(${currentRotation}deg)`;

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

        element = wrapper;
    } else if (currentMode === 'eraser') {
        preview.innerHTML = '<div style="color: #999; text-align: center; padding-top: 20px;">Eraser</div>';
        return;
    }

    preview.appendChild(element);
}

updatePreview();
createGrid(8,8);
