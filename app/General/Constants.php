<?php


namespace App\General;


class Constants
{
    /** user_types */  /* Use as NotificationSample type */
    const ALL_USERS = 'ALL_USERS';
    const STUDENTS = 'STUDENTS';
    const EMPLOYEES = 'EMPLOYEES';
    const PROFESSORS = 'PROFESSORS';

    const user_types = [
        self::ALL_USERS => 'همه‌ی کاربران',
        self::STUDENTS => 'دانشجویان',
//        self::EMPLOYEES => 'کارکنان',
//        self::PROFESSORS => 'اساتید',
    ];
    /** ************* */

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
