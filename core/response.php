<?php

function jsonResponse($status, $message, $extra = [])
{
    echo json_encode(array_merge([
        'status' => $status,
        'message' => $message
    ], $extra));
    exit;
}

function isTableExist($conn, $table, $database)
{
    $escapedTable = $conn->real_escape_string($table);
    $query = "SHOW TABLES LIKE '$escapedTable'";
    $result = $conn->query($query);

    if (!$result) {
        jsonResponse(false, "Table existence check failed.", ['error' => $conn->error]);
    }

    if ($result->num_rows === 0) {
        jsonResponse(false, "Table `$table` does not exist in database `$database`.");
    }
    // return $result;
}


// The API reads and writes any table, so every request must carry the shared key
// configured in the API_KEY environment variable. No key configured = API disabled.
function requireApiKey()
{
    $expected = (string) getenv('API_KEY');
    $given = isset($_SERVER['HTTP_X_API_KEY']) ? (string) $_SERVER['HTTP_X_API_KEY'] : '';
    if ($expected === '' || !hash_equals($expected, $given)) {
        http_response_code(401);
        header('Content-Type: application/json');
        jsonResponse(false, "Unauthorized: missing or invalid X-API-Key header.");
    }
}

// Returns the sanitized array, or false when the input is invalid.
// (No union return type: the Docker image runs PHP 7.4.)
function sanitizeDynamicInput($input)
{
    if (!is_array($input)) {
        return false;
    }

    $sanitized = [];

    foreach ($input as $key => $value) {
        $sanitized_key = htmlspecialchars($key, ENT_QUOTES, 'UTF-8');

        if (is_string($value)) {
            $sanitized_value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        } elseif (is_int($value)) {
            $sanitized_value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
            if ($sanitized_value === false) {
                return false; // Invalid integer
            }
        } elseif (is_float($value)) {
            $sanitized_value = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            if ($sanitized_value === false) {
                return false; // Invalid float
            }
        } elseif (is_array($value)) {
            // Recursively sanitize array values (be cautious with deeply nested arrays)
            $sanitized_value = sanitizeDynamicInput($value);
            if ($sanitized_value === false) {
                return false;
            }
        } elseif (is_bool($value)) {
            $sanitized_value = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
            if ($sanitized_value === null) {
                return false; // Invalid boolean
            }
        } else {
            // Handle other data types or reject them
            return false; // Unsupported data type
        }

        $sanitized[$sanitized_key] = $sanitized_value;
    }

    return $sanitized;
}
