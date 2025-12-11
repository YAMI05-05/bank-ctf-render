<?php
// Secret trigger to leak flag (for solvability on restricted hosts like Render)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['host'] === 'LEAK_FLAG_PLEASE') {
    echo "<h3>🔐 Flag:</h3><pre>";
    echo file_get_contents('/fl4g');
    echo "</pre><p><a href='/it-portal.html'>← Back</a></p>";
    exit;
}

// Normal command injection path
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['host'])) {
    http_response_code(400);
    die("Direct access not allowed.");
}

$host = $_POST['host'];

// Hardened filter (500-point level)
$blocked_chars = [';', '&', '|', '(', ')', '{', '}', '[', ']', '"', '\'', '\\', ' ', "\t", "\n", "\r", '/'];
$blocked_words = ['cat', 'flag', 'softwarica', 'root', 'etc', 'passwd', 'bash', 'sh', 'wget', 'nc'];

foreach ($blocked_chars as $c) {
    if (strpos($host, $c) !== false) {
        http_response_code(403);
        die("Security alert: illegal character detected.");
    }
}
foreach ($blocked_words as $w) {
    if (stripos($host, $w) !== false) {
        http_response_code(403);
        die("Security alert: forbidden keyword detected.");
    }
}

// Vulnerable command execution
shell_exec("ping -c 1 " . escapeshellarg($host) . " 2>&1");

echo "<h3>✅ Diagnostic completed.</h3>";
echo "<p><a href='https://frontend-cte9f5iz2-netanixs-projects.vercel.app/it-portal.html'>← Back</a></p>";
?>