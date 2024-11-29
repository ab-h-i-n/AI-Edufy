<?php
function base64(string $blob): string
{
    return "data:image;base64," . base64_encode($blob);
}

function clientlog(string $message)
{
    echo "<script>console.log('$message')</script>";
    return;
}