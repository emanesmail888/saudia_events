<?php

namespace App\Services;

use App\Models\User;
use App\Models\Service;

class SubscriptionService
{
    public function subscribe(User $user, Service $service)
    {
        if ($service->isFreePlan()) {
            // Only email is allowed for free plan
            $communicationChannels = ['email'];
        } else {
            // User can choose one or both communication channels for premium plan
            $communicationChannels = ['whatsapp', 'email'];
        }

        $user->services()->attach($service, ['communication_channels' => json_encode($communicationChannels)]);
    }
}