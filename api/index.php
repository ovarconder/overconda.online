<?php
// index.php @ api.overconda.space
header('Content-Type: application/json');

// 1. รับค่าแบบ POST เพื่อความปลอดภัย
$license_key   = $_POST['license_key'] ?? '';
$client_domain = $_POST['domain'] ?? '';
$product_id    = $_POST['product_id'] ?? '';

if (empty($license_key)) {
    echo json_encode(['success' => false, 'message' => 'Missing License Key']);
    exit;
}

// 2. เช็คใน DB ของ Overconda ก่อน (Key ต้องมีอยู่แล้วไม่ว่าจะมาจากไหน)
$stmt = $pdo->prepare("SELECT * FROM ovcd_licenses WHERE license_key = ? AND product_id = ?");
$stmt->execute([$license_key, $product_id]);
$license = $stmt->fetch(PDO::FETCH_ASSOC);

if ($license) {
    // กรณีที่ 1: เคยลงทะเบียนไปแล้ว (Check Domain Lock)
    if (!empty($license['domain_registered'])) {
        if ($license['domain_registered'] === $client_domain) {
            echo json_encode([
                'success' => true,
                'license_type' => $license['license_type'],
                'activated_at' => $license['activated_at']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Key already used on: ' . $license['domain_registered']]);
        }
    } 
    // กรณีที่ 2: การลงทะเบียนครั้งแรก (First Time Activation)
    else {
        $activated_date = date('Y-m-d H:i:s');
        $update = $pdo->prepare("UPDATE ovcd_licenses SET domain_registered = ?, activated_at = ? WHERE id = ?");
        $update->execute([$client_domain, $activated_date, $license['id']]);
        
        echo json_encode([
            'success' => true,
            'license_type' => $license['license_type'],
            'activated_at' => $activated_date
        ]);
    }
} else {
    // กรณีพิเศษ: ถ้าไม่เจอใน DB แต่คุณเว่อร์ยังอยากให้เช็ค Envato เผื่อไว้ (Legacy Support)
    // [ใส่โค้ดเช็ค Envato API เดิมตรงนี้ แล้วค่อย INSERT ลง DB เราถ้าผ่าน]
    echo json_encode(['success' => false, 'message' => 'Invalid License Key']);
}