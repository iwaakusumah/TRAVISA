<?php

namespace App\Enums;

enum Role: string
{
    case HOMEROOM_TEACHER = 'homeroom_teacher';
    case HEADMASTER = 'headmaster';
    case STAFF_STUDENT = 'staff_student';
    case ADMINISTRATOR = 'administrator';
}
