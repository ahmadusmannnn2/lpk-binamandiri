<?php
$files = [
    'resources/views/admin/program/create.blade.php',
    'resources/views/admin/program/edit.blade.php',
    'resources/views/admin/instruktur/create.blade.php',
    'resources/views/admin/instruktur/edit.blade.php',
    'resources/views/admin/peserta/create.blade.php',
    'resources/views/admin/peserta/edit.blade.php',
    'resources/views/admin/kelas/create.blade.php',
    'resources/views/admin/kelas/edit.blade.php',
    'resources/views/profile/edit.blade.php'
];

foreach ($files as $file) {
    if (!file_exists($file)) continue;
    $content = file_get_contents($file);
    if (strpos($content, '<div class="flex items-center gap-3">') === false && preg_match('/<x-slot name="header">\s*<h2(.*?)>\s*(.*?)\s*<\/h2>\s*<\/x-slot>/s', $content, $matches)) {
        $replacement = "<x-slot name=\"header\">\n        <div class=\"flex items-center gap-3\">\n            <a href=\"{{ url()->previous() }}\" class=\"text-gray-500 hover:text-oranye transition\">\n                <svg class=\"w-6 h-6\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M10 19l-7-7m0 0l7-7m-7 7h18\"></path></svg>\n            </a>\n            <h2{$matches[1]}>\n                {$matches[2]}\n            </h2>\n        </div>\n    </x-slot>";
        $new_content = preg_replace('/<x-slot name="header">\s*<h2(.*?)>\s*(.*?)\s*<\/h2>\s*<\/x-slot>/s', $replacement, $content);
        file_put_contents($file, $new_content);
        echo "Updated $file\n";
    }
}
