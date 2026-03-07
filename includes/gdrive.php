<?php
/**
 * Google Drive API Helper
 *
 * Fetches file listings from a public shared folder.
 * Caches results to a JSON file to avoid hitting API rate limits.
 */

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

/**
 * Fetch files from a Google Drive folder.
 *
 * @param  string $folderId  Google Drive folder ID
 * @param  string $apiKey    Google API key
 * @param  int    $cacheTtl  Cache lifetime in seconds (default 1 hour)
 * @return array             Array of file objects
 */
function getGDriveFiles(string $folderId, string $apiKey, int $cacheTtl = 3600): array
{
    $cacheDir  = dirname(__DIR__) . '/cache';
    $cacheFile = $cacheDir . '/gdrive_' . md5($folderId) . '.json';

    // Return cached data if fresh
    if (file_exists($cacheFile) && (time() - filemtime($cacheFile)) < $cacheTtl) {
        $data = json_decode(file_get_contents($cacheFile), true);
        if (is_array($data)) {
            return $data;
        }
    }

    // Fetch from Google Drive API
    $fields = 'files(id,name,mimeType,size,modifiedTime,iconLink,webViewLink,thumbnailLink,description)';
    $query  = urlencode("'{$folderId}' in parents and trashed = false");
    $url    = "https://www.googleapis.com/drive/v3/files?q={$query}&key={$apiKey}&fields={$fields}&pageSize=100&orderBy=name";

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 15,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => ['Accept: application/json'],
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode !== 200 || !$response) {
        // If API fails, return cached data even if stale
        if (file_exists($cacheFile)) {
            $data = json_decode(file_get_contents($cacheFile), true);
            return is_array($data) ? $data : [];
        }
        return [];
    }

    $json = json_decode($response, true);
    $files = $json['files'] ?? [];

    // Cache the results
    if (!is_dir($cacheDir)) {
        mkdir($cacheDir, 0755, true);
    }
    file_put_contents($cacheFile, json_encode($files, JSON_PRETTY_PRINT));

    return $files;
}

/**
 * Get a human-readable file type from MIME type.
 */
function getFileTypeLabel(string $mimeType): string
{
    $map = [
        'application/pdf'                                                          => 'PDF',
        'application/msword'                                                       => 'Word',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'  => 'Word',
        'application/vnd.ms-excel'                                                 => 'Excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'        => 'Excel',
        'application/vnd.ms-powerpoint'                                            => 'PowerPoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation'=> 'PowerPoint',
        'application/vnd.google-apps.document'                                     => 'Google Doc',
        'application/vnd.google-apps.spreadsheet'                                  => 'Google Sheet',
        'application/vnd.google-apps.presentation'                                 => 'Google Slides',
        'application/vnd.google-apps.folder'                                       => 'Folder',
        'application/epub+zip'                                                     => 'EPUB',
        'text/plain'                                                               => 'Text',
        'text/html'                                                                => 'HTML',
        'image/jpeg'                                                               => 'Image',
        'image/png'                                                                => 'Image',
        'image/gif'                                                                => 'Image',
        'video/mp4'                                                                => 'Video',
        'audio/mpeg'                                                               => 'Audio',
    ];

    return $map[$mimeType] ?? 'Document';
}

/**
 * Get CSS class suffix for file type badge.
 */
function getFileTypeBadgeClass(string $mimeType): string
{
    if (str_contains($mimeType, 'pdf')) return 'pdf';
    if (str_contains($mimeType, 'word') || str_contains($mimeType, 'document')) return 'word';
    if (str_contains($mimeType, 'excel') || str_contains($mimeType, 'spreadsheet')) return 'excel';
    if (str_contains($mimeType, 'presentation') || str_contains($mimeType, 'powerpoint')) return 'ppt';
    if (str_contains($mimeType, 'image')) return 'image';
    if (str_contains($mimeType, 'video')) return 'video';
    return 'other';
}

/**
 * Format file size to human-readable string.
 */
function formatFileSize(int $bytes): string
{
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1048576) return round($bytes / 1024, 1) . ' KB';
    if ($bytes < 1073741824) return round($bytes / 1048576, 1) . ' MB';
    return round($bytes / 1073741824, 1) . ' GB';
}

/**
 * Build a Google Drive preview URL (view-only, no download).
 */
function getGDrivePreviewUrl(string $fileId, string $mimeType = ''): string
{
    // Google native docs use a different preview URL
    if (str_contains($mimeType, 'google-apps.document')) {
        return "https://docs.google.com/document/d/{$fileId}/preview";
    }
    if (str_contains($mimeType, 'google-apps.spreadsheet')) {
        return "https://docs.google.com/spreadsheets/d/{$fileId}/preview";
    }
    if (str_contains($mimeType, 'google-apps.presentation')) {
        return "https://docs.google.com/presentation/d/{$fileId}/preview";
    }

    // PDFs and other files use the generic preview
    return "https://drive.google.com/file/d/{$fileId}/preview";
}
