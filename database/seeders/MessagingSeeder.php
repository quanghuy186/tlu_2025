<?php

namespace Database\Seeders;

use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MessagingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Trần Thị B',
                'email' => 'b.tt123456@tlu.edu.vn',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Phòng Đào tạo',
                'email' => 'phongdaotao@tlu.edu.vn',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'TS. Nguyễn Văn C',
                'email' => 'c.nv@tlu.edu.vn',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Lê Văn D',
                'email' => 'd.lv@tlu.edu.vn',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Phòng CTSV',
                'email' => 'phongctsv@tlu.edu.vn',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        // Tạo user chính (người đang đăng nhập)
        $mainUser = User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'a.nv@tlu.edu.vn',
            'password' => Hash::make('password'),
        ]);

        // Tạo tin nhắn mẫu
        $user1 = User::where('email', 'b.tt123456@tlu.edu.vn')->first();
        
        // Cuộc trò chuyện với Trần Thị B
        $messages = [
            [
                'sender_user_id' => $user1->id,
                'recipient_user_id' => $mainUser->id,
                'content' => 'Chào bạn, tôi muốn hỏi về tài liệu môn Mạng máy tính, bạn có thể chia sẻ cho tôi được không?',
                'sent_at' => now()->subHours(3),
                'is_read' => true,
            ],
            [
                'sender_user_id' => $mainUser->id,
                'recipient_user_id' => $user1->id,
                'content' => 'Chào bạn, tôi có đây. Bạn cần tài liệu nào ạ?',
                'sent_at' => now()->subHours(3)->addMinutes(2),
                'is_read' => true,
            ],
            [
                'sender_user_id' => $user1->id,
                'recipient_user_id' => $mainUser->id,
                'content' => 'Mình cần slide bài giảng tuần 5 và tài liệu thực hành lab 3 ạ. Hôm đó mình nghỉ ốm nên không có ghi chép.',
                'sent_at' => now()->subHours(3)->addMinutes(5),
                'is_read' => true,
            ],
            [
                'sender_user_id' => $mainUser->id,
                'recipient_user_id' => $user1->id,
                'content' => 'OK, tôi sẽ gửi cho bạn vào chiều nay. Để tôi tổng hợp lại tài liệu đã.',
                'sent_at' => now()->subHours(3)->addMinutes(7),
                'is_read' => true,
            ],
            [
                'sender_user_id' => $user1->id,
                'recipient_user_id' => $mainUser->id,
                'content' => 'Cảm ơn bạn nhiều, bạn có thể gửi qua email cũng được. Email của mình là b.tt123456@tlu.edu.vn',
                'sent_at' => now()->subHours(3)->addMinutes(10),
                'is_read' => true,
            ],
            [
                'sender_user_id' => $mainUser->id,
                'recipient_user_id' => $user1->id,
                'content' => 'Đã ghi lại. Tôi sẽ gửi qua cả email và tin nhắn ở đây để bạn tiện theo dõi.',
                'sent_at' => now()->subHours(3)->addMinutes(12),
                'is_read' => true,
            ],
        ];

        foreach ($messages as $messageData) {
            Message::create($messageData);
        }

        // Tạo tin nhắn với các user khác
        $user2 = User::where('email', 'phongdaotao@tlu.edu.vn')->first();
        Message::create([
            'sender_user_id' => $user2->id,
            'recipient_user_id' => $mainUser->id,
            'content' => 'Vui lòng xác nhận lịch học bổ sung cho học phần Cơ sở dữ liệu vào thứ 7 tuần này.',
            'sent_at' => now()->subDay(),
            'is_read' => false,
        ]);

        $user3 = User::where('email', 'c.nv@tlu.edu.vn')->first();
        Message::create([
            'sender_user_id' => $user3->id,
            'recipient_user_id' => $mainUser->id,
            'content' => 'Sinh viên cần chuẩn bị báo cáo cho buổi seminar tuần sau. Chi tiết tôi đã gửi trong email.',
            'sent_at' => now()->subDays(3),
            'is_read' => false,
        ]);
    }
}
