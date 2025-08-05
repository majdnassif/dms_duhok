<?php

class ReadFiles extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
    }


    public function Ajaxcheck($file)
    {

        $encryptedAuth = $this->input->cookie('auth_token_remote', true) ?? '';

        $crypt = new Crypt();
        $decryptedJson = $crypt->MediaDecrypt($encryptedAuth);

        $userData = json_decode($decryptedJson, true);

        //log_message('debug', 'Ajaxcheck auth_token_remote cookie: ' . ($encryptedAuth ?? 'NONE'));

        if ($userData) {
            // continue without the session check
        }

        // Check user session
        else if (!$this->session->userdata('user_login_data') && !$encryptedAuth) {
            show_404(); // Or show_error("Unauthorized", 403);
            return;
        }

        $filename = basename($file); // sanitize
        $baseDir = realpath(FCPATH . 'assets/uploads/attachments');
        $filePath = realpath($baseDir . DIRECTORY_SEPARATOR . $filename);

        // Security: Make sure file is within allowed directory
        if ($filePath === false || strpos($filePath, $baseDir) !== 0 || !file_exists($filePath)) {
            show_404();
            return;
        }

        // Detect MIME
        $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
        ];
        $ctype = $mimeTypes[$ext] ?? 'application/octet-stream';

        // Output headers
        header('Content-Type: ' . $ctype);
        header('Content-Length: ' . filesize($filePath));
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');

        // Read the file
        readfile($filePath);
        exit;
    }
}
