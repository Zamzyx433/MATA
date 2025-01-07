<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class ViewerBot {
    private $url;
    private $referrers = [
        "https://www.google.com", "https://www.facebook.com", "https://www.twitter.com", "https://www.instagram.com",
        "https://www.reddit.com", "https://www.linkedin.com", "http://google.com.sg", "http://google.co.id"
        // Daftar referer lainnya sesuai kebutuhan
    ];

    private $userAgents = [];

    public function __construct($url) {
        $this->url = $url;
        $this->loadUserAgents();
    }

    // Fungsi untuk memuat user-agents dari file ua.txt
    private function loadUserAgents() {
        $file = 'ua.txt'; // File user-agents
        if (file_exists($file)) {
            $this->userAgents = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Membaca file dan menghapus baris kosong
        } else {
            throw new Exception("File ua.txt tidak ditemukan.");
        }
    }

    public function visit() {
        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgents[array_rand($this->userAgents)]); // Menggunakan user-agent acak dari file
            curl_setopt($ch, CURLOPT_REFERER, $this->referrers[array_rand($this->referrers)]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $result = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            usleep(200000); // Menunggu sebentar agar tidak terlalu cepat

            return [
                "success" => ($httpCode >= 200 && $httpCode < 300),
                "code" => $httpCode,
                "error" => $error,
                "referer" => $this->referrers[array_rand($this->referrers)]
            ];
        } catch (Exception $e) {
            return [
                "success" => false,
                "code" => 0,
                "error" => $e->getMessage(),
                "referer" => "N/A"
            ];
        }
    }
}

if (isset($_GET['ajax']) && isset($_GET['url']) && isset($_GET['current'])) {
    header('Content-Type: application/json');
    $bot = new ViewerBot($_GET['url']);
    $result = $bot->visit();
    echo json_encode($result);
    exit;
}

$error = '';
if (isset($_GET['url']) && !filter_var($_GET['url'], FILTER_VALIDATE_URL)) {
    $error = "Invalid URL format";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>MATA - Wanz Xploit</title>
    <style>
        /* Gaya CSS seperti sebelumnya */
    </style>
</head>
<body>
    <div class="container">
        <h1>MATA Web View Server</h1>
        
        <div class="card">
            <form id="viewerForm" method="GET">
                <div class="form-group">
                    <label>Target URL</label>
                    <input type="url" name="url" placeholder="https://example.com" 
                           value="<?php echo isset($_GET['url']) ? htmlspecialchars($_GET['url']) : ''; ?>"
                           autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label>Number of Views (1-1000)</label>
                    <input type="number" name="max" placeholder="Enter number of views" 
                           value="<?php echo isset($_GET['max']) ? htmlspecialchars($_GET['max']) : '100'; ?>"
                           min="1" max="1000" required>
                </div>
                <button type="submit" id="submitBtn">Generate Views</button>
            </form>

            <?php if (isset($_GET['url']) && isset($_GET['max'])): ?>
            <div class="progress">
                <div class="progress-bar" id="progressBar" style="width: 0%"></div>
            </div>
            <?php endif; ?>
        </div>

        <?php if ($error): ?>
            <div class="card error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <div id="results" class="results"></div>
    </div>

    <script>
        // JavaScript untuk menangani form dan menampilkan hasil seperti sebelumnya
    </script>
</body>
</html>
