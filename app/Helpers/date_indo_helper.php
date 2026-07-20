<?php

if (!function_exists('format_indo')) {
    /**
     * Format a date string into Indonesian date format.
     * Example outputs:
     * - 'short'      -> '15 Jul 2026'
     * - 'long'       -> '15 Juli 2026'
     * - 'short_time' -> '15 Jul 2026, 15:30'
     * - 'long_time'  -> '15 Juli 2026, 15:30'
     * 
     * @param string|null $dateString The input date (e.g. from database)
     * @param string $format The requested output format: 'short', 'long', 'short_time', 'long_time'
     * @return string
     */
    function format_indo($dateString, $format = 'short')
    {
        if (empty($dateString)) {
            return '';
        }

        $timestamp = strtotime($dateString);
        if (!$timestamp) {
            return $dateString;
        }

        $day = date('d', $timestamp);
        $monthNum = date('n', $timestamp);
        $year = date('Y', $timestamp);
        $time = date('H:i', $timestamp);

        $monthsLong = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $monthsShort = [
            1 => 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
        ];

        switch ($format) {
            case 'long':
                return "{$day} {$monthsLong[$monthNum]} {$year}";
            case 'long_time':
                return "{$day} {$monthsLong[$monthNum]} {$year}, {$time}";
            case 'short_time':
                return "{$day} {$monthsShort[$monthNum]} {$year}, {$time}";
            case 'short':
            default:
                return "{$day} {$monthsShort[$monthNum]} {$year}";
        }
    }
}
