<?php
require_once __DIR__ . '/vendor/autoload.php';

use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Type\Definition\ObjectType;

// Cấu hình cho phép nhận JSON
header('Content-Type: application/json; charset=UTF-8');

// Đọc dữ liệu truy vấn từ request body
$rawInput = file_get_contents('php://input');
$input = json_decode($rawInput, true);
$query = $input['query'] ?? '';
$variableValues = $input['variables'] ?? null;

// Kiểm tra nếu không có query
if (empty($query)) {
    echo json_encode(["error" => "GraphQL query is empty"]);
    exit;
}

// Định nghĩa schema ví dụ
$queryType = new ObjectType([
    'name' => 'Query',
    'fields' => [
        'hello' => [
            'type' => \GraphQL\Type\Definition\Type::string(),
            'resolve' => fn() => 'Xin chào từ GraphQL Gateway!'
        ]
    ]
]);

$schema = new Schema(['query' => $queryType]);

try {
    $result = GraphQL::executeQuery($schema, $query, null, null, (array) $variableValues);
    $output = $result->toArray();
} catch (Exception $e) {
    $output = ['error' => $e->getMessage()];
}

echo json_encode($output);
