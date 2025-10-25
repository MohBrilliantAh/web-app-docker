<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Web App</title>
    <!-- Memuat Tailwind CSS untuk Styling Modern -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gaya khusus untuk memastikan display tidak horizontal scroll */
        .calculator {
            max-width: 400px;
        }
        #display {
            /* Pastikan font terlihat besar dan mudah dibaca */
            font-family: 'Inter', sans-serif;
            min-height: 80px;
            font-size: 2.5rem; 
            overflow-x: auto; /* Memungkinkan scroll horizontal jika angka terlalu panjang */
            white-space: nowrap; /* Mencegah wrap teks */
        }
        /* Menggunakan CSS custom untuk responsifitas yang lebih baik pada tombol */
        .grid-container {
            grid-template-columns: repeat(4, 1fr);
        }
        /* Efek tombol saat ditekan */
        button:active {
            transform: scale(0.95);
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <!-- Kontainer Kalkulator -->
    <div class="calculator w-full bg-white shadow-xl rounded-2xl p-6 transition-all duration-300 transform hover:shadow-2xl">
        
        <h1 class="text-2xl font-bold text-center text-gray-800 mb-6 border-b pb-2">Mesin Hitung Mas Brilli</h1>

        <!-- Area Tampilan Hasil -->
        <input type="text" id="display" readonly 
               class="w-full mb-6 p-4 text-right bg-gray-50 border-2 border-indigo-500 rounded-lg focus:outline-none focus:ring-4 focus:ring-indigo-200 transition-all duration-300 text-gray-900">

        <!-- Tombol-tombol Kalkulator -->
        <div id="buttons-container" class="grid grid-container gap-3">
            
            <!-- Baris 1: Clear, Operator -->
            <button onclick="clearDisplay()" class="bg-red-500 hover:bg-red-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200 col-span-2">C (Clear)</button>
            <button onclick="appendToDisplay('(')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg p-4 transition-colors duration-200">(</button>
            <button onclick="appendToDisplay(')')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg p-4 transition-colors duration-200">)</button>
            
            <!-- Baris 2: Angka 7, 8, 9, Bagi -->
            <button onclick="appendToDisplay('7')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">7</button>
            <button onclick="appendToDisplay('8')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">8</button>
            <button onclick="appendToDisplay('9')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">9</button>
            <button onclick="appendToDisplay('/')" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200 operator">÷</button>

            <!-- Baris 3: Angka 4, 5, 6, Kali -->
            <button onclick="appendToDisplay('4')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">4</button>
            <button onclick="appendToDisplay('5')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">5</button>
            <button onclick="appendToDisplay('6')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">6</button>
            <button onclick="appendToDisplay('*')" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200 operator">×</button>
            
            <!-- Baris 4: Angka 1, 2, 3, Kurang -->
            <button onclick="appendToDisplay('1')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">1</button>
            <button onclick="appendToDisplay('2')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">2</button>
            <button onclick="appendToDisplay('3')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">3</button>
            <button onclick="appendToDisplay('-')" class="bg-indigo-500 hover:bg-indigo-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200 operator">-</button>

            <!-- Baris 5: Angka 0, Koma, Sama Dengan, Tambah -->
            <button onclick="appendToDisplay('0')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200 col-span-2">0</button>
            <button onclick="appendToDisplay('.')" class="bg-gray-700 hover:bg-gray-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">.</button>
            <button onclick="calculate()" class="bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg p-4 transition-colors duration-200">=</button>
            
        </div>
    </div>

    <script>
        // Ambil elemen tampilan (display input) dari HTML
        const display = document.getElementById('display');

        /**
         * Menambahkan nilai tombol (angka atau operator) ke layar tampilan.
         * @param {string} value - Nilai yang akan ditambahkan.
         */
        function appendToDisplay(value) {
            display.value += value;
        }

        /**
         * Mengosongkan layar tampilan (tombol C).
         */
        function clearDisplay() {
            display.value = '';
        }

        /**
         * Menghitung ekspresi matematika yang ada di layar.
         */
        function calculate() {
            try {
                // Menggunakan eval() untuk evaluasi ekspresi string matematika.
                // Dalam aplikasi production, evaluasi server-side lebih aman,
                // tetapi eval() adalah cara tercepat untuk kalkulator sederhana di frontend.
                let result = eval(display.value);
                
                // Memastikan hasil ditampilkan dengan presisi yang wajar untuk pecahan
                if (Number.isFinite(result)) {
                    // Batasi hingga 8 angka di belakang koma untuk hasil pecahan
                    display.value = parseFloat(result.toFixed(8)); 
                } else {
                    display.value = result;
                }

            } catch (e) {
                // Menampilkan pesan error jika ekspresi tidak valid (misalnya: 1 + *)
                display.value = 'Error';
            }
        }
        
        // Opsional: Menambahkan dukungan input dari keyboard
        document.addEventListener('keydown', (event) => {
            const key = event.key;
            
            // Angka dan operator dasar
            if (/[0-9]|\+|\-|\*|\/|\.|\(|\)/.test(key)) {
                appendToDisplay(key);
            } else if (key === 'Enter' || key === '=') {
                event.preventDefault(); // Mencegah form submit/refresh
                calculate();
            } else if (key === 'c' || key === 'C' || key === 'Escape') {
                clearDisplay();
            } else if (key === 'Backspace') {
                // Menghapus satu karakter terakhir
                display.value = display.value.slice(0, -1);
            }
        });

    </script>
</body>
</html>
