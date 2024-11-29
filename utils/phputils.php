<?php
function base64(string $blob): string
{
    return "data:image/jpeg;base64," . base64_encode($blob);
}

function clientlog(string $message)
{
    echo "<script>console.log('$message')</script>";
    return;
}