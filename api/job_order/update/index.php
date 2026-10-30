<?php

require_once '../../../core/rowManager.php';
require_once '../../../core/response.php';

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get raw input & log it
    $rawInput = file_get_contents("php://input");
    error_log("RAW INPUT: " . $rawInput);

    // Decode JSON
    $input = json_decode($rawInput, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        http_response_code(400); // Bad Request

        $jsonErrors = [
            JSON_ERROR_NONE => 'No error',
            JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
            JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded',
            JSON_ERROR_RECURSION => 'One or more recursive references in the value to be encoded',
            JSON_ERROR_INF_OR_NAN => 'One or more NAN or INF values in the value to be encoded',
            JSON_ERROR_UNSUPPORTED_TYPE => 'A value of a type that cannot be encoded was given',
            JSON_ERROR_INVALID_PROPERTY_NAME => 'A property name that cannot be encoded was given',
            JSON_ERROR_UTF16 => 'Malformed UTF-16 characters, possibly incorrectly encoded'
        ];

        $errorMsg = $jsonErrors[json_last_error()] ?? 'Unknown JSON error';
        jsonResponse(false, "Invalid JSON input: {$errorMsg}");
    }

    // Sanitize and validate the dynamic input
    $sanitized_data = sanitizeDynamicInput($input);

    // Check if sanitization/validation failed
    if ($sanitized_data === false) {
        http_response_code(400); // Bad Request
        jsonResponse(false, "Invalid or unsafe input data.");
    }

    // Pass sanitized data to update function
    updateTableRow($sanitized_data);
} else {
    http_response_code(405); // Method Not Allowed
    jsonResponse(false, "POST request required.");
}
