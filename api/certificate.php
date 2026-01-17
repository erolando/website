<?php
// Certificate viewer with obfuscated URL protection
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="certificate.pdf"');

// Get the obfuscated filename from the URL parameter
if (!isset($_GET['file'])) {
    http_response_code(400);
    exit('File parameter required');
}

$encodedFile = $_GET['file'];

// Decode the filename (base64 obfuscation)
$filename = base64_decode($encodedFile);

// Security: Validate the filename to prevent directory traversal
if (empty($filename) || 
    strpos($filename, '..') !== false || 
    strpos($filename, '/') !== false || 
    strpos($filename, '\\') !== false ||
    !preg_match('/^[a-zA-Z0-9_-]+\.pdf$/', $filename)) {
    http_response_code(403);
    exit('Invalid file request');
}

// Construct the full path to the certificate file
$certPath = __DIR__ . '/../assets/certifications/' . $filename;

// Security: Check if file exists and is a PDF
if (!file_exists($certPath)) {
    http_response_code(404);
    exit('Certificate not found');
}

$fileInfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($fileInfo, $certPath);
finfo_close($fileInfo);

if ($mimeType !== 'application/pdf') {
    http_response_code(403);
    exit('Invalid file type');
}

// Serve the file
readfile($certPath);
?>
