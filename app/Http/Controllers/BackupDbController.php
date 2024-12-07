<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;

class BackupDbController extends Controller
{
    public function index()
    {
        return view('backup-db');
    }

    public function backup()
    {
        try {
            $fileName = 'backup_' . now()->format('Y_m_d_H_i_s') . '.sql';
            $response = new StreamedResponse(function () use ($fileName) {
                $command = "mysqldump -u root system_inventory";
                $process = popen($command, 'r');
                if ($process) {
                    while (!feof($process)) {
                        echo fread($process, 1024);
                        flush();
                    }
                    pclose($process);
                } else {
                    throw new \Exception('Failed to execute mysqldump command');
                }
            });
            $response->headers->set('Content-Type', 'application/sql');
            $response->headers->set('Content-Disposition', 'attachment; filename="' . $fileName . '"');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
            return $response;
        } catch (\Throwable $th) {
            throw new \Exception('Gagal menjalankan perintah mysqldump');
        }
    }
}
