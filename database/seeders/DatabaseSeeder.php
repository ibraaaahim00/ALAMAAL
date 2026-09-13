<?php

namespace Database\Seeders;

use App\Enums\BehavioralChallenge;
use App\Enums\ChildCondition;
use App\Enums\ChildGender;
use App\Enums\DesiredGoal;
use App\Enums\IndependenceLevel;
use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Enums\ServiceType;
use App\Enums\SpeechLevel;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Models\Advice;
use App\Models\Child;
use App\Models\ContactMessage;
use App\Models\Coupon;
use App\Models\EducationalContent;
use App\Models\NewsletterSubscriber;
use App\Models\Order;
use App\Models\OrderAttachment;
use App\Models\Review;
use App\Models\Service;
use App\Models\Specialist;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Users
        $admin = User::firstOrCreate(
            ['email' => 'admin@alamaal.com'],
            [
                'name' => 'مدير النظام',
                'phone' => '0500000000',
                'password' => Hash::make('password123'),
                'role' => UserRole::Admin,
                'status' => UserStatus::Active,
            ]
        );

        $parent = User::firstOrCreate(
            ['email' => 'saad@example.com'],
            [
                'name' => 'سعد بن محمد',
                'phone' => '0501234567',
                'password' => Hash::make('12345678'),
                'role' => UserRole::User,
                'status' => UserStatus::Active,
                'avatar' => 'images/avatar-user.png',
            ]
        );

        // 2. Child info for parent
        Child::firstOrCreate(
            ['user_id' => $parent->id],
            [
                'name' => 'خالد سعد',
                'date_of_birth' => '2019-04-15',
                'gender' => ChildGender::Male,
                'condition' => ChildCondition::Autism,
                'speech_level' => SpeechLevel::Low,
                'behavioral_challenge' => BehavioralChallenge::Hyperactivity,
                'independence' => IndependenceLevel::Partially,
                'desired_goal' => DesiredGoal::Communication,
            ]
        );

        // 3. Specialists
        $spec1 = Specialist::firstOrCreate(
            ['name' => 'محمد عبد الله'],
            [
                'title' => 'أخصائي تخاطب ونطق',
                'specialty' => 'طيف التوحد',
                'email' => 'm.abdallah@alamaal.com',
                'phone' => '0551112233',
            ]
        );

        $spec2 = Specialist::firstOrCreate(
            ['name' => 'احمد محمد'],
            [
                'title' => 'أخصائي نفسي وتربوي',
                'specialty' => 'متلازمة داون',
                'email' => 'a.mohamed@alamaal.com',
                'phone' => '0552223344',
            ]
        );

        $spec3 = Specialist::firstOrCreate(
            ['name' => 'محمود محمد احمد'],
            [
                'title' => 'استشاري تأهيل وتعديل سلوك',
                'specialty' => 'تعديل السلوك والاستشارات',
                'email' => 'm.ahmed@alamaal.com',
                'phone' => '0553334455',
            ]
        );

        // 4. Core Services
        $autismService = Service::firstOrCreate(
            ['slug' => 'autism-children'],
            [
                'title' => 'أطفال التوحد',
                'title_en' => 'Autism Children',
                'description' => 'برامج تأهيل متخصصة لدعم أطفال التوحد وتنمية مهارات التواصل والسلوك والاستقلالية، وفق خطط فردية تناسب كل طفل .',
                'description_en' => 'Specialized rehabilitation programs to support children with autism and develop communication, behavior, and independence skills.',
                'image' => 'images/service-autism.png',
                'price' => 250.00,
                'type' => ServiceType::Autism,
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $downService = Service::firstOrCreate(
            ['slug' => 'down-syndrome'],
            [
                'title' => 'متلازمة داون',
                'title_en' => 'Down Syndrome',
                'description' => 'برامج تدريب وتأهيل تساعد أطفال متلازمة داون على تنمية مهاراتهم الذهنية والحركية والاجتماعية بثقة .',
                'description_en' => 'Training and rehabilitation programs that help children with Down syndrome confidently develop their mental, motor, and social skills.',
                'image' => 'images/service-down-syndrome.png',
                'price' => 350.00,
                'type' => ServiceType::DownSyndrome,
                'is_active' => true,
                'sort_order' => 2,
            ]
        );

        $consultationService = Service::firstOrCreate(
            ['slug' => 'consultations'],
            [
                'title' => 'الاستشارات',
                'title_en' => 'Consultations',
                'description' => 'احجز استشارة مع مختص لمساعدتك في فهم حالة طفلك والحصول على إرشادات عملية وخطة دعم مناسبة .',
                'description_en' => 'Book a consultation with a specialist to help you understand your child\'s condition and get practical guidance.',
                'image' => 'images/service-consultation.png',
                'price' => 450.00,
                'type' => ServiceType::Consultation,
                'is_active' => true,
                'sort_order' => 3,
            ]
        );

        // 5. Coupons
        Coupon::firstOrCreate(
            ['code' => 'HOPE20'],
            [
                'discount_type' => 'percentage',
                'discount_value' => 20,
                'max_uses' => 500,
                'is_active' => true,
            ]
        );

        Coupon::firstOrCreate(
            ['code' => 'ALAMAAL50'],
            [
                'discount_type' => 'fixed',
                'discount_value' => 50,
                'max_uses' => 200,
                'is_active' => true,
            ]
        );

        // 6. Sample Orders matching mockup
        $order1 = Order::firstOrCreate(
            ['order_number' => '126574'],
            [
                'user_id' => $parent->id,
                'service_id' => $autismService->id,
                'specialist_id' => $spec1->id,
                'request_title' => 'محمد احمد محمد',
                'customer_name' => 'سعد بن محمد',
                'customer_phone' => '0501234567',
                'subtotal' => 250.00,
                'discount' => 0.00,
                'total' => 250.00,
                'payment_method' => PaymentMethod::Visa,
                'payment_status' => PaymentStatus::Paid,
                'status' => OrderStatus::InProgress,
                'management_response' => 'هذا نموذج افتراضي يوضح الخطة التأهيلية المعتمدة للطفل، تم دراسة الحالة بدقة ووضع جدول تدريبي مكثف لتنمية مهارات التواصل البصري واللفظي وفق أعلى المعايير.',
            ]
        );

        OrderAttachment::firstOrCreate(
            ['order_id' => $order1->id, 'file_name' => 'صورة نهائي 005. png صورة'],
            [
                'file_path' => 'images/service-autism.png',
                'file_type' => 'image',
                'file_size' => '5 MB',
            ]
        );
        OrderAttachment::firstOrCreate(
            ['order_id' => $order1->id, 'file_name' => 'ملف نهائي 005. عقد pdf'],
            [
                'file_path' => 'images/service-autism.png',
                'file_type' => 'pdf',
                'file_size' => '1.5 MB',
            ]
        );
        OrderAttachment::firstOrCreate(
            ['order_id' => $order1->id, 'file_name' => 'فيديو نهائي mp4'],
            [
                'file_path' => 'images/service-autism.png',
                'file_type' => 'video',
                'file_size' => '15 MB',
            ]
        );

        Order::firstOrCreate(
            ['order_number' => '658721'],
            [
                'user_id' => $parent->id,
                'service_id' => $downService->id,
                'specialist_id' => $spec2->id,
                'request_title' => 'طلب تدريب وتأهيل متلازمة داون',
                'customer_name' => 'سعد بن محمد',
                'customer_phone' => '0501234567',
                'subtotal' => 350.00,
                'discount' => 0.00,
                'total' => 350.00,
                'payment_method' => PaymentMethod::Mada,
                'payment_status' => PaymentStatus::Paid,
                'status' => OrderStatus::Pending,
            ]
        );

        $order3 = Order::firstOrCreate(
            ['order_number' => '197364'],
            [
                'user_id' => $parent->id,
                'service_id' => $autismService->id,
                'specialist_id' => $spec3->id,
                'request_title' => 'جلسات نطق وتخاطب',
                'customer_name' => 'سعد بن محمد',
                'customer_phone' => '0501234567',
                'subtotal' => 250.00,
                'discount' => 0.00,
                'total' => 250.00,
                'payment_method' => PaymentMethod::ApplePay,
                'payment_status' => PaymentStatus::Paid,
                'status' => OrderStatus::Completed,
                'management_response' => 'تم استكمال برنامج الجلسات التأهيلية للطفل بنجاح ملحوظ في التفاعل الاجتماعي واستجابة الأوامر البسيطة.',
                'completed_at' => now()->subDays(2),
            ]
        );

        Review::firstOrCreate(
            ['order_id' => $order3->id],
            [
                'user_id' => $parent->id,
                'service_id' => $autismService->id,
                'rating' => 5,
                'comment' => 'تجربة ممتازة ونتائج رائعة مع طفلي، شكرًا لفريق جسر الأمل.',
                'is_featured' => true,
            ]
        );

        Order::firstOrCreate(
            ['order_number' => '784129'],
            [
                'user_id' => $parent->id,
                'service_id' => $consultationService->id,
                'specialist_id' => $spec2->id,
                'request_title' => 'استشارة سلوكية وتربوية',
                'customer_name' => 'سعد بن محمد',
                'customer_phone' => '0501234567',
                'subtotal' => 450.00,
                'discount' => 0.00,
                'total' => 450.00,
                'payment_method' => PaymentMethod::Visa,
                'payment_status' => PaymentStatus::Paid,
                'status' => OrderStatus::InProgress,
            ]
        );

        // 7. Testimonials
        $testimonials = [
            [
                'client_name' => 'أحمد محمد',
                'client_title' => 'ولي أمر',
                'rating' => 4.9,
                'content' => 'تجربة رائعة مع جسر الأمل، فريق متخصص ومهتم بتطوير قدرات الأطفال بشكل ملحوظ.',
            ],
            [
                'client_name' => 'سارة علي',
                'client_title' => 'ولي أمر',
                'rating' => 4.9,
                'content' => 'فريق رائع ومنصة ممتازة للتواصل مع المختصين ومتابعة حالة الطفل بسهولة.',
            ],
            [
                'client_name' => 'خالد عبد الله',
                'client_title' => 'ولي أمر',
                'rating' => 5.0,
                'content' => 'الخطط العلاجية دقيقة ومفصلة وساعدتنا كثيرًا في التعامل مع نوبات الغضب وتحسين التخاطب.',
            ],
            [
                'client_name' => 'فاطمة إبراهيم',
                'client_title' => 'أخصائية تربية خاصة',
                'rating' => 4.9,
                'content' => 'منصة رائدة توفر مرجعًا علميًا متكاملًا وتسهل متابعة تقدم الأطفال مع أسرهم.',
            ],
        ];

        foreach ($testimonials as $item) {
            Testimonial::firstOrCreate(['client_name' => $item['client_name']], $item);
        }

        // 8. Educational Contents
        $educationalArticles = [
            [
                'slug' => 'down-syndrome-animations',
                'title' => 'رسوم متحركة عن متلازمة داون',
                'description' => 'برامج بصرية ورسوم متحركة تفاعلية مصممة خصيصاً لتعزيز الاستيعاب الذهني والإدراكي لدى أطفال متلازمة داون.',
                'target_category' => 'down',
                'thumbnail' => 'images/service-autism.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'ينصح بمشاهدة الفيديو مع الطفل لمدة 15 دقيقة يومياً مع تكرار الألفاظ والإشارات المصاحبة.',
                'guidance_steps' => '1. تهيئة بيئة هادئة خالية من المشتتات.\n2. تشجيع الطفل بالثناء عند التفاعل.\n3. تطبيق الأنشطة الحركية عملياً بعد انتهاء الفيديو.',
                'published_at' => '2025-03-12',
            ],
            [
                'slug' => 'take-my-hand',
                'title' => 'خذ بيدي',
                'description' => 'دليل عملي للآباء والأمهات للتدخل المبكر وبناء جسور التواصل اليومي مع الأطفال ذوي الاحتياجات الخاصة.',
                'target_category' => 'general',
                'thumbnail' => 'images/service-down-syndrome.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'إرشادات مبسطة خطوة بخطوة للتعامل الإيجابي وتطوير المهارات الاجتماعية.',
                'guidance_steps' => '1. التواصل البصري المستمر.\n2. استخدام جمل قصيرة وواضحة.\n3. التحفيز المعنوي والمكافآت الرمزية.',
                'published_at' => '2025-03-10',
            ],
            [
                'slug' => 'touches-of-creativity',
                'title' => 'لمسات ابداع تبحث عمن ينميها',
                'description' => 'اكتشاف المواهب الكامنة لدى أطفال طيف التوحد في الرسم والموسيقى والرياضيات وكيفية رعايتها وصقلها.',
                'target_category' => 'autism',
                'thumbnail' => 'images/service-consultation.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'طرق فعالة لتحويل اهتمامات الطفل المحددة إلى مسارات إبداعية منتجة.',
                'guidance_steps' => '1. توفير أدوات التعبير الفني المناسبة.\n2. تشجيع الابتكار دون فرض قيود صارمة.\n3. توثيق إنجازات الطفل وتعزيز ثقته بنفسه.',
                'published_at' => '2025-03-08',
            ],
            [
                'slug' => 'daily-speech-therapy',
                'title' => 'تمارين النطق والتخاطب في المنزل',
                'description' => 'مجموعة من التمارين اليومية السهلة لتقوية عضلات النطق وتحفيز إخراج الحروف السليمة لدى الأطفال.',
                'target_category' => 'autism',
                'thumbnail' => 'images/service-autism.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'تطبيق التمارين لمدة 10 دقائق صباحاً ومساءً.',
                'guidance_steps' => '1. استخدام المرآة لمراقبة حركة الفم.\n2. ألعاب النفخ والتصفير لتقوية العضلات.\n3. تكرار المقاطع الصوتية بنغمات محببة للطفل.',
                'published_at' => '2025-03-05',
            ],
            [
                'slug' => 'social-skills-integration',
                'title' => 'دمج الأطفال في الأنشطة الاجتماعية',
                'description' => 'خطوات مجربة لمساعدة الطفل على التفاعل مع أقرانه في الحدائق والمدارس والزيارات العائلية بثقة وهدوء.',
                'target_category' => 'general',
                'thumbnail' => 'images/service-down-syndrome.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'التدرج في التفاعل الاجتماعي بدءاً من الأماكن المألوفة إلى البيئات الأوسع.',
                'guidance_steps' => '1. التمهيد المسبق للطفل قبل الزيارة.\n2. مشاركة الألعاب الجماعية الممتعة.\n3. التدخل الهادئ عند شعور الطفل بالإجهاد.',
                'published_at' => '2025-03-01',
            ],
            [
                'slug' => 'positive-behavior-modification',
                'title' => 'تعديل السلوك بالتعزيز الإيجابي',
                'description' => 'استراتيجيات علمية للتعامل مع السلوكيات غير المرغوبة واستبدالها بسلوكيات إيجابية مستدامة.',
                'target_category' => 'down',
                'thumbnail' => 'images/service-consultation.png',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'instructions' => 'التركيز على مدح السلوك الجيد وتجاهل المحاولات البسيطة للفت الانتباه.',
                'guidance_steps' => '1. وضع قواعد واضحة وثابتة.\n2. الثناء الفوري عند التصرف الصحيح.\n3. استخدام جداول النجوم والمكافآت.',
                'published_at' => '2025-02-28',
            ],
        ];

        foreach ($educationalArticles as $art) {
            EducationalContent::firstOrCreate(['slug' => $art['slug']], $art);
        }

        // 9. Advices with Years and Months
        $advicesData = [
            // 2026
            ['title' => 'الرسوم المتحركة حول داون', 'thumbnail' => 'images/service-autism.png', 'year' => 2026, 'month' => 'january', 'published_at' => '2026-01-12'],
            ['title' => 'تنمية المهارات الحركية الدقيقة', 'thumbnail' => 'images/service-down-syndrome.png', 'year' => 2026, 'month' => 'january', 'published_at' => '2026-01-15'],
            ['title' => 'طرق التعامل مع نوبات الغضب', 'thumbnail' => 'images/service-consultation.png', 'year' => 2026, 'month' => 'february', 'published_at' => '2026-02-05'],
            ['title' => 'جدول الأنشطة البصري اليومي', 'thumbnail' => 'images/service-autism.png', 'year' => 2026, 'month' => 'february', 'published_at' => '2026-02-18'],
            ['title' => 'تعزيز التركيز والانتباه', 'thumbnail' => 'images/service-down-syndrome.png', 'year' => 2026, 'month' => 'march', 'published_at' => '2026-03-01'],
            ['title' => 'التغذية الصحية لأطفال التوحد', 'thumbnail' => 'images/service-consultation.png', 'year' => 2026, 'month' => 'march', 'published_at' => '2026-03-10'],

            // 2025
            ['title' => 'أهمية التشخيص المبكر', 'thumbnail' => 'images/service-autism.png', 'year' => 2025, 'month' => 'december', 'published_at' => '2025-12-10'],
            ['title' => 'مهارات الاستقلالية وارتداء الملابس', 'thumbnail' => 'images/service-down-syndrome.png', 'year' => 2025, 'month' => 'november', 'published_at' => '2025-11-20'],
            ['title' => 'تدريب الطفل على استخدام الحمام', 'thumbnail' => 'images/service-consultation.png', 'year' => 2025, 'month' => 'october', 'published_at' => '2025-10-15'],

            // 2024
            ['title' => 'التكامل الحسي وألعاب الرمال والماء', 'thumbnail' => 'images/service-autism.png', 'year' => 2024, 'month' => 'may', 'published_at' => '2024-05-14'],
            ['title' => 'التواصل غير اللفظي ولغة الإشارة المبسطة', 'thumbnail' => 'images/service-down-syndrome.png', 'year' => 2024, 'month' => 'april', 'published_at' => '2024-04-22'],

            // 2023
            ['title' => 'أثر الموسيقى والإيقاع في تحفيز النطق', 'thumbnail' => 'images/service-consultation.png', 'year' => 2023, 'month' => 'august', 'published_at' => '2023-08-11'],

            // 2022
            ['title' => 'توجيهات نفسية لأولياء الأمور الجدد', 'thumbnail' => 'images/service-autism.png', 'year' => 2022, 'month' => 'june', 'published_at' => '2022-06-03'],
        ];

        foreach ($advicesData as $adv) {
            Advice::firstOrCreate(
                ['title' => $adv['title'], 'year' => $adv['year'], 'month' => $adv['month']],
                array_merge($adv, ['video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ'])
            );
        }

        // 10. Contact messages sample
        ContactMessage::firstOrCreate(
            ['email' => 'parent.test@example.com'],
            [
                'full_name' => 'عبد العزيز السالم',
                'phone' => '0567890123',
                'message' => 'أود الاستفسار عن برامج التأهيل الفردية لأطفال التوحد وأوقات المواعيد المتاحة.',
                'status' => 'new',
            ]
        );

        // 11. Newsletter subscribers sample
        NewsletterSubscriber::firstOrCreate(['email' => 'subscriber1@example.com']);
        NewsletterSubscriber::firstOrCreate(['email' => 'subscriber2@example.com']);
    }
}
