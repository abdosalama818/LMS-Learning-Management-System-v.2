<?php

namespace App\Interface;

interface ProfileInterface
{
    public function resetPassword($request);
    public function updateProfile($request);
}
