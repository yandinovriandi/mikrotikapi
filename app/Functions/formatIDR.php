<?php

function formatIDR($amount): string
{
    return 'Rp. '.number_format($amount, 0, ',', '.');
}
