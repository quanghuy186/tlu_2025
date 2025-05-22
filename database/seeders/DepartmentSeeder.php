<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            // Level 0 - Trường Đại học
            [
                'id' => 1,
                'name' => 'Trường Đại học Thủy lợi',
                'code' => 'TLU',
                'parent_id' => null,
                'user_id' => 1,
                'description' => 'Trường Đại học Thủy lợi là một trong những trường đại học kỹ thuật hàng đầu Việt Nam trong lĩnh vực thủy lợi, xây dựng và môi trường.',
                'phone' => '024.38522201',
                'email' => 'tlu@tlu.edu.vn',
                'address' => '175 Tây Sơn, Đống Đa, Hà Nội',
                'level' => 0
            ],

            // Level 1 - Các Khoa
            [
                'id' => 2,
                'name' => 'Khoa Công trình',
                'code' => 'CT',
                'parent_id' => 1,
                'user_id' => 2,
                'description' => 'Khoa Công trình chuyên đào tạo các ngành kỹ thuật xây dựng công trình thủy, dân dụng và giao thông.',
                'phone' => '024.38522210',
                'email' => 'congtrinh@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 3,
                'name' => 'Khoa Kỹ thuật tài nguyên nước',
                'code' => 'KTTNR',
                'parent_id' => 1,
                'user_id' => 3,
                'description' => 'Khoa chuyên về kỹ thuật tài nguyên nước, cấp thoát nước và thủy văn học.',
                'phone' => '024.38522215',
                'email' => 'tainguyennuoc@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 4,
                'name' => 'Khoa Cơ khí',
                'code' => 'CK',
                'parent_id' => 1,
                'user_id' => 4,
                'description' => 'Khoa Cơ khí đào tạo các ngành kỹ thuật cơ khí, chế tạo máy, ô tô và cơ điện tử.',
                'phone' => '024.38522220',
                'email' => 'cokhi@tlu.edu.vn',
                'address' => 'Tòa nhà B1, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 5,
                'name' => 'Khoa Điện – Điện tử',
                'code' => 'DDT',
                'parent_id' => 1,
                'user_id' => 5,
                'description' => 'Khoa đào tạo các ngành kỹ thuật điện, điện tử viễn thông, tự động hóa và robot.',
                'phone' => '024.38522225',
                'email' => 'diendt@tlu.edu.vn',
                'address' => 'Tòa nhà B2, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 6,
                'name' => 'Khoa Kinh tế và quản lý',
                'code' => 'KTQL',
                'parent_id' => 1,
                'user_id' => 6,
                'description' => 'Khoa đào tạo các ngành kinh tế, quản trị kinh doanh, thương mại điện tử và du lịch.',
                'phone' => '024.38522230',
                'email' => 'ktql@tlu.edu.vn',
                'address' => 'Tòa nhà A5, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 7,
                'name' => 'Khoa Công nghệ thông tin',
                'code' => 'CNTT',
                'parent_id' => 1,
                'user_id' => 7,
                'description' => 'Khoa đào tạo các ngành công nghệ thông tin, an ninh mạng và trí tuệ nhân tạo.',
                'phone' => '024.38522235',
                'email' => 'cntt@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 8,
                'name' => 'Khoa Hóa và Môi trường',
                'code' => 'HMT',
                'parent_id' => 1,
                'user_id' => 8,
                'description' => 'Khoa đào tạo các ngành kỹ thuật môi trường, hóa học và công nghệ sinh học.',
                'phone' => '024.38522240',
                'email' => 'hoamt@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 9,
                'name' => 'Khoa Luật và Lý luận chính trị',
                'code' => 'LLLCT',
                'parent_id' => 1,
                'user_id' => 9,
                'description' => 'Khoa đào tạo ngành Luật và Luật kinh tế.',
                'phone' => '024.38522245',
                'email' => 'luat@tlu.edu.vn',
                'address' => 'Tòa nhà A1, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 10,
                'name' => 'Trung tâm Đào tạo quốc tế',
                'code' => 'TTDTQT',
                'parent_id' => 1,
                'user_id' => 10,
                'description' => 'Trung tâm đào tạo các chương trình quốc tế và ngoại ngữ.',
                'phone' => '024.38522250',
                'email' => 'international@tlu.edu.vn',
                'address' => 'Tòa nhà A6, Trường Đại học Thủy lợi',
                'level' => 1
            ],
            [
                'id' => 11,
                'name' => 'Khoa Kế toán và Kinh doanh',
                'code' => 'KTKD',
                'parent_id' => 1,
                'user_id' => 11,
                'description' => 'Khoa đào tạo các ngành kế toán, kiểm toán, tài chính ngân hàng.',
                'phone' => '024.38522255',
                'email' => 'ketoan@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 1
            ],

            // Level 2 - Bộ môn thuộc Khoa Kinh tế và quản lý
            [
                'id' => 12,
                'name' => 'Bộ môn Thương mại điện tử',
                'code' => 'TMDT',
                'parent_id' => 6,
                'user_id' => 12,
                'description' => 'Bộ môn chuyên đào tạo ngành Thương mại điện tử.',
                'phone' => '024.38522231',
                'email' => 'tmdt@tlu.edu.vn',
                'address' => 'P208 nhà A5',
                'level' => 2
            ],
            [
                'id' => 13,
                'name' => 'Bộ môn Quản trị du lịch',
                'code' => 'QTDL',
                'parent_id' => 6,
                'user_id' => 13,
                'description' => 'Bộ môn chuyên đào tạo ngành Quản trị dịch vụ du lịch và lữ hành.',
                'phone' => '024.38522232',
                'email' => 'dulich@tlu.edu.vn',
                'address' => 'P209 nhà A5',
                'level' => 2
            ],
            [
                'id' => 14,
                'name' => 'Bộ môn Kinh tế',
                'code' => 'KT',
                'parent_id' => 6,
                'user_id' => 14,
                'description' => 'Bộ môn chuyên đào tạo ngành Kinh tế.',
                'phone' => '024.38522233',
                'email' => 'kinhte@tlu.edu.vn',
                'address' => 'P210 nhà A5',
                'level' => 2
            ],
            [
                'id' => 15,
                'name' => 'Bộ môn Kinh tế xây dựng',
                'code' => 'KTXD',
                'parent_id' => 6,
                'user_id' => 15,
                'description' => 'Bộ môn chuyên đào tạo ngành Kinh tế xây dựng.',
                'phone' => '024.38522234',
                'email' => 'ktxd@tlu.edu.vn',
                'address' => 'P211 nhà A5',
                'level' => 2
            ],
            [
                'id' => 16,
                'name' => 'Bộ môn Phát triển kỹ năng',
                'code' => 'PTKN',
                'parent_id' => 6,
                'user_id' => 16,
                'description' => 'Bộ môn chuyên về phát triển kỹ năng mềm cho sinh viên.',
                'phone' => '024.38522235',
                'email' => 'ptkn@tlu.edu.vn',
                'address' => 'P214 nhà A5',
                'level' => 2
            ],
            [
                'id' => 17,
                'name' => 'Bộ môn Kinh tế và kinh doanh số',
                'code' => 'KTKDS',
                'parent_id' => 6,
                'user_id' => 17,
                'description' => 'Bộ môn chuyên đào tạo ngành Kinh tế số.',
                'phone' => '024.38522236',
                'email' => 'kinhteaso@tlu.edu.vn',
                'address' => 'P202 nhà A5',
                'level' => 2
            ],
            [
                'id' => 18,
                'name' => 'Bộ môn Logistics và chuỗi cung ứng',
                'code' => 'LCCCU',
                'parent_id' => 6,
                'user_id' => 18,
                'description' => 'Bộ môn chuyên đào tạo ngành Logistics và quản lý chuỗi cung ứng.',
                'phone' => '024.38522237',
                'email' => 'logistics@tlu.edu.vn',
                'address' => 'P203-204-205 nhà A5',
                'level' => 2
            ],
            [
                'id' => 19,
                'name' => 'Trung tâm Kinh tế và Quản lý',
                'code' => 'TTKTQL',
                'parent_id' => 6,
                'user_id' => 19,
                'description' => 'Trung tâm nghiên cứu và ứng dụng trong lĩnh vực kinh tế và quản lý.',
                'phone' => '024.38522238',
                'email' => 'ttktql@tlu.edu.vn',
                'address' => 'P212-213 nhà A5',
                'level' => 2
            ],

            // Level 2 - Bộ môn thuộc Khoa Hóa và Môi trường
            [
                'id' => 20,
                'name' => 'Bộ môn Kỹ thuật và Quản lý Môi trường',
                'code' => 'KTQLMT',
                'parent_id' => 8,
                'user_id' => 20,
                'description' => 'Bộ môn chuyên đào tạo ngành Kỹ thuật môi trường.',
                'phone' => '024.38522241',
                'email' => 'moitruong@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 21,
                'name' => 'Bộ môn Kỹ thuật Hóa học',
                'code' => 'KTHH',
                'parent_id' => 8,
                'user_id' => 21,
                'description' => 'Bộ môn chuyên đào tạo ngành Kỹ thuật hóa học.',
                'phone' => '024.38522242',
                'email' => 'hoahoc@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 22,
                'name' => 'Bộ môn Công nghệ Sinh học',
                'code' => 'CNSH',
                'parent_id' => 8,
                'user_id' => 22,
                'description' => 'Bộ môn chuyên đào tạo ngành Công nghệ sinh học.',
                'phone' => '024.38522243',
                'email' => 'sinhhoc@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 2
            ],

            // Level 2 - Bộ môn thuộc Trung tâm Đào tạo quốc tế
            [
                'id' => 23,
                'name' => 'Bộ môn ngôn ngữ Anh',
                'code' => 'NNA',
                'parent_id' => 10,
                'user_id' => 23,
                'description' => 'Bộ môn chuyên đào tạo ngành Ngôn ngữ Anh.',
                'phone' => '024.38522251',
                'email' => 'english@tlu.edu.vn',
                'address' => 'Tòa nhà A6, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 24,
                'name' => 'Bộ môn ngôn ngữ Trung Quốc',
                'code' => 'NNTQ',
                'parent_id' => 10,
                'user_id' => 24,
                'description' => 'Bộ môn chuyên đào tạo ngành Ngôn ngữ Trung Quốc.',
                'phone' => '024.38522252',
                'email' => 'chinese@tlu.edu.vn',
                'address' => 'Tòa nhà A6, Trường Đại học Thủy lợi',
                'level' => 2
            ],

            // Level 2 - Bộ môn thuộc Khoa Kế toán và Kinh doanh
            [
                'id' => 25,
                'name' => 'Bộ môn kế toán',
                'code' => 'KT_BM',
                'parent_id' => 11,
                'user_id' => 25,
                'description' => 'Bộ môn chuyên đào tạo ngành Kế toán.',
                'phone' => '024.38522256',
                'email' => 'ketoan_bm@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 26,
                'name' => 'Bộ môn kiểm toán',
                'code' => 'KTA',
                'parent_id' => 11,
                'user_id' => 26,
                'description' => 'Bộ môn chuyên đào tạo ngành Kiểm toán.',
                'phone' => '024.38522257',
                'email' => 'kiemtoan@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 27,
                'name' => 'Bộ môn tài chính',
                'code' => 'TC',
                'parent_id' => 11,
                'user_id' => 27,
                'description' => 'Bộ môn chuyên đào tạo ngành Tài chính - Ngân hàng.',
                'phone' => '024.38522258',
                'email' => 'taichinh@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 2
            ],
            [
                'id' => 28,
                'name' => 'Bộ Môn Quản trị kinh doanh',
                'code' => 'QTKD',
                'parent_id' => 11,
                'user_id' => 28,
                'description' => 'Bộ môn chuyên đào tạo ngành Quản trị kinh doanh.',
                'phone' => '024.38522259',
                'email' => 'qtkd@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 2
            ],

            // Level 1 - Các Phòng ban hành chính
            [
                'id' => 29,
                'name' => 'Phòng Hành chính - Tổng hợp',
                'code' => 'HCTH',
                'parent_id' => 1,
                'user_id' => 29,
                'description' => 'Công tác văn thư lưu trữ; Kế hoạch - tổng hợp; Công tác cải cách hành chính; Phục vụ, lễ tân; Đối ngoại; Thanh tra; Pháp chế.',
                'phone' => '024.38522201',
                'email' => 'phonghcth@tlu.edu.vn',
                'address' => 'P.200, P.203, P.204, P.111, P.113 nhà A1',
                'level' => 1
            ],
            [
                'id' => 30,
                'name' => 'Phòng Tổ chức cán bộ',
                'code' => 'TCCB',
                'parent_id' => 1,
                'user_id' => 30,
                'description' => 'Công tác tổ chức bộ máy và thể chế hoạt động; Quản lý biên chế, nhân sự; Chế độ chính sách; Đào tạo, bồi dưỡng; Thi đua khen thưởng.',
                'phone' => '024.35633086',
                'email' => 'p2@tlu.edu.vn',
                'address' => 'P.209, P.211, P.213 nhà A1',
                'level' => 1
            ],
            [
                'id' => 31,
                'name' => 'Phòng Đào tạo',
                'code' => 'DT',
                'parent_id' => 1,
                'user_id' => 31,
                'description' => 'Công tác tuyển sinh; Xây dựng và quản lý chương trình đào tạo; Tổ chức và quản lý đào tạo các bậc, loại hình; Phát triển đào tạo.',
                'phone' => '024.38521441',
                'email' => 'daotao@tlu.edu.vn',
                'address' => 'P.130, P.132, P.134 nhà A4',
                'level' => 1
            ],
            [
                'id' => 32,
                'name' => 'Phòng Khảo thí và Đảm bảo chất lượng',
                'code' => 'KTDBCL',
                'parent_id' => 1,
                'user_id' => 32,
                'description' => 'Tổ chức và quản lý công tác khảo thí; Quản lý công tác đánh giá và đảm bảo chất lượng giáo dục.',
                'phone' => '024.35643417',
                'email' => 'phongktkdcl@tlu.edu.vn',
                'address' => 'P.115, P.104 nhà A1',
                'level' => 1
            ],
            [
                'id' => 33,
                'name' => 'Phòng Chính trị và Công tác sinh viên',
                'code' => 'CTCTSV',
                'parent_id' => 1,
                'user_id' => 33,
                'description' => 'Công tác chính trị tư tưởng cho cán bộ viên chức và sinh viên; Công tác thông tin, tuyên truyền; Công tác sinh viên.',
                'phone' => '024.35639577',
                'email' => 'p7@tlu.edu.vn',
                'address' => 'P.110, P.112, P.116, P.118 nhà A1',
                'level' => 1
            ],
            [
                'id' => 34,
                'name' => 'Phòng Khoa học công nghệ và Hợp tác quốc tế',
                'code' => 'KHCNHTQT',
                'parent_id' => 1,
                'user_id' => 34,
                'description' => 'Tổ chức và quản lý nghiên cứu khoa học, chuyển giao công nghệ; Quản lý hoạt động hợp tác quốc tế; Xây dựng và triển khai dự án quốc tế.',
                'phone' => '024.38533083',
                'email' => 'kncn@tlu.edu.vn',
                'address' => 'P.103, P.105, P.508, P.510 nhà A1',
                'level' => 1
            ],
            [
                'id' => 35,
                'name' => 'Phòng Tài chính - Kế toán',
                'code' => 'TCKT',
                'parent_id' => 1,
                'user_id' => 35,
                'description' => 'Xây dựng và quản lý kế hoạch về tài chính; Tổ chức, quản lý, khai thác và sử dụng hiệu quả các nguồn tài chính; Tổ chức công tác kế toán.',
                'phone' => '024.35634602',
                'email' => 'phongtaivu@tlu.edu.vn',
                'address' => 'P.215, P.217, P.219, P.221 nhà A1',
                'level' => 1
            ],
            [
                'id' => 36,
                'name' => 'Phòng Quản trị - Thiết bị',
                'code' => 'QTTB',
                'parent_id' => 1,
                'user_id' => 36,
                'description' => 'Quản lý và khai thác hệ thống cơ sở vật chất, hạ tầng, trang thiết bị; Quản lý đầu tư xây dựng; Phòng cháy, chữa cháy; An ninh trật tự.',
                'phone' => '024.35635671',
                'email' => 'quantri@tlu.edu.vn',
                'address' => 'P.101, P.102, P.103, P.104 nhà A5; P.109 nhà A1',
                'level' => 1
            ],
            [
                'id' => 37,
                'name' => 'Trung tâm Nội trú',
                'code' => 'TTNT',
                'parent_id' => 1,
                'user_id' => 37,
                'description' => 'Quản lý và đảm bảo các điều kiện sinh hoạt trong khu nội trú; Đảm bảo an ninh trật tự; Quản lý dịch vụ ăn, uống và căng tin.',
                'phone' => '024.35643058',
                'email' => 'banquanly_ktx@tlu.edu.vn',
                'address' => 'P.303, P.305 KTX K1; Nhà 2, Nhà 3, Nhà 4',
                'level' => 1
            ],
            [
                'id' => 38,
                'name' => 'Trung tâm Tin học',
                'code' => 'TTTH',
                'parent_id' => 1,
                'user_id' => 38,
                'description' => 'Công tác tin học hóa quản trị điều hành và quản lý hành chính; Nghiên cứu, ứng dụng, đào tạo và dịch vụ công nghệ thông tin.',
                'phone' => '024.35635915',
                'email' => 'ttth@tlu.edu.vn',
                'address' => 'Phòng trực nhà C5; P.204 nhà C5; P.104 Tòa nhà A45',
                'level' => 1
            ],
            [
                'id' => 39,
                'name' => 'Thư viện',
                'code' => 'TV',
                'parent_id' => 1,
                'user_id' => 39,
                'description' => 'Lưu trữ, khai thác, thu thập, bảo quản, quản lý sách báo, tạp chí, giáo trình, tài liệu điện tử; Cung cấp thông tin phục vụ giảng dạy và nghiên cứu.',
                'phone' => '024.35640068',
                'email' => 'thuvien@tlu.edu.vn',
                'address' => 'P.207, P.205, P.305 Tòa nhà A45',
                'level' => 1
            ],
            [
                'id' => 40,
                'name' => 'Trạm Y tế',
                'code' => 'TYT',
                'parent_id' => 1,
                'user_id' => 40,
                'description' => 'Công tác quản lý và chăm sóc sức khỏe ban đầu cho cán bộ viên chức và sinh viên; Y tế học đường, phòng chống dịch bệnh và giữ gìn vệ sinh.',
                'phone' => '024.35632839',
                'email' => 'tramyte@tlu.edu.vn',
                'address' => 'KTX Nhà 4',
                'level' => 1
            ],

            // Level 3 - Các ngành học (Majors)
            
            // Khối Kỹ thuật Xây dựng - thuộc Khoa Công trình
            [
                'id' => 41,
                'name' => 'Xây dựng và quản lí công trình thủy (Kỹ thuật xây dựng công trình thủy)',
                'code' => '7580202',
                'parent_id' => 2,
                'user_id' => 41,
                'description' => 'Ngành đào tạo kỹ sư xây dựng công trình thủy lợi, đập, hồ chứa, kênh mương.',
                'phone' => '024.38522210',
                'email' => 'xdctthuy@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 42,
                'name' => 'Kỹ thuật xây dựng dân dụng và công nghiệp (Kỹ thuật xây dựng)',
                'code' => '7580201',
                'parent_id' => 2,
                'user_id' => 42,
                'description' => 'Ngành đào tạo kỹ sư xây dựng nhà dân dụng, công nghiệp và các công trình dân dụng.',
                'phone' => '024.38522210',
                'email' => 'ktxd@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 43,
                'name' => 'Công nghệ kỹ thuật xây dựng',
                'code' => '7510103',
                'parent_id' => 2,
                'user_id' => 43,
                'description' => 'Ngành đào tạo về công nghệ và kỹ thuật trong xây dựng.',
                'phone' => '024.38522210',
                'email' => 'cnktxd@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 44,
                'name' => 'Kỹ thuật xây dựng công trình giao thông',
                'code' => '7580205',
                'parent_id' => 2,
                'user_id' => 44,
                'description' => 'Ngành đào tạo kỹ sư xây dựng đường, cầu và các công trình giao thông.',
                'phone' => '024.38522210',
                'email' => 'ktxdctgt@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 45,
                'name' => 'Quản lí xây dựng',
                'code' => '7580302',
                'parent_id' => 2,
                'user_id' => 45,
                'description' => 'Ngành đào tạo về quản lý dự án và thi công xây dựng.',
                'phone' => '024.38522210',
                'email' => 'qlxd@tlu.edu.vn',
                'address' => 'Tòa nhà A2, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Ngành thuộc Khoa Kỹ thuật tài nguyên nước
            [
                'id' => 46,
                'name' => 'Kỹ thuật tài nguyên nước',
                'code' => '7580212',
                'parent_id' => 3,
                'user_id' => 46,
                'description' => 'Ngành đào tạo về quản lý và khai thác tài nguyên nước.',
                'phone' => '024.38522215',
                'email' => 'kttnr@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 47,
                'name' => 'Kỹ thuật cấp thoát nước',
                'code' => '7580213',
                'parent_id' => 3,
                'user_id' => 47,
                'description' => 'Ngành đào tạo về hệ thống cấp nước và thoát nước đô thị.',
                'phone' => '024.38522215',
                'email' => 'ktctn@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 48,
                'name' => 'Xây dựng và quản lí hạ tầng đô thị (Kỹ thuật cơ sở hạ tầng)',
                'code' => '7580210',
                'parent_id' => 3,
                'user_id' => 48,
                'description' => 'Ngành đào tạo về xây dựng và quản lý hạ tầng đô thị.',
                'phone' => '024.38522215',
                'email' => 'ktcsht@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 49,
                'name' => 'Tài nguyên nước và môi trường (Thủy văn học)',
                'code' => '7440224',
                'parent_id' => 3,
                'user_id' => 49,
                'description' => 'Ngành đào tạo về thủy văn và quản lý tài nguyên nước.',
                'phone' => '024.38522215',
                'email' => 'thuyvanhoc@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Kỹ thuật Cơ khí - thuộc Khoa Cơ khí
            [
                'id' => 50,
                'name' => 'Kỹ thuật cơ khí',
                'code' => '7520103',
                'parent_id' => 4,
                'user_id' => 50,
                'description' => 'Ngành đào tạo kỹ sư cơ khí tổng hợp.',
                'phone' => '024.38522220',
                'email' => 'ktck@tlu.edu.vn',
                'address' => 'Tòa nhà B1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 51,
                'name' => 'Công nghệ chế tạo máy',
                'code' => '7510202',
                'parent_id' => 4,
                'user_id' => 51,
                'description' => 'Ngành đào tạo về công nghệ chế tạo và sản xuất máy móc.',
                'phone' => '024.38522220',
                'email' => 'cnctm@tlu.edu.vn',
                'address' => 'Tòa nhà B1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 52,
                'name' => 'Kỹ thuật Ô tô',
                'code' => '7520130',
                'parent_id' => 4,
                'user_id' => 52,
                'description' => 'Ngành đào tạo kỹ sư về ô tô và phương tiện giao thông.',
                'phone' => '024.38522220',
                'email' => 'ktoto@tlu.edu.vn',
                'address' => 'Tòa nhà B1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 53,
                'name' => 'Kỹ thuật cơ điện tử',
                'code' => '7520114',
                'parent_id' => 4,
                'user_id' => 53,
                'description' => 'Ngành đào tạo kỹ sư cơ điện tử và tự động hóa.',
                'phone' => '024.38522220',
                'email' => 'ktcdt@tlu.edu.vn',
                'address' => 'Tòa nhà B1, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Kỹ thuật Điện - Điện tử - thuộc Khoa Điện-Điện tử
            [
                'id' => 54,
                'name' => 'Kỹ thuật điện',
                'code' => '7520201',
                'parent_id' => 5,
                'user_id' => 54,
                'description' => 'Ngành đào tạo kỹ sư điện.',
                'phone' => '024.38522225',
                'email' => 'ktdien@tlu.edu.vn',
                'address' => 'Tòa nhà B2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 55,
                'name' => 'Kỹ thuật điều khiển và tự động hóa',
                'code' => '7510303',
                'parent_id' => 5,
                'user_id' => 55,
                'description' => 'Ngành đào tạo về tự động hóa và điều khiển.',
                'phone' => '024.38522225',
                'email' => 'ktdktdh@tlu.edu.vn',
                'address' => 'Tòa nhà B2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 56,
                'name' => 'Kỹ thuật điện tử - viễn thông',
                'code' => '7520207',
                'parent_id' => 5,
                'user_id' => 56,
                'description' => 'Ngành đào tạo kỹ sư điện tử viễn thông.',
                'phone' => '024.38522225',
                'email' => 'ktdtvt@tlu.edu.vn',
                'address' => 'Tòa nhà B2, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 57,
                'name' => 'Kỹ thuật Robot và Điều khiển thông minh',
                'code' => '7520206',
                'parent_id' => 5,
                'user_id' => 57,
                'description' => 'Ngành đào tạo về robot và điều khiển thông minh.',
                'phone' => '024.38522225',
                'email' => 'ktrobotdktm@tlu.edu.vn',
                'address' => 'Tòa nhà B2, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Công nghệ Thông tin - thuộc Khoa CNTT
            [
                'id' => 58,
                'name' => 'Công nghệ thông tin',
                'code' => '7480201',
                'parent_id' => 7,
                'user_id' => 58,
                'description' => 'Ngành đào tạo kỹ sư công nghệ thông tin.',
                'phone' => '024.38522235',
                'email' => 'cntt_major@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 59,
                'name' => 'Hệ thống thông tin',
                'code' => '7480104',
                'parent_id' => 7,
                'user_id' => 59,
                'description' => 'Ngành đào tạo về hệ thống thông tin và quản lý dữ liệu.',
                'phone' => '024.38522235',
                'email' => 'httt@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 60,
                'name' => 'Kỹ thuật phần mềm',
                'code' => '7480103',
                'parent_id' => 7,
                'user_id' => 60,
                'description' => 'Ngành đào tạo kỹ sư phần mềm.',
                'phone' => '024.38522235',
                'email' => 'ktpm@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 61,
                'name' => 'Trí tuệ nhân tạo và khoa học dữ liệu',
                'code' => '7480205',
                'parent_id' => 7,
                'user_id' => 61,
                'description' => 'Ngành đào tạo về AI và khoa học dữ liệu.',
                'phone' => '024.38522235',
                'email' => 'ttnt_khdl@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 62,
                'name' => 'An ninh mạng',
                'code' => '7480202',
                'parent_id' => 7,
                'user_id' => 62,
                'description' => 'Ngành đào tạo chuyên gia an ninh mạng.',
                'phone' => '024.38522235',
                'email' => 'anm@tlu.edu.vn',
                'address' => 'Tòa nhà C5, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Kinh tế - thuộc các Bộ môn của Khoa Kinh tế và quản lý
            [
                'id' => 63,
                'name' => 'Kinh tế',
                'code' => '7310101',
                'parent_id' => 14, // Bộ môn Kinh tế
                'user_id' => 63,
                'description' => 'Ngành đào tạo cử nhân kinh tế.',
                'phone' => '024.38522233',
                'email' => 'kinhte_major@tlu.edu.vn',
                'address' => 'P210 nhà A5',
                'level' => 3
            ],
            [
                'id' => 64,
                'name' => 'Kinh tế xây dựng',
                'code' => '7580301',
                'parent_id' => 15, // Bộ môn Kinh tế xây dựng
                'user_id' => 64,
                'description' => 'Ngành đào tạo về kinh tế trong lĩnh vực xây dựng.',
                'phone' => '024.38522234',
                'email' => 'ktxd_major@tlu.edu.vn',
                'address' => 'P211 nhà A5',
                'level' => 3
            ],
            [
                'id' => 65,
                'name' => 'Logistics và quản lí chuỗi cung ứng',
                'code' => '7510605',
                'parent_id' => 18, // Bộ môn Logistics và chuỗi cung ứng
                'user_id' => 65,
                'description' => 'Ngành đào tạo về logistics và quản lý chuỗi cung ứng.',
                'phone' => '024.38522237',
                'email' => 'logistics_major@tlu.edu.vn',
                'address' => 'P203-204-205 nhà A5',
                'level' => 3
            ],
            [
                'id' => 66,
                'name' => 'Thương mại điện tử',
                'code' => '7340122',
                'parent_id' => 12, // Bộ môn Thương mại điện tử
                'user_id' => 66,
                'description' => 'Ngành đào tạo về thương mại điện tử.',
                'phone' => '024.38522231',
                'email' => 'tmdt_major@tlu.edu.vn',
                'address' => 'P208 nhà A5',
                'level' => 3
            ],
            [
                'id' => 67,
                'name' => 'Kinh tế số',
                'code' => '7310109',
                'parent_id' => 17, // Bộ môn Kinh tế và kinh doanh số
                'user_id' => 67,
                'description' => 'Ngành đào tạo về kinh tế số và chuyển đổi số.',
                'phone' => '024.38522236',
                'email' => 'kinhteaso_major@tlu.edu.vn',
                'address' => 'P202 nhà A5',
                'level' => 3
            ],
            [
                'id' => 68,
                'name' => 'Tài chính – Ngân hàng',
                'code' => '7340201',
                'parent_id' => 27, // Bộ môn tài chính
                'user_id' => 68,
                'description' => 'Ngành đào tạo về tài chính ngân hàng.',
                'phone' => '024.38522258',
                'email' => 'tcnh_major@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 69,
                'name' => 'Chương trình Công nghệ tài chính',
                'code' => '7340201_FINTECH',
                'parent_id' => 27, // Bộ môn tài chính
                'user_id' => 69,
                'description' => 'Chương trình đào tạo về Fintech.',
                'phone' => '024.38522258',
                'email' => 'fintech@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 70,
                'name' => 'Kiểm toán',
                'code' => '7340302',
                'parent_id' => 26, // Bộ môn kiểm toán
                'user_id' => 70,
                'description' => 'Ngành đào tạo kiểm toán viên.',
                'phone' => '024.38522257',
                'email' => 'kiemtoan_major@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 71,
                'name' => 'Quản trị kinh doanh',
                'code' => '7340101',
                'parent_id' => 28, // Bộ Môn Quản trị kinh doanh
                'user_id' => 71,
                'description' => 'Ngành đào tạo về quản trị kinh doanh.',
                'phone' => '024.38522259',
                'email' => 'qtkd_major@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 72,
                'name' => 'Kế toán',
                'code' => '7340301',
                'parent_id' => 25, // Bộ môn kế toán
                'user_id' => 72,
                'description' => 'Ngành đào tạo kế toán viên.',
                'phone' => '024.38522256',
                'email' => 'ketoan_major@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 73,
                'name' => 'Chương trình Kế toán tích hợp chứng chỉ quốc tế',
                'code' => '7340301_ACCA',
                'parent_id' => 25, // Bộ môn kế toán
                'user_id' => 73,
                'description' => 'Chương trình kế toán tích hợp ACCA.',
                'phone' => '024.38522256',
                'email' => 'ketoan_acca@tlu.edu.vn',
                'address' => 'Tòa nhà A7, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 74,
                'name' => 'Quản trị dịch vụ du lịch và lữ hành',
                'code' => '7810103',
                'parent_id' => 13, // Bộ môn Quản trị du lịch
                'user_id' => 74,
                'description' => 'Ngành đào tạo về quản trị du lịch và lữ hành.',
                'phone' => '024.38522232',
                'email' => 'dulich_major@tlu.edu.vn',
                'address' => 'P209 nhà A5',
                'level' => 3
            ],

            // Khối Khoa học Tự nhiên - thuộc các Bộ môn của Khoa Hóa và Môi trường
            [
                'id' => 75,
                'name' => 'Kỹ thuật môi trường',
                'code' => '7520320',
                'parent_id' => 20, // Bộ môn Kỹ thuật và Quản lý Môi trường
                'user_id' => 75,
                'description' => 'Ngành đào tạo kỹ sư môi trường.',
                'phone' => '024.38522241',
                'email' => 'ktmt_major@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 76,
                'name' => 'Công nghệ sinh học',
                'code' => '7420201',
                'parent_id' => 22, // Bộ môn Công nghệ Sinh học
                'user_id' => 76,
                'description' => 'Ngành đào tạo về công nghệ sinh học.',
                'phone' => '024.38522243',
                'email' => 'cnsh_major@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 77,
                'name' => 'Kỹ thuật hóa học',
                'code' => '7520301',
                'parent_id' => 21, // Bộ môn Kỹ thuật Hóa học
                'user_id' => 77,
                'description' => 'Ngành đào tạo kỹ sư hóa học.',
                'phone' => '024.38522242',
                'email' => 'kthh_major@tlu.edu.vn',
                'address' => 'Tòa nhà D1, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Luật - thuộc Khoa Luật và Lý luận chính trị
            [
                'id' => 78,
                'name' => 'Luật',
                'code' => '7380101',
                'parent_id' => 9,
                'user_id' => 78,
                'description' => 'Ngành đào tạo cử nhân Luật.',
                'phone' => '024.38522245',
                'email' => 'luat_major@tlu.edu.vn',
                'address' => 'Tòa nhà A1, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 79,
                'name' => 'Luật kinh tế',
                'code' => '7380107',
                'parent_id' => 9,
                'user_id' => 79,
                'description' => 'Ngành đào tạo về luật kinh tế.',
                'phone' => '024.38522245',
                'email' => 'luatkt@tlu.edu.vn',
                'address' => 'Tòa nhà A1, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Khối Ngôn ngữ - thuộc Trung tâm Đào tạo quốc tế
            [
                'id' => 80,
                'name' => 'Ngôn ngữ Trung Quốc',
                'code' => '7220204',
                'parent_id' => 24, // Bộ môn ngôn ngữ Trung Quốc
                'user_id' => 80,
                'description' => 'Ngành đào tạo về ngôn ngữ Trung Quốc.',
                'phone' => '024.38522252',
                'email' => 'chinese_major@tlu.edu.vn',
                'address' => 'Tòa nhà A6, Trường Đại học Thủy lợi',
                'level' => 3
            ],
            [
                'id' => 81,
                'name' => 'Ngôn ngữ Anh',
                'code' => '7220201',
                'parent_id' => 23, // Bộ môn ngôn ngữ Anh
                'user_id' => 81,
                'description' => 'Ngành đào tạo về ngôn ngữ Anh.',
                'phone' => '024.38522251',
                'email' => 'english_major@tlu.edu.vn',
                'address' => 'Tòa nhà A6, Trường Đại học Thủy lợi',
                'level' => 3
            ],

            // Chương trình Tiên tiến
            [
                'id' => 82,
                'name' => 'Chương trình tiên tiến ngành Kỹ thuật xây dựng',
                'code' => '7580201_TT',
                'parent_id' => 2, // Thuộc trực tiếp Khoa Công trình
                'user_id' => 82,
                'description' => 'Chương trình tiên tiến ngành Kỹ thuật tài nguyên nước.',
                'phone' => '024.38522215',
                'email' => 'kttnr_tientien@tlu.edu.vn',
                'address' => 'Tòa nhà A3, Trường Đại học Thủy lợi',
                'level' => 3
            ]
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert([
                'id' => $department['id'],
                'name' => $department['name'],
                'code' => $department['code'],
                'parent_id' => $department['parent_id'],
                'user_id' => $department['user_id'],
                'description' => $department['description'],
                'phone' => $department['phone'],
                'email' => $department['email'],
                'address' => $department['address'],
                'level' => $department['level'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
