<?php
$ch = curl_init('https://ppdb.smkmuh1bantul.sch.id/ppdb/pendaftaran/index.php');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$html = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    file_put_contents('login_page.html', $html);
    echo "Saved " . strlen($html) . " bytes to login_page.html\n";
}
curl_close($ch);
