<?php

function generateIp($localAddress, $previousIpAddress = []): string
{
    $ipParts = explode('.', $localAddress);
    $lastIpPart = end($ipParts);

    array_pop($ipParts);
    $baseIp = implode('.', $ipParts);

    $randomLastPart = rand(2, 253);

     while ($randomLastPart === (int)$lastIpPart || in_array($baseIp . '.' . $randomLastPart, $previousIpAddress)) {
        $randomLastPart = rand(2, 253);
    }

    return $baseIp . '.' . $randomLastPart;
}
