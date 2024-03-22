<?php

function generatePort($digits = 4, $previousPorts = []): string
{
    while (true) {
        $newPort = '';
        for ($i = 0; $i < $digits; $i++) {
            $newPort .= rand(1, 9);
        }

        if (!in_array($newPort, $previousPorts)) {
            return $newPort;
        }
    }
}
