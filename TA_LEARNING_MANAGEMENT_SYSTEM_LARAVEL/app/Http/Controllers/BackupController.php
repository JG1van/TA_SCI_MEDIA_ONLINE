<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public const ALLOWED_ROLES = [1];
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    public function create()
    {
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');
        $port = config('database.connections.mysql.port');

        $mysqldump = "C:\\LARAGON-2025-1\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe";

        $filename = "backup_" . date('Y-m-d_H-i-s') . ".sql";
        $path = storage_path("app/backups");

        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $filePath = $path . DIRECTORY_SEPARATOR . $filename;

        // Handle password kosong
        $passwordString = $password ? "-p\"{$password}\"" : "";

        $command = "\"{$mysqldump}\" "
            . "-h\"{$host}\" "
            . "-P\"{$port}\" "
            . "-u\"{$username}\" "
            . "{$passwordString} "
            . "--databases \"{$database}\" "
            . "--routines --triggers --events "
            . "--add-drop-database --add-drop-table "
            . "--complete-insert "
            . "--skip-lock-tables "
            . "--skip-extended-insert "
            . "> \"{$filePath}\" 2>&1";

        exec($command, $output, $result);

        if ($result !== 0) {
            return back()->with('error', implode("\n", $output));
        }

        return response()->download($filePath);
    }

    public function restore(Request $request)
    {
        $request->validate([
            'sql_file' => 'required|file'
        ]);

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        $file = $request->file('sql_file');
        $path = $file->getRealPath();

        $command = "mysql --user={$username} --password={$password} {$database} < {$path}";
        exec($command);

        return back()->with('success', 'Database berhasil direstore.');
    }
}