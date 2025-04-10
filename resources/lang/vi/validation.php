<?php
return [
    'required' => 'Trường :attribute là bắt buộc.',
    'email' => 'Trường :attribute phải là một địa chỉ email hợp lệ.',
    'confirmed' => 'Xác nhận :attribute không khớp.',
    'min' => [
        'string' => 'Trường :attribute phải có ít nhất :min ký tự.',
    ],
    'string' => 'Trường :attribute phải là một chuỗi.',

    'attributes' => [
        'email' => 'email',
        'password' => 'mật khẩu',
        'password_confirmation' => 'xác nhận mật khẩu',
    ],

    'custom' => [
        'email' => [
            'exists' => 'Không tìm thấy địa chỉ email này trong hệ thống của chúng tôi.',
        ],
    ],
];