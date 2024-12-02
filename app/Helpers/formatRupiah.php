<?php
function formatRupiah($angka) {
    $number_string = number_format($angka, 0, ',', '.');
    return 'Rp ' . $number_string;
}
