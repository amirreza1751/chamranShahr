<?php


namespace App\General;


class Constants
{
    /** notification_types */  /* Use as NotificationSample type */
    const EDUCATIONAL_NOTIFICATION = 'EDUCATIONAL_NOTIFICATION';
    const STUDIOUS_NOTIFICATION = 'STUDIOUS_NOTIFICATION';
    const COLLEGIATE_NOTIFICATION = 'COLLEGIATE_NOTIFICATION';
    const CULTURAL_NOTIFICATION = 'CULTURAL_NOTIFICATION';

    const notification_types = [
        self::EDUCATIONAL_NOTIFICATION => 'آموزشی',
        self::STUDIOUS_NOTIFICATION => 'پژوهشی',
        self::COLLEGIATE_NOTIFICATION => 'دانشجویی-رفاهی',
        self::CULTURAL_NOTIFICATION => 'فرهنگی',
    ];
    /** ************* */
}
