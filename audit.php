<?php
set_time_limit(30);
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['host'])) {
    http_response_code(400);
    die("Direct access not allowed.");
}

$host = $_POST['host'];

$blocked_chars = [';', '&', '|', '(', ')', '{', '}', '[', ']', '"', '\'', '\\', ' ', "\t", "\n", "\r"];
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

shell_exec("ping -c 1 " . escapeshellarg($host) . " 2>&1");

echo "<h3>✅ Diagnostic completed.</h3>";
echo "<p><a href='https://frontend-ggs05ncbu-netanixs-projects.vercel.app/it-portal.html'>← Back</a></p>";
?>