<?php
header("Content-Type: application/json");

echo json_encode([
    "status" => "success",
    "message" => "Backend is running. Use the /api endpoints for CRUD operations."
]);