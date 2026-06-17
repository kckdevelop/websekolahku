<?php
$ch = curl_init('https://ppdb.smkmuh1bantul.sch.id/ppdb/pendaftaran/index.php?p=pendaftar');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
$html = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
} else {
    file_put_contents('pendaftar.html', $html);
    echo "Saved " . strlen($html) . " bytes to pendaftar.html\n";
}
curl_close($ch);
