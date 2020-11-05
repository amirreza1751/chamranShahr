<?php

namespace App\Console\Commands;

use App\General\ConsoleColor;
use App\General\GeneralFunction;
use App\Models\Department;
use App\Models\ManageLevel;
use Illuminate\Console\Command;

class DepartmentInitial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'department:initial';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cc = new ConsoleColor();
        $gf = new GeneralFunction();
        $cc->print_error("this procedure will truncate \"departments\" table which may permanently delete some records, also affected some other functionality relative to users and other tables!\nDo you want to continue? (pls type\t\tHellYeah\t\tto continue or anything to skip)");
        $answer = trim(fgets(STDIN));
        if ($answer == 'HellYeah') {

            $gf->truncate([
                'departments'],
                false);

            $campus_department = Department::create([
                'title' => 'تیم توسعه‌ی چران‌شهر',
                'english_title' => 'Chamranshahr Development Team',
                'description' => 'این تیم که هسته‌ی مرکزی آن متشکل از فارغ التحصیلان و دانشجویان دانشگاه شهید چمران اهواز است می‌کوشد تا با به کار گیری تکنولوژی روز در زمینه تولید و توسعه‌ی نرم‌افزار در جهت ارائه‌ی خدمات دانشگاهی به دانشجویان عزیز و دیگر اعضای محترم جامعه‌ی دانشگاهی گام بردارد.
سامانه‌ی چمران‌شهر یک بستر دانشگاهی بومی و منحصر به فرد است که تا کنون یک فاز از آن به مرحله‌ی اجرا رسیده و همچان در فرایند توسعه می‌باشد.

انتقادات و پیشنهادات سازنده‌ی کاربران محترم موجب پیشرفت هرچه بیشتر این سامانه خواهد بود.',
                'path' => env('CAMPUS_DEPARTMENT_IMAGE'),
                'manage_level_id' => ManageLevel::where('level', 0.0)->first()->id,
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new department:\t" . $cc->getColoredString($campus_department->title."\t".$campus_department->english_title, $cc::CREATE) ."\n");

            $scu_department = Department::create([
                'title' => 'دانشگاه شهید چمران اهواز',
                'english_title' => 'Shahid Chamran University of Ahvaz',
                'description' => 'افتخارات عظیم و با­شکوه تاریخ تمدن و فرهنگ ایران زمین، بیانگر وجود مراکز دانش در انواع علوم بوده است. مراکز برجسته علمی همچون دانشگاه جندی شاپور در استان خوزستان که در سال پانصد و سی میلادی تأسیس یافت، دلیلی براین مدعاست. پس از پیروزی ایرانیان بر امپراطور روم، یکی از پادشاهان ساسانی(شاپوراول) دستور بنای شهر جندی شاپور را در ۱۸ کیلومتری جنوب غرب دزفول صادر کرد. وی بر این شهر نام بهاندیو یعنی بهتر از انطاکیه (پایتخت روم شرقی) را نهاد. سپس در این شهر، دانشگاهی به همین نام تأسیس گردید. درآن ایام علوم مختلفی ازجمله پزشکی، فلسفه، الهیات، ریاضیات، موسیقی، کشورداری و کشاورزی دراین دانشگاه تدریس می­شد. بر این اساس گفته می-شود که دانشکده­ی پزشکی دانشگاه جندی شاپور به عنوان یکی از قدیمی­ترین دانشکده­های پزشکی جهان مطرح بوده است و دانشمندان زیادی از ملیت­های ایرانی و هندی درآن تدریس می­کرده­اند و توسط آنان چندین کتاب پزشکی به زبان پهلوی ترجمه گردیده است.

پس ازآن دوره­ی چشمگیر، حیات دوباره دانشگاه از سال ۱۳۳۴ هجری شمسی با ایجاد دانشکده کشاورزی و پذیرش ۴۰ دانشجو در دوره جدید آغاز شد. سپس در سال ۱۳۳۵ مقدمات ایجاد دانشکده پزشکی فراهم آمد و به­تدریج سایر دانشکده­ها از آن پس فعال شدند. تا قبل از پیروزی شکوهمند انقلاب اسلامی در سال ۱۳۵۷ این دانشگاه نزدیک به ۴ هزار دانشجوی مشغول به تحصیل در ۴۰ رشته تحصیلی در مقطع لیسانس و ۱۷ رشته تحصیلی در مقطع فوق لیسانس داشته است. پس از انقلاب و در دوران جنگ تحمیلی این دانشگاه یکی از پایگاه­های اصلی رزمندگان اسلام در دفاع مقدس به شمار می­رفت و مقر اصلی شهید دکتر چمران بود. پس از به شهادت رسیدن این سردار بزرگ و به پاس بزرگداشت نام و خاطره آن مرد، نام دانشگاه جندی شاپور به دانشگاه شهید چمران اهواز تغییر یافت.

در حال حاضر دانشگاه شهید چمران دارای ۱۳ دانشکده با ۵۳ گروه آموزشی شامل ۲۲ گروه علوم انسانی، ۷ گروه علوم پایه، ۷گروه فنی و مهندسی، ۱۳گروه علوم کشاورزی و دامپزشکی و ۲گروه هنر می­باشد. این گروه­ها مجموعاً شامل ۳ رشته در مقطع کاردانی، ۵۶ رشته در مقطع کارشناسی، ۱۰۷ رشته در مقطع کارشناسی ارشد، ۵۹ رشته در مقطع دکتری تخصصی و یک رشته در مقطع دکتری حرفه­ای هستند. بیش از ۵۰۰ نفر عضو هیات علمی در دانشگاه مشغول آموزش و پژوهش هستند که حدود ۸۰ درصد از آنها دارای رتبه استادیاری و بالاتر می­باشند. هم­چنین بیش از ۱۶ هزار دانشجو از مقطع کاردانی تا دکتری تخصصی در این دانشگاه مشغول تحصیل اند که از این تعداد ۴۰۰۰ دانشجوی تحصیلات تکمیلی هستند. از سال ۱۳۹۱ واحد پردیس دانشگاهی راه اندازی گردیده و در حال حاضر بیش از ۴۰۰ نفر دانشجوی تحصیلات تکمیلی نیز در این واحد مشغول به تحصیل هستند. شایان ذکر است که در حال حاضر دانشگاه شهید چمران اهواز با در اختیار داشتن فضای آموزشی بسیار وسیع و مناسب یکی از چهار دانشگاه بزرگ کشور و بزرگ­ترین دانشگاه در جنوب غرب کشورمان به شمار آمده و در زمره دانشگاه­های جامع کشور قرار دارد.',
                'path' => env('SCU_DEPARTMENT_IMAGE'),
                'manage_level_id' => ManageLevel::where('level', 1.0)->first()->id,
            ]);
            printf($cc->getColoredString("-\tadd\t", $cc::CREATE) . "new department:\t" . $cc->getColoredString($scu_department->title."\t".$scu_department->english_title, $cc::CREATE) ."\n");

        } else {
            $cc->print_warning("\nno changes has been made; good luck...");
        }
    }
}
