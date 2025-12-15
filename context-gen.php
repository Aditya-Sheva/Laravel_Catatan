<?php

// =================================================================================
// ULTIMATE LARAVEL CONTEXT GENERATOR (DEEP SCAN MODE)
// =================================================================================
// Fitur:
// 1. Project Map: Memetakan struktur folder (agar AI paham hierarki).
// 2. Deep Content Reading: Membaca file logika, config, test, dan view.
// 3. Smart Exclusion: Tetap mengamankan .env dan mengabaikan binary 'vendor'.
// =================================================================================

// --- KONFIGURASI ---
$outputFile = 'FULL_PROJECT_CONTEXT_DEEP.txt';

// Folder yang HANYA dipetakan strukturnya (Nama file dicatat, Isi TIDAK dibaca)
// Ini agar AI tau anda punya aset gambar/font tertentu tanpa baca binarinya.
$structureOnlyFolders = [
    'public',
    'storage',
    'node_modules' 
];

// Folder yang BENAR-BENAR DIABAIKAN (Tidak dicatat sama sekali)
$ignoredFolders = [
    '.git',
    '.idea',
    '.vscode',
    'vendor', // Tetap diabaikan isinya karena AI sudah tau cara kerja Laravel Core
    'build'
];

// File yang DIABAIKAN
$ignoredFiles = [
    '.env',             // SAFETY FIRST: Jangan pernah upload ini
    'package-lock.json',
    'composer.lock',    // Cukup baca composer.json
    'context-generator-full.php',
    $outputFile,
    '.DS_Store',
    'Thumbs.db'
];

// Ekstensi yang DIBACA ISINYA (Expanded for Full Context)
$allowedExtensions = [
    // Backend
    'php', 'sql',
    // Frontend
    'blade.php', 'js', 'jsx', 'ts', 'tsx', 'vue', 'svelte',
    // Styling
    'css', 'scss', 'sass', 'less', 'tailwind.config.js',
    // Config & Data
    'json', 'xml', 'yml', 'yaml', 'env.example', 'gitignore', 'htaccess'
];

// --- FUNGSI PEMBANTU ---

function getRelativePath($path) {
    return str_replace(getcwd() . DIRECTORY_SEPARATOR, '', $path);
}

function shouldIgnore($path) {
    global $ignoredFolders, $ignoredFiles;
    $basename = basename($path);
    if (in_array($basename, $ignoredFiles)) return true;
    foreach ($ignoredFolders as $folder) {
        if (strpos($path, DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR) !== false || 
            strpos($path, $folder . DIRECTORY_SEPARATOR) === 0 ||
            $basename === $folder) {
            return true;
        }
    }
    return false;
}

// Fungsi 1: Membuat Peta Struktur Folder (Tree View)
function generateProjectTree($dir, $prefix = '') {
    global $ignoredFolders, $structureOnlyFolders;
    $result = "";
    $files = scandir($dir);
    $files = array_diff($files, ['.', '..']); // Hapus . dan ..

    // Filter file yang diignore total
    $filteredFiles = [];
    foreach($files as $file) {
        if (!in_array($file, $ignoredFolders) && $file !== '.git') {
            $filteredFiles[] = $file;
        }
    }

    $count = count($filteredFiles);
    $i = 0;

    foreach ($filteredFiles as $file) {
        $i++;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        $isLast = ($i == $count);
        $marker = $isLast ? "└── " : "├── ";
        
        $result .= $prefix . $marker . $file . "\n";
        
        // Rekursif jika folder, TAPI cek apakah folder itu masuk 'Structure Only'
        if (is_dir($path)) {
            // Jika masuk structureOnly, kita tidak masuk lebih dalam (shallow) 
            // atau masuk tapi tandai sebagai aset (tergantung preferensi, di sini kita masuk)
            $newPrefix = $prefix . ($isLast ? "    " : "│   ");
            
            // Khusus node_modules/vendor/public/storage, kita batasi kedalamannya di tree
            // agar tidak ada ribuan baris teks tree.
            if (in_array($file, ['vendor', 'node_modules'])) {
                 $result .= $newPrefix . "└── [Dependencies Omitted for Brevity]\n";
            } else {
                 $result .= generateProjectTree($path, $newPrefix);
            }
        }
    }
    return $result;
}

// Fungsi 2: Memindai Konten File
function scanFileContents($dir, &$results = []) {
    global $ignoredFolders, $ignoredFiles, $allowedExtensions, $structureOnlyFolders;

    $files = scandir($dir);

    foreach ($files as $file) {
        if ($file == '.' || $file == '..') continue;
        $path = realpath($dir . DIRECTORY_SEPARATOR . $file);
        $relativePath = getRelativePath($path);

        if (shouldIgnore($relativePath)) continue;

        if (is_dir($path)) {
            // Jika folder ini masuk kategori 'Structure Only', jangan baca isinya
            if (in_array($file, $structureOnlyFolders)) continue;
            
            scanFileContents($path, $results);
        } else {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            if (str_contains($file, '.blade.php')) $ext = 'blade.php'; // Handle blade

            if (in_array($ext, $allowedExtensions)) {
                $results[] = $path;
            }
        }
    }
    return $results;
}

// --- EKSEKUSI ---

echo "🚀 Memulai Deep Scan Project Laravel...\n";

// 1. Buat Header & Peta Struktur
$header  = "=================================================================================\n";
$header .= "PROJECT: LARAVEL DEEP CONTEXT ANALYSIS\n";
$header .= "DATE: " . date('Y-m-d H:i:s') . "\n";
$header .= "=================================================================================\n\n";

echo "🌳 Membuat Peta Struktur Folder...\n";
$treeMap = "--- PROJECT STRUCTURE (DIRECTORY TREE) ---\n";
$treeMap .= ".\n" . generateProjectTree(getcwd());
$treeMap .= "\n=================================================================================\n\n";

// 2. Baca Konten File
echo "📖 Membaca isi file logika & konfigurasi...\n";
$filesToRead = scanFileContents(getcwd());
$contentSection = "";

foreach ($filesToRead as $index => $filePath) {
    $relativePath = getRelativePath($filePath);
    $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    
    // Progress
    if (($index + 1) % 50 == 0) echo ".";

    $fileContent = file_get_contents($filePath);
    
    $contentSection .= "\n// --- FILE: {$relativePath} ---\n";
    $contentSection .= "```{$ext}\n";
    $contentSection .= $fileContent;
    $contentSection .= "\n```\n";
}

// 3. Gabungkan dan Simpan
file_put_contents($outputFile, $header . $treeMap . $contentSection);

echo "\n\n✅ SELESAI! Konteks Lengkap tersimpan di: {$outputFile}\n";
echo "📊 Total File Dibaca: " . count($filesToRead) . "\n";
echo "👉 Ukuran File Akhir: " . round(filesize($outputFile) / 1024 / 1024, 2) . " MB\n";
?>